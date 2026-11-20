<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\helpers\Url;

$this->render('_head');

$company = Yii::$app->params['company'] ?? [];
$assets = Yii::$app->params['assets'] ?? [];

$jsonLd = [
    '@context' => 'https://schema.org',
    '@type' => 'InteriorDesignBusiness',
    'name' => $company['brandName'] ?? 'NJ INTERIORS',
    'legalName' => $company['legalName'] ?? 'Nitesh Kumar Jangda',
    'slogan' => $company['tagline'] ?? 'CRAFTING LUXURY WITH CARE',
    'foundingDate' => '2016',
    'founder' => [
        '@type' => 'Person',
        'name' => 'Nitesh Kumar Jangda',
        'jobTitle' => 'Creative Director & Proprietor',
    ],
    'description' => 'Established in 2016, NJ INTERIORS is a Bhubaneswar-based interior design and execution firm creating refined residential, hospitality, commercial, and custom joinery interiors.',
    'url' => $company['canonicalUrl'] ?? 'https://njinteriors.in/',
    'telephone' => $company['phonePrimary'] ?? '+91 95832 05010',
    'email' => $company['email'] ?? 'njinteriorbbs@gmail.com',
    'taxID' => $company['gstin'] ?? '21AZTPJ1827C1ZN',
    'image' => Url::to($assets['projects']['living'] ?? '@web/images/projects/residential/living-tv-wall.webp', true),
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'O-5, Ground Floor, Aster Block, D.N. OxyPark, Cosmopolis Road, Dumuduma',
        'addressLocality' => 'Bhubaneswar',
        'addressRegion' => 'Odisha',
        'postalCode' => '751019',
        'addressCountry' => 'IN',
    ],
    'areaServed' => [
        '@type' => 'State',
        'name' => 'Odisha',
    ],
    'sameAs' => [
        $company['instagramUrl'] ?? 'https://www.instagram.com/njinterio/',
    ],
];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Html::encode(Yii::$app->language) ?>" class="no-js">
<head>
    <?php $this->head() ?>
    <title><?= Html::encode($this->title ?: 'NJ Interiors | Luxury Interior Design & Execution in Bhubaneswar') ?></title>
    <script type="application/ld+json"><?= json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
</head>
<body class="nj-body is-loading">
<?php $this->beginBody() ?>

<!-- Subtle Architectural Film Grain Overlay -->
<div class="nj-grain" aria-hidden="true"></div>

<!-- Scroll Progress Indicator -->
<div class="nj-scroll-progress-track" aria-hidden="true">
    <div id="scrollProgressBar" class="nj-scroll-progress-bar"></div>
</div>

<!-- Custom Architectural Cursor (Desktop Only) -->
<div id="customCursorDot" class="nj-cursor-dot" aria-hidden="true"></div>
<div id="customCursorRing" class="nj-cursor-ring" aria-hidden="true">
    <span id="customCursorLabel" class="nj-cursor-label"></span>
</div>

<!-- Cinematic Page Preloader -->
<div id="sitePreloader" class="nj-preloader" aria-hidden="true">
    <div class="nj-preloader-inner">
        <div class="nj-preloader-meta">
            <span>PORTFOLIO 2026</span>
            <span>EST. 2016 &bull; BHUBANESWAR</span>
        </div>
        <div class="nj-preloader-brand">
            <span class="nj-preloader-title">NJ INTERIORS</span>
            <span class="nj-preloader-tagline">CRAFTING LUXURY WITH CARE</span>
        </div>
        <div class="nj-preloader-bar-wrap">
            <div id="preloaderFill" class="nj-preloader-fill"></div>
        </div>
    </div>
</div>

<?= $this->render('_header') ?>

<main id="mainContent" class="nj-main" role="main">
    <?= $content ?>
</main>

<?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
