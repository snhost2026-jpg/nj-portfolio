<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$company = Yii::$app->params['company'] ?? [];
$assets = Yii::$app->params['assets'] ?? [];
$portfolioDocx = Url::to($assets['documents']['portfolioDocx'] ?? '@web/docs/NJ_Interiors_Company_Portfolio.docx');
?>
<footer id="siteFooter" class="nj-footer" role="contentinfo">
    <!-- Reel 1 (00:13) Bold Full-Bleed Accent Footer CTA Band -->
    <div class="nj-footer-accent-band">
        <div class="nj-container nj-footer-accent-inner">
            <a href="#contact" class="nj-footer-band-cta nj-magnetic" data-strength="15">
                <span>LET&rsquo;S TALK</span>
                <span>&rarr;</span>
            </a>

            <ul class="nj-footer-band-nav">
                <li><a href="#about">About</a></li>
                <li><a href="#expertise">Expertise</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#founder">Founder</a></li>
                <li><a href="#process">Process</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>

    <div class="nj-container pt-5">
        <!-- Discreet Statutory & Corporate Information Accordion -->
        <div class="nj-statutory-bar">
            <details class="nj-statutory-details">
                <summary class="nj-statutory-summary">
                    <span>VERIFIED CORPORATE &amp; STATUTORY INFORMATION</span>
                    <span class="nj-statutory-toggle-icon">+</span>
                </summary>
                <div class="nj-statutory-content">
                    <div class="nj-statutory-grid">
                        <div>
                            <span class="nj-micro-label">BUSINESS NAME</span>
                            <strong><?= Html::encode($company['brandName'] ?? 'NJ INTERIORS') ?></strong>
                        </div>
                        <div>
                            <span class="nj-micro-label">LEGAL NAME &amp; PROPRIETOR</span>
                            <strong><?= Html::encode($company['legalName'] ?? 'Nitesh Kumar Jangda') ?> (Proprietorship)</strong>
                        </div>
                        <div>
                            <span class="nj-micro-label">ESTABLISHED &amp; INDUSTRY</span>
                            <strong>2016 &bull; Interior Design &amp; Execution</strong>
                        </div>
                        <div>
                            <span class="nj-micro-label">GSTIN</span>
                            <strong><?= Html::encode($company['gstin'] ?? '21AZTPJ1827C1ZN') ?></strong>
                        </div>
                        <div>
                            <span class="nj-micro-label">REGISTERED OFFICE</span>
                            <strong><?= Html::encode($company['addressSingleLine'] ?? 'O-5, Ground Floor, Aster Block, D.N. OxyPark, Cosmopolis Road, Dumuduma, Bhubaneswar, Khordha, Odisha – 751019.') ?></strong>
                        </div>
                        <div>
                            <span class="nj-micro-label">COMPANY PROFILE</span>
                            <a href="<?= Html::encode($portfolioDocx) ?>" download class="nj-gold-link">Download 2026 Portfolio Dossier (.DOCX) &#8599;</a>
                        </div>
                    </div>
                </div>
            </details>
        </div>

        <!-- Final Closing Sign-Off -->
        <div class="nj-footer-monument">
            <div class="nj-footer-brand-lockup">
                <p class="nj-footer-title">NJ INTERIORS</p>
                <p class="nj-footer-tagline">CRAFTING LUXURY WITH CARE</p>
                <p class="nj-footer-location">BHUBANESWAR, ODISHA | INDIA</p>
            </div>

            <div class="nj-footer-bottom-row">
                <p class="nj-footer-copyright">&copy; 2026 NJ INTERIORS. ALL RIGHTS RESERVED.</p>
                <div class="nj-footer-anchor-nav">
                    <a href="#hero">Back to Top &uarr;</a>
                </div>
            </div>
        </div>
    </div>
</footer>
