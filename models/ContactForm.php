<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\mail\MailerInterface;

/**
 * ContactForm handles validation, sanitisation, email dispatch and enquiry logging
 * for NJ INTERIORS portfolio enquiries.
 */
class ContactForm extends Model
{
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $projectType = '';
    public string $message = '';
    /**
     * Honeypot field for unobtrusive spam protection (must remain empty).
     */
    public string $website = '';

    public static function projectTypeOptions(): array
    {
        return [
            'Residential Interiors' => 'Residential Interiors (Apartment / Villa / Renovation)',
            'Modular Kitchen & Custom Joinery' => 'Modular Kitchen & Custom Furniture / Joinery',
            'Hospitality & Commercial Interiors' => 'Hospitality & Commercial Fit-Out',
            'Ceilings, Walls & Finishes' => 'Ceilings, Walls & Interior Finishes',
            'Design & 3D Visualisation' => 'Design & 3D Visualisation Consultation',
            'Architect / Developer Partnership' => 'Architect / Developer Execution Partnership',
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'phone', 'email', 'projectType', 'message'], 'required'],
            [['name', 'phone', 'email', 'projectType', 'message', 'website'], 'trim'],
            [
                ['name', 'phone', 'projectType', 'message'],
                'filter',
                'filter' => static fn($value): string => trim(strip_tags((string) $value)),
            ],
            ['name', 'string', 'min' => 2, 'max' => 120],
            ['email', 'email'],
            ['email', 'string', 'max' => 160],
            [
                'phone',
                'match',
                'pattern' => '/^[0-9+\-\s()]{7,22}$/',
                'message' => 'Please enter a valid phone or WhatsApp number.',
            ],
            [
                'projectType',
                'in',
                'range' => array_keys(self::projectTypeOptions()),
                'message' => 'Please select a valid project category.',
            ],
            ['message', 'string', 'min' => 10, 'max' => 3000],
            ['website', 'string', 'max' => 0, 'message' => 'Spam check failed.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Full Name',
            'phone' => 'Phone Number',
            'email' => 'Email Address',
            'projectType' => 'Project Type',
            'message' => 'Project Brief / Message',
        ];
    }

    /**
     * Validates and dispatches the enquiry via Yii2 Mailer and local JSONL audit log.
     *
     * @return array{success: bool, liveSmtp: bool, message: string}
     */
    public function submitEnquiry(MailerInterface $mailer, string $targetEmail, string $senderEmail, string $senderName): array
    {
        if (!$this->validate()) {
            return [
                'success' => false,
                'liveSmtp' => false,
                'message' => 'Please check the highlighted form fields and try again.',
            ];
        }

        // Honeypot spam trap
        if ($this->website !== '') {
            return [
                'success' => false,
                'liveSmtp' => false,
                'message' => 'Submission rejected by spam protection.',
            ];
        }

        $subject = sprintf('[NJ INTERIORS Enquiry] %s — %s', $this->projectType, $this->name);
        $bodyText = implode("\n", [
            'NJ INTERIORS — PORTFOLIO ENQUIRY',
            '==================================================',
            'Full Name    : ' . $this->name,
            'Phone Number : ' . $this->phone,
            'Email        : ' . $this->email,
            'Project Type : ' . $this->projectType,
            'Submitted At : ' . date('Y-m-d H:i:s T'),
            '--------------------------------------------------',
            'Message / Project Brief:',
            $this->message,
            '==================================================',
        ]);

        $mailSent = false;
        $isFileTransport = true;

        try {
            if (property_exists($mailer, 'useFileTransport')) {
                $isFileTransport = (bool) $mailer->useFileTransport;
            }

            $mailSent = $mailer->compose()
                ->setTo($targetEmail)
                ->setFrom([$senderEmail => $senderName])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($subject)
                ->setTextBody($bodyText)
                ->send();
        } catch (\Throwable $e) {
            Yii::error('Enquiry mail error: ' . $e->getMessage(), __METHOD__);
        }

        // Persist enquiry record in runtime/enquiries/enquiries.jsonl for zero data loss
        try {
            $logDir = Yii::getAlias('@runtime/enquiries');
            FileHelper::createDirectory($logDir, 0775, true);
            $record = json_encode([
                'timestamp' => date('c'),
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'projectType' => $this->projectType,
                'message' => $this->message,
                'mailSent' => $mailSent,
                'transport' => $isFileTransport ? 'fileTransport' : 'smtp',
                'ip' => Yii::$app->request->userIP ?? '127.0.0.1',
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            file_put_contents($logDir . DIRECTORY_SEPARATOR . 'enquiries.jsonl', $record . PHP_EOL, FILE_APPEND | LOCK_EX);
        } catch (\Throwable $e) {
            Yii::warning('Could not write enquiry log: ' . $e->getMessage(), __METHOD__);
        }

        $liveSmtp = !$isFileTransport && $mailSent;

        if ($liveSmtp) {
            $msg = 'Thank you, ' . $this->name . '. Your enquiry has been sent to NJ INTERIORS (njinteriorbbs@gmail.com).';
        } else {
            $msg = 'Thank you, ' . $this->name . '. Your enquiry has been validated and recorded in the server runtime mail queue (configure SMTP_DSN in config/web.php for live external email delivery), or click the WhatsApp button to message Nitesh Jangda directly.';
        }

        return [
            'success' => true,
            'liveSmtp' => $liveSmtp,
            'message' => $msg,
        ];
    }
}
