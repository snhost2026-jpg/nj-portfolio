<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main application asset bundle for NJ INTERIORS Immersive 3D Architectural Portfolio.
 * Registers editorial typography, CSS design system, GSAP + ScrollTrigger, Lenis Smooth Scroll,
 * Three.js selective 3D composition, and modular ES6 interaction scripts.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600&family=Manrope:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
        'css/bootstrap.min.css',
        'css/site.css',
        'css/animations.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
        'https://unpkg.com/lenis@1.1.18/dist/lenis.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js',
        'js/bootstrap.bundle.min.js',
        'js/main.js',
        'js/animations.js',
        'js/video.js',
        'js/interactions.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    public $depends = [];
}
