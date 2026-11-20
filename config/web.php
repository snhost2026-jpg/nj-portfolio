<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

// Optional SMTP DSN from environment variable (e.g., smtp://user:pass@smtp.gmail.com:587)
// If not set, Yii2 uses fileTransport (saving emails safely to runtime/mail/)
$smtpDsn = getenv('SMTP_DSN') ?: null;

$mailerConfig = [
    'class' => \yii\symfonymailer\Mailer::class,
    'useFileTransport' => empty($smtpDsn),
    'viewPath' => '@app/mail',
];

if (!empty($smtpDsn)) {
    $mailerConfig['transport'] = [
        'dsn' => $smtpDsn,
    ];
}

$config = [
    'id' => 'nj-interiors-portfolio',
    'name' => 'NJ INTERIORS',
    'language' => 'en-IN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'container' => [
        'singletons' => [
            \yii\mail\MailerInterface::class => $mailerConfig,
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '1Fvr8xVKmwp38dycvCVuHdvpHbGpa2pX',
            'enableCsrfValidation' => true,
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'user' => [
            'identityClass' => \app\models\User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => \yii\mail\MailerInterface::class,
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];

if (YII_ENV_DEV && is_readable(dirname(__DIR__) . '/vendor/yiisoft/yii2/assets')) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
    ];
}

return $config;
