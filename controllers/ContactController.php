<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use app\models\ContactForm;
use yii\filters\VerbFilter;
use yii\mail\MailerInterface;
use yii\web\Controller;
use yii\web\Response;

/**
 * ContactController handles enquiries submitted from the single-page portfolio.
 */
class ContactController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'submit' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Redirects standalone GET /contact requests to the single-page contact section.
     */
    public function actionIndex(): Response
    {
        return $this->redirect(['/site/index', '#' => 'contact']);
    }

    /**
     * Processes POST enquiries with CSRF validation, input sanitisation and JSON/HTML response.
     */
    public function actionSubmit(): Response|array
    {
        $model = new ContactForm();
        $loaded = $model->load($this->request->post(), 'ContactForm')
            || $model->load($this->request->post(), '');

        $targetEmail = (string) (Yii::$app->params['adminEmail'] ?? 'njinteriorbbs@gmail.com');
        $senderEmail = (string) (Yii::$app->params['senderEmail'] ?? 'njinteriorbbs@gmail.com');
        $senderName = (string) (Yii::$app->params['senderName'] ?? 'NJ INTERIORS Portfolio');

        $result = $loaded
            ? $model->submitEnquiry($this->mailer, $targetEmail, $senderEmail, $senderName)
            : [
                'success' => false,
                'liveSmtp' => false,
                'message' => 'Invalid enquiry payload received.',
            ];

        if ($this->request->isAjax || str_contains((string) $this->request->headers->get('Accept'), 'application/json')) {
            $this->response->format = Response::FORMAT_JSON;
            return [
                'success' => $result['success'],
                'liveSmtp' => $result['liveSmtp'],
                'message' => $result['message'],
                'errors' => $model->getErrors(),
            ];
        }

        Yii::$app->session->setFlash($result['success'] ? 'success' : 'error', $result['message']);
        return $this->redirect(['/site/index', '#' => 'contact']);
    }
}
