<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$company = Yii::$app->params['company'] ?? [];
$assets = Yii::$app->params['assets'] ?? [];
$logoUrl = Url::to($assets['logo'] ?? '@web/images/logo/nj-monogram.svg');
?>
<header id="siteHeader" class="nj-header" role="banner">
    <div class="nj-header-inner">
        <a href="#hero" class="nj-logo-link" aria-label="NJ INTERIORS — Home">
            <img src="<?= Html::encode($logoUrl) ?>" alt="NJ INTERIORS Monogram" class="nj-logo-mark" width="38" height="38">
            <div class="nj-logo-wordmark">
                <span class="nj-logo-name">NJ INTERIORS</span>
                <span class="nj-logo-sub">EST. 2016 &bull; BHUBANESWAR</span>
            </div>
        </a>

        <nav id="primaryNav" class="nj-nav" aria-label="Primary Portfolio Navigation">
            <ul class="nj-nav-list">
                <li><a href="#about" class="nj-nav-item" data-nav-target="about">About</a></li>
                <li><a href="#expertise" class="nj-nav-item" data-nav-target="expertise">Expertise</a></li>
                <li><a href="#projects" class="nj-nav-item" data-nav-target="projects">Projects</a></li>
                <li><a href="#founder" class="nj-nav-item" data-nav-target="founder">Founder</a></li>
                <li><a href="#contact" class="nj-nav-item" data-nav-target="contact">Contact</a></li>
            </ul>
        </nav>

        <div class="nj-header-right">
            <a href="#contact" class="nj-lets-talk-btn nj-magnetic" data-strength="20">
                <span class="nj-btn-text">Let&rsquo;s Talk</span>
                <span class="nj-btn-arrow" aria-hidden="true">&#8599;</span>
            </a>

            <button type="button" id="mobileMenuBtn" class="nj-burger-btn" aria-label="Toggle Menu" aria-expanded="false" aria-controls="mobileDrawer">
                <span class="nj-burger-line"></span>
                <span class="nj-burger-line"></span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobileDrawer" class="nj-mobile-drawer" aria-hidden="true">
        <div class="nj-mobile-drawer-inner">
            <span class="nj-micro-label">NAVIGATION &mdash; PORTFOLIO 2026</span>
            <ul class="nj-mobile-nav-list">
                <li><a href="#about" class="nj-mobile-nav-link"><span>01</span>About</a></li>
                <li><a href="#expertise" class="nj-mobile-nav-link"><span>02</span>Expertise</a></li>
                <li><a href="#projects" class="nj-mobile-nav-link"><span>03</span>Projects</a></li>
                <li><a href="#founder" class="nj-mobile-nav-link"><span>04</span>Founder</a></li>
                <li><a href="#process" class="nj-mobile-nav-link"><span>05</span>Process</a></li>
                <li><a href="#collaboration" class="nj-mobile-nav-link"><span>06</span>Hospitality</a></li>
                <li><a href="#contact" class="nj-mobile-nav-link"><span>07</span>Contact</a></li>
            </ul>
            <div class="nj-mobile-drawer-footer">
                <p class="mb-1">CRAFTING LUXURY WITH CARE</p>
                <a href="tel:+919583205010">+91 95832 05010</a> &bull;
                <a href="mailto:njinteriorbbs@gmail.com">njinteriorbbs@gmail.com</a>
            </div>
        </div>
    </div>
</header>
