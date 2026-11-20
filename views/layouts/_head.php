<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$company = Yii::$app->params['company'] ?? [];
$assets = Yii::$app->params['assets'] ?? [];

$pageTitle = $this->title ?: 'NJ Interiors | Luxury Interior Design & Execution in Bhubaneswar';
$metaDescription = $this->params['meta_description']
    ?? 'Established in 2016 in Bhubaneswar, Odisha, NJ INTERIORS is a luxury interior design and execution studio led by Creative Director Nitesh Kumar Jangda, crafting bespoke residential, hospitality, commercial, and custom joinery spaces.';
$metaKeywords = $this->params['meta_keywords']
    ?? 'NJ Interiors, Nitesh Kumar Jangda, Nitesh Jangda, Luxury Interior Design Bhubaneswar, Interior Designer Odisha, Custom Furniture Joinery, Modular Kitchen Bhubaneswar, Hospitality Interiors India';
$canonicalUrl = $company['canonicalUrl'] ?? 'https://njinteriors.in/';
$ogImageUrl = Url::to($assets['projects']['living'] ?? '@web/images/projects/residential/living-tv-wall.webp', true);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerMetaTag(['name' => 'description', 'content' => $metaDescription], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $metaKeywords], 'keywords');
$this->registerMetaTag(['name' => 'author', 'content' => 'NJ INTERIORS — Nitesh Kumar Jangda']);
$this->registerMetaTag(['name' => 'theme-color', 'content' => '#11100E']);

// Open Graph Metadata
$this->registerMetaTag(['property' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['property' => 'og:site_name', 'content' => 'NJ INTERIORS']);
$this->registerMetaTag(['property' => 'og:title', 'content' => $pageTitle]);
$this->registerMetaTag(['property' => 'og:description', 'content' => $metaDescription]);
$this->registerMetaTag(['property' => 'og:url', 'content' => $canonicalUrl]);
$this->registerMetaTag(['property' => 'og:image', 'content' => $ogImageUrl]);
$this->registerMetaTag(['property' => 'og:locale', 'content' => 'en_IN']);

// Twitter Card Metadata
$this->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary_large_image']);
$this->registerMetaTag(['name' => 'twitter:title', 'content' => $pageTitle]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $metaDescription]);
$this->registerMetaTag(['name' => 'twitter:image', 'content' => $ogImageUrl]);

// Canonical & Icons
$this->registerLinkTag(['rel' => 'canonical', 'href' => $canonicalUrl]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/svg+xml', 'href' => Url::to('@web/images/logo/nj-monogram.svg')]);
$this->registerLinkTag(['rel' => 'alternate icon', 'type' => 'image/x-icon', 'href' => Url::to('@web/favicon.ico')]);
$this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
$this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous']);
