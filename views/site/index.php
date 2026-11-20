<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var app\models\ContactForm $contactModel */
/** @var array $company */
/** @var array $assets */

use app\models\ContactForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'NJ Interiors | Luxury Interior Design & Execution in Bhubaneswar';
$this->params['meta_description'] = 'Established in 2016, NJ INTERIORS is a Bhubaneswar-based luxury interior design and execution firm led by Creative Director Nitesh Kumar Jangda, creating refined residential, hospitality, commercial, and custom joinery spaces.';

$videoWebmUrl = Url::to($assets['video']['companyWalkthroughWebm'] ?? '@web/videos/nj-interiors-showcase.webm');
$videoPosterUrl = Url::to($assets['video']['poster'] ?? '@web/images/projects/residential/living-tv-wall.webp');
$founderImgUrl = Url::to($assets['founder']['portrait'] ?? '@web/images/founder/nitesh-kumar-jangda.webp');

$imgLiving = Url::to($assets['projects']['living'] ?? '@web/images/projects/residential/living-tv-wall.webp');
$imgKitchen = Url::to($assets['projects']['kitchen'] ?? '@web/images/projects/kitchen/modular-kitchen.webp');
$imgBedroom = Url::to($assets['projects']['bedroom'] ?? '@web/images/projects/bedroom/master-bedroom-wardrobe.webp');
$imgFurniture = Url::to($assets['projects']['furniture'] ?? '@web/images/projects/furniture/custom-joinery-credenza.webp');
$imgResidential = Url::to($assets['projects']['residential'] ?? '@web/images/projects/residential/luxury-residence-interior.webp');
$imgCommercial = Url::to($assets['projects']['commercial'] ?? '@web/images/projects/commercial/hospitality-reception-lounge.webp');

$contactSubmitUrl = Url::to(['/contact/submit']);
$instagramUrl = $company['instagramUrl'] ?? 'https://www.instagram.com/njinterio/';
$googleMapsUrl = $company['googleMapsUrl'] ?? 'https://www.google.com/maps/search/?api=1&query=DN+OxyPark+Cosmopolis+Road+Dumuduma+Bhubaneswar+Odisha+751019';

$flashSuccess = Yii::$app->session->getFlash('success');
$flashError = Yii::$app->session->getFlash('error');

$services = [
    [
        'num' => '01',
        'tab' => 'RESIDENTIAL',
        'title' => 'RESIDENTIAL INTERIORS',
        'short' => 'Apartments, premium residences, villas, living spaces, bedrooms and complete home renovation.',
        'detail' => 'We design and execute personalized residential environments tailored to how families live and gather—spanning living and dining rooms, master bedrooms, bespoke storage, lighting schemes, and complete turnkey apartment or villa renovations.',
        'tags' => ['Apartments & Villas', 'Living & Dining Spaces', 'Master Suites', 'Complete Home Renovation'],
        'image' => $imgResidential,
    ],
    [
        'num' => '02',
        'tab' => 'HOSPITALITY',
        'title' => 'HOSPITALITY & COMMERCIAL',
        'short' => 'Guest rooms, reception areas, boutique hotels, restaurants, cafés, offices and showrooms, subject to project scope and technical assessment.',
        'detail' => 'Extending our precision joinery and interior finishing expertise to boutique hospitality and commercial spaces—exploring individual guest-room packages, reception and lobby concepts, café counters, and office fit-outs subject to project scope and technical assessment.',
        'tags' => ['Guest Rooms & Suites', 'Reception & Lobby Concepts', 'Restaurants & Cafés', 'Offices & Showrooms'],
        'image' => $imgCommercial,
    ],
    [
        'num' => '03',
        'tab' => 'CUSTOM JOINERY',
        'title' => 'CUSTOM FURNITURE & JOINERY',
        'short' => 'Modular kitchens, wardrobes, TV units, storage systems, beds, counters and bespoke cabinetry.',
        'detail' => 'Rooted in generations of carpentry and engineering workshop heritage, we craft high-precision modular kitchens, floor-to-ceiling wardrobes, architectural TV wall units, beds, reception counters, and custom storage cabinetry.',
        'tags' => ['Modular Kitchens', 'Walk-In & Sliding Wardrobes', 'Signature TV Wall Units', 'Bespoke Cabinetry & Beds'],
        'image' => $imgKitchen,
    ],
    [
        'num' => '04',
        'tab' => 'FINISHES & LIGHTING',
        'title' => 'CEILINGS, WALLS & FINISHES',
        'short' => 'Gypsum false ceilings, decorative wall treatments, mouldings, wallpapers, painting and coordinated lighting.',
        'detail' => 'Transforming the architectural envelope through layered gypsum false ceilings, linear cove lighting, fluted timber and stone wall paneling, classical and modern wall mouldings, curated wallpapers, and luxury paint finishes.',
        'tags' => ['Gypsum False Ceilings', 'Decorative Wall Paneling', 'Architectural Mouldings', 'Coordinated Cove Lighting'],
        'image' => $imgLiving,
    ],
    [
        'num' => '05',
        'tab' => '3D VISUALISATION',
        'title' => 'DESIGN & VISUALISATION',
        'short' => 'Space planning, concept development, interior layouts, 3D visualisation and walkthrough presentations where included in the agreed scope.',
        'detail' => 'Bringing clarity before fabrication begins—we develop detailed 2D furniture layouts, material and finish concepts, photorealistic 3D interior perspectives, and walkthrough presentations where included in the agreed project scope.',
        'tags' => ['2D Space Planning', 'Concept Development', '3D Interior Visualisation', 'Walkthrough Presentations'],
        'image' => $imgBedroom,
    ],
];

$projects = [
    [
        'id' => 'proj-01',
        'title' => 'Signature Living & Fluted TV Wall Composition',
        'category' => 'Living Spaces',
        'location' => 'Bhubaneswar, Odisha',
        'year' => 'Portfolio 2026',
        'statusNote' => 'Editable Project Fact Slot — Update caption details as needed',
        'description' => 'Custom floor-to-ceiling fluted timber and bookmatched travertine TV unit paired with recessed gypsum false ceiling architecture and warm indirect LED cove illumination.',
        'image' => $imgLiving,
        'layoutClass' => 'nj-project-item-wide',
    ],
    [
        'id' => 'proj-02',
        'title' => 'Ergonomic Modular Kitchen & Island Joinery',
        'category' => 'Modular Kitchens',
        'location' => 'Bhubaneswar, Odisha',
        'year' => 'Portfolio 2026',
        'statusNote' => 'Editable Project Fact Slot — Update caption details as needed',
        'description' => 'Handleless matte cabinetry combined with warm fluted walnut tall units, waterfall stone counter, precision soft-close storage systems, and under-cabinet task lighting.',
        'image' => $imgKitchen,
        'layoutClass' => 'nj-project-item-tall',
    ],
    [
        'id' => 'proj-03',
        'title' => 'Master Suite & Illuminated Fluted-Glass Wardrobe',
        'category' => 'Bedrooms',
        'location' => 'Bhubaneswar, Odisha',
        'year' => 'Portfolio 2026',
        'statusNote' => 'Editable Project Fact Slot — Update caption details as needed',
        'description' => 'Tranquil bedroom interior featuring bespoke bronze-tinted fluted glass wardrobes with integrated vertical lighting, upholstered headboard paneling, and layered ceiling finishes.',
        'image' => $imgBedroom,
        'layoutClass' => 'nj-project-item-standard',
    ],
    [
        'id' => 'proj-04',
        'title' => 'Bespoke Architectural Credenza & Millwork',
        'category' => 'Custom Furniture',
        'location' => 'Bhubaneswar, Odisha',
        'year' => 'Portfolio 2026',
        'statusNote' => 'Editable Project Fact Slot — Update caption details as needed',
        'description' => 'Handcrafted fluted walnut credenza with brushed champagne bronze detailing, honed stone surface, and custom architectural storage compartments.',
        'image' => $imgFurniture,
        'layoutClass' => 'nj-project-item-standard',
    ],
    [
        'id' => 'proj-05',
        'title' => 'Contemporary Open-Plan Residence Interior',
        'category' => 'Residential Interiors',
        'location' => 'Bhubaneswar, Odisha',
        'year' => 'Portfolio 2026',
        'statusNote' => 'Editable Project Fact Slot — Update caption details as needed',
        'description' => 'Comprehensive residential interior planning balancing warm ivory architectural walls, custom timber joinery, coordinated ambient lighting, and natural spatial flow.',
        'image' => $imgResidential,
        'layoutClass' => 'nj-project-item-wide',
    ],
    [
        'id' => 'proj-06',
        'title' => 'Boutique Hospitality Reception & Lounge Concept',
        'category' => 'Commercial & Hospitality Concepts',
        'location' => 'Design & Fit-Out Capability Concept',
        'year' => 'Portfolio 2026',
        'statusNote' => 'Target Service Capability Concept — Not a claim of a previously completed hotel project',
        'description' => 'Conceptual hospitality reception and lounge illustrating NJ INTERIORS’ capability in bespoke reception counters, architectural metalwork screens, custom joinery, and ceiling finishes.',
        'image' => $imgCommercial,
        'layoutClass' => 'nj-project-item-tall',
    ],
];
?>

<div class="nj-experience">

    <!-- =======================================================================
         SECTION 01 — CINEMATIC INTRO / HERO (PINNED SCROLL-EXPANDING PORTAL)
         ======================================================================= -->
    <section id="hero" class="nj-hero-section" aria-label="Introduction">
        <!-- Layer 1: Atmospheric Background -->
        <div id="heroMaskWrap" class="nj-hero-mask-wrap">
            <div class="nj-hero-media-parallax" id="heroParallaxBg">
                <img src="<?= Html::encode($imgResidential) ?>"
                     alt="NJ INTERIORS — Luxury Architectural Interior Space in Bhubaneswar"
                     class="nj-hero-bg-image"
                     fetchpriority="high">
                <div class="nj-hero-scrim"></div>
            </div>
        </div>

        <div class="nj-container nj-hero-stage">
            <!-- Top Monumental Unobstructed Display Title -->
            <div class="nj-hero-headline-block" id="heroGiantTextLayer">
                <div class="nj-hero-eyebrow-row nj-hero-reveal-meta">
                    <span>ARCHITECTURAL INTERIORS &bull; EST. 2016</span>
                    <span>PORTFOLIO EDITION 2026</span>
                    <span>BHUBANESWAR, ODISHA</span>
                </div>
                <h1 id="heroBrandTitle" class="nj-hero-brand-title" data-split-chars>NJ INTERIORS</h1>
            </div>

            <!-- Middle Showcase Row: Left Editorial Flank + Center Scroll-Expanding 3D Architectural Portal + Right CTA Flank -->
            <div class="nj-hero-showcase-row">
                <!-- Left Flank -->
                <div class="nj-hero-flank-left nj-hero-reveal-meta" id="heroFlankLeft">
                    <div class="nj-hero-side-three-wrap" aria-hidden="true">
                        <canvas id="heroThreeCanvas" class="nj-hero-three-canvas"></canvas>
                    </div>
                    <div class="nj-stacked-keywords">
                        <span>SPACES.</span>
                        <span>CRAFT.</span>
                        <span>BESPOKE.</span>
                        <span class="nj-accent-word">LUXURY.</span>
                    </div>
                    <p class="nj-hero-flank-note">
                        Four generations of engineering, master carpentry &amp; interior execution.
                    </p>
                    <div class="nj-hero-signature-mark">Nitesh Jangda</div>
                </div>

                <!-- Center Architectural Portal (Clean, Unobstructed Interior Photograph) -->
                <div class="nj-hero-portal-col" id="heroForegroundLayer">
                    <div class="nj-hero-monolith-card" id="heroMonolithCard" data-cursor-label="SCROLL TO ENTER">
                        <img src="<?= Html::encode($imgLiving) ?>"
                             alt="Signature Interior Architecture by NJ INTERIORS"
                             class="nj-hero-monolith-img"
                             id="heroPortalImg">
                        <div class="nj-hero-monolith-veil"></div>
                        <div class="nj-hero-monolith-badge">
                            <span>01 // SIGNATURE RESIDENCE</span>
                            <span>SCROLL TO EXPAND &darr;</span>
                        </div>
                    </div>
                </div>

                <!-- Right Flank -->
                <div class="nj-hero-flank-right nj-hero-reveal-meta" id="heroFlankRight">
                    <p id="heroTagline" class="nj-hero-tagline">CRAFTING LUXURY WITH CARE</p>
                    <p class="nj-hero-sub-callout">
                        THE DETAILS ARE NOT THE DETAILS.<br>
                        <strong>THEY MAKE THE SPACE.</strong>
                    </p>
                    <div class="nj-hero-cta-cluster">
                        <a href="#contact" class="nj-hero-talk-btn nj-magnetic" data-strength="20">
                            <span>LET&rsquo;S TALK</span>
                            <span>&rarr;</span>
                        </a>
                        <div class="nj-hero-exp-caption">
                            <strong>10+ Years of Experience</strong>
                            <span>INTERIOR DESIGN &amp; EXECUTION</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Metadata Bar -->
            <div class="nj-hero-bottom-bar" id="heroBottomBar">
                <div class="nj-hero-categories">
                    <span>Residential</span>
                    <span class="nj-sep-dot">&bull;</span>
                    <span>Hospitality</span>
                    <span class="nj-sep-dot">&bull;</span>
                    <span>Commercial</span>
                    <span class="nj-sep-dot">&bull;</span>
                    <span>Custom Joinery</span>
                </div>

                <a href="#brand-statement" class="nj-scroll-indicator" aria-label="Scroll to explore">
                    <span class="nj-scroll-text">SCROLL TO EXPLORE</span>
                    <span class="nj-scroll-line-track">
                        <span class="nj-scroll-line-thumb"></span>
                    </span>
                </a>

                <div class="nj-hero-director-tag">
                    <span class="nj-micro-label">CREATIVE DIRECTOR</span>
                    <strong>Nitesh Kumar Jangda</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 02 — BRAND STATEMENT (MONUMENTAL OFFSET TYPOGRAPHY)
         ======================================================================= -->
    <section id="brand-statement" class="nj-section nj-theme-ivory">
        <div class="nj-watermark-year" aria-hidden="true" data-parallax-speed="0.18">2016</div>

        <div class="nj-container position-relative z-2">
            <div class="nj-statement-top-bar">
                <span class="nj-section-label mb-0">| 01 &mdash; WHO WE ARE</span>
                <span class="nj-micro-label">PORTFOLIO 2026 &bull; BHUBANESWAR, ODISHA</span>
            </div>

            <!-- Monumental Stacked & Offset Display Statement (Reel 1 00:03 Style) -->
            <div class="nj-monument-statement-wrap">
                <h2 class="nj-statement-headline" data-reveal-lines>
                    <span class="nj-line-wrap"><span class="nj-line-inner">SPACES DESIGNED</span></span>
                    <span class="nj-line-wrap"><span class="nj-line-inner">WITH <em class="nj-display-accent">PURPOSE.</em></span></span>
                    <span class="nj-line-wrap nj-line-offset-right"><span class="nj-line-inner">EXECUTED WITH <em>CARE.</em></span></span>
                </h2>
            </div>

            <div class="nj-statement-bottom-grid">
                <div class="nj-statement-micro-col" data-reveal-up>
                    <p class="nj-micro-manifesto">
                        IT&rsquo;S ABOUT<br>
                        HOW YOU LIVE<br>
                        <span>WITHIN THEM.</span>
                    </p>
                </div>

                <div class="nj-statement-copy" data-reveal-up>
                    <p class="nj-lead-paragraph">
                        Established in 2016, <strong>NJ INTERIORS</strong> is a Bhubaneswar-based interior design and execution firm creating refined, functional and thoughtfully finished spaces.
                    </p>
                    <p class="nj-body-paragraph mb-0">
                        We bring together creative concepts, practical planning, material selection and coordinated execution to transform spaces into meaningful experiences.
                    </p>
                </div>

                <div class="nj-statement-visual-accent" data-parallax-speed="-0.08">
                    <div class="nj-mask-image-frame nj-tilt-card">
                        <img src="<?= Html::encode($imgFurniture) ?>"
                             alt="Bespoke fluted walnut and brushed bronze architectural joinery by NJ INTERIORS"
                             loading="lazy">
                    </div>
                    <span class="nj-image-caption">SPACES DON&rsquo;T LIE. THEY JUST NEED SOMEONE WHO KNOWS HOW TO CRAFT THEM.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 03 — CINEMATIC COMPANY VIDEO (ACTUAL SUPPLIED 9:16 4K VIDEO)
         ======================================================================= -->
    <section id="company-video" class="nj-section nj-video-section nj-theme-charcoal">
        <div class="nj-video-ambient-backdrop" aria-hidden="true">
            <video id="ambientBackdropVideo" class="nj-ambient-video" muted loop playsinline preload="metadata" poster="<?= Html::encode($videoPosterUrl) ?>">
                <source src="<?= Html::encode($videoWebmUrl) ?>" type="video/webm">
            </video>
            <div class="nj-ambient-overlay"></div>
        </div>

        <div class="nj-container position-relative z-2">
            <div class="nj-video-showcase-layout">
                <div class="nj-video-narrative" data-reveal-up>
                    <span class="nj-section-label">| CINEMATIC WALKTHROUGH &mdash; ACTUAL SITE FILM</span>
                    <h2 class="nj-video-headline">
                        CRAFTED SPACES.<br>
                        <em>THOUGHTFUL DETAILS.</em>
                    </h2>
                    <p class="nj-video-subheadline">
                        NJ INTERIORS &mdash; A VISION BROUGHT TO LIFE.
                    </p>
                    <p class="nj-video-description">
                        Recorded on location from an actual NJ INTERIORS execution—showcasing custom floor-to-ceiling joinery, recessed gypsum ceiling architecture, warm ambient cove lighting, and tactile surface finishes.
                    </p>

                    <div class="nj-video-control-console">
                        <div class="nj-video-buttons">
                            <button type="button" id="companyVideoPlayBtn" class="nj-video-ctrl-pill nj-magnetic" data-strength="15" aria-label="Play or pause company video">
                                <span id="companyVideoPlayIcon" class="nj-ctrl-icon">&#10074;&#10074;</span>
                                <span id="companyVideoPlayText">Pause Film</span>
                            </button>

                            <button type="button" id="companyVideoMuteBtn" class="nj-video-ctrl-pill nj-video-ctrl-outline nj-magnetic" data-strength="15" aria-label="Unmute or mute company video">
                                <span id="companyVideoMuteText">Unmute Audio</span>
                            </button>

                            <button type="button" id="companyVideoFullscreenBtn" class="nj-video-ctrl-icon-btn" aria-label="View video in fullscreen" title="Fullscreen">
                                &#x26F6;
                            </button>
                        </div>

                        <div class="nj-video-progress-block">
                            <div class="nj-video-time-row">
                                <span class="nj-micro-label">FULL HD WEBM PORTRAIT (1080 &times; 1920)</span>
                                <span id="companyVideoTimecode" class="nj-micro-label">00:00 / 00:31</span>
                            </div>
                            <div id="companyVideoScrubberTrack" class="nj-video-scrubber-track" role="slider" tabindex="0" aria-label="Video playback progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div id="companyVideoScrubberFill" class="nj-video-scrubber-fill"></div>
                            </div>
                        </div>
                    </div>

                    <div class="nj-video-specs-bar">
                        <div class="nj-video-spec-pill">
                            <span class="nj-micro-label">EXECUTION</span>
                            <strong>Turnkey Bespoke Joinery &amp; Lighting</strong>
                        </div>
                        <div class="nj-video-spec-pill">
                            <span class="nj-micro-label">STUDIO</span>
                            <strong>NJ INTERIORS &bull; Bhubaneswar</strong>
                        </div>
                    </div>
                </div>

                <!-- Right Uncropped Native 9:16 4K Architectural Video Monolith -->
                <div class="nj-video-monolith-col">
                    <div id="companyVideoFrame" class="nj-video-monolith-frame" data-cursor-label="PLAY / PAUSE">
                        <video id="companyMainVideo"
                               class="nj-company-video-element"
                               autoplay
                               muted
                               loop
                               playsinline
                               preload="metadata"
                               poster="<?= Html::encode($videoPosterUrl) ?>">
                            <source src="<?= Html::encode($videoWebmUrl) ?>" type="video/webm">
                            Your browser does not support HTML5 video.
                        </video>

                        <div id="companyVideoOverlay" class="nj-video-frame-overlay">
                            <div class="nj-video-badge-top">
                                <span>NJ INTERIORS &bull; COMPLETED EXECUTION</span>
                                <span>9:16 NATIVE</span>
                            </div>
                            <div class="nj-video-badge-bottom">
                                <span>CRAFTED SPACES. THOUGHTFUL DETAILS.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 04 — ABOUT NJ INTERIORS (ASYMMETRICAL EDITORIAL + MANIFESTO BOX)
         ======================================================================= -->
    <section id="about" class="nj-section nj-theme-ivory">
        <div class="nj-container">
            <div class="nj-about-asymmetric-grid">
                <!-- Left Column: Asymmetrical Overlapping Visuals + Floating Year -->
                <div class="nj-about-visual-col">
                    <div class="nj-about-primary-img-wrap" data-clip-reveal>
                        <img src="<?= Html::encode($imgLiving) ?>"
                             alt="Signature living room and custom TV wall designed by NJ INTERIORS"
                             class="nj-about-primary-img"
                             loading="lazy">
                    </div>

                    <div class="nj-about-secondary-img-wrap" data-parallax-speed="-0.12">
                        <img src="<?= Html::encode($imgKitchen) ?>"
                             alt="Bespoke modular kitchen cabinetry and island by NJ INTERIORS"
                             class="nj-about-secondary-img"
                             loading="lazy">
                    </div>

                    <div class="nj-floating-year-badge" data-parallax-speed="0.15">
                        <span class="nj-micro-label">ESTABLISHED</span>
                        <strong>2016</strong>
                        <span class="nj-micro-label">BHUBANESWAR</span>
                    </div>
                </div>

                <!-- Right Column: Editorial Narrative + Reel 1 Bordered Manifesto Callout -->
                <div class="nj-about-content-col" data-reveal-up>
                    <span class="nj-section-label">| 02 &mdash; OUR PHILOSOPHY</span>
                    <h2 class="nj-section-headline">
                        &ldquo;Beyond interiors.<br>
                        We create <em>experiences.</em>&rdquo;
                    </h2>

                    <div class="nj-about-prose">
                        <p>
                            NJ INTERIORS was established in 2016 with a vision to create elegant, functional and thoughtfully designed spaces.
                        </p>
                        <p>
                            Led by <strong>Nitesh Kumar Jangda</strong>, the firm combines technical understanding, creative thinking and a heritage of craftsmanship to deliver interior solutions that reflect individual lifestyles, preferences and aspirations.
                        </p>
                        <p>
                            Every project begins with understanding the client&rsquo;s vision, available space, requirements and budget.
                        </p>
                    </div>

                    <!-- Reel 1 00:08 Style Bordered Editorial Quote Box -->
                    <div class="nj-editorial-quote-box">
                        <span class="nj-giant-quote-mark" aria-hidden="true">&ldquo;</span>
                        <p class="nj-quote-box-text">
                            Exceptional interiors are created when aesthetics, functionality, material understanding and craftsmanship come together.
                        </p>
                        <div class="nj-quote-box-pills">
                            <span>AESTHETICS</span>
                            <span>|</span>
                            <span>FUNCTIONALITY</span>
                            <span>|</span>
                            <span>MATERIALITY</span>
                            <span>|</span>
                            <span>CRAFTSMANSHIP</span>
                        </div>
                        <div class="nj-quote-box-footer">
                            <span class="nj-micro-label">CREATIVE DIRECTION</span>
                            <span class="nj-quote-signature">Nitesh Kumar Jangda</span>
                        </div>
                    </div>

                    <hr class="nj-subtle-divider">

                    <div class="nj-approach-interaction">
                        <button type="button" id="discoverApproachBtn" class="nj-discover-btn" aria-expanded="false" aria-controls="approachExpandPanel">
                            <span>Discover our approach</span>
                            <span class="nj-discover-plus" aria-hidden="true">+</span>
                        </button>

                        <div id="approachExpandPanel" class="nj-approach-panel" hidden>
                            <div class="nj-approach-panel-inner">
                                <p class="nj-micro-label mb-3">DESIGN-LED EXECUTION &amp; MATERIAL PRECISION</p>
                                <ul class="nj-approach-steps-list">
                                    <li><strong>01. Brief &amp; Site Assessment:</strong> Understanding client lifestyle, spatial conditions, and budget alignment.</li>
                                    <li><strong>02. Concept &amp; Layout Development:</strong> Intelligent space planning, furniture layouts, and 3D design perspectives.</li>
                                    <li><strong>03. Material Specification:</strong> Curating timbers, veneers, laminates, stone surfaces, and architectural lighting.</li>
                                    <li><strong>04. Fabrication &amp; On-Site Coordination:</strong> Custom joinery, false ceilings, wall finishes, and disciplined site supervision.</li>
                                    <li><strong>05. Quality Review &amp; Handover:</strong> Detailed workmanship inspection, snag resolution, and pristine project delivery.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 05 — OUR EXPERTISE (3D FAN DECK // DISCIPLINES + 5 HORIZONTAL PANELS)
         ======================================================================= -->
    <section id="expertise" class="nj-section nj-theme-charcoal position-relative">
        <div class="nj-container">
            <div class="nj-section-header-split" data-reveal-up>
                <div>
                    <span class="nj-section-label">| 03 &mdash; WHAT WE DO</span>
                    <h2 class="nj-section-headline">
                        &ldquo;An integrated approach to<br>
                        interior <em>excellence.</em>&rdquo;
                    </h2>
                </div>
                <div>
                    <p class="nj-section-header-note mb-2">
                        Explore our five core disciplines through our interactive 3D Fan Deck or inspect the detailed horizontal specification rows below.
                    </p>
                    <span class="nj-micro-label">/ Residential / Hospitality / Custom Joinery / Finishes / 3D Visualisation</span>
                </div>
            </div>

            <!-- PART A: REEL 2 (00:13–00:15) INTERACTIVE 3D FAN DECK // DISCIPLINES -->
            <div class="nj-fandeck-stage-wrap" id="fanDeckStageWrap" data-reveal-up>
                <div class="nj-fandeck-header">
                    <span class="nj-fandeck-badge">FAN DECK // DISCIPLINES</span>
                    <div class="nj-fandeck-tabs" role="tablist" aria-label="3D Discipline Fan Deck Tabs">
                        <?php foreach ($services as $index => $srv): ?>
                            <button type="button"
                                    class="nj-fandeck-tab <?= $index === 2 ? 'is-active' : '' ?>"
                                    data-fandeck-target="<?= $index ?>">
                                <?= Html::encode($srv['tab']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <span class="nj-micro-label d-none d-lg-inline">CLICK OR HOVER ANY CARD TO FAN IN 3D</span>
                </div>

                <div class="nj-fandeck-3d-viewport" id="fanDeckViewport">
                    <?php foreach ($services as $index => $srv): ?>
                        <div class="nj-fandeck-card <?= $index === 2 ? 'is-active' : '' ?>"
                             data-fandeck-index="<?= $index ?>"
                             tabindex="0"
                             role="button"
                             aria-label="<?= Html::encode($srv['title']) ?>">
                            <div class="nj-fandeck-card-media">
                                <img src="<?= Html::encode($srv['image']) ?>" alt="<?= Html::encode($srv['title']) ?>" loading="lazy">
                                <span class="nj-fandeck-card-num"><?= Html::encode($srv['num']) ?></span>
                            </div>
                            <div class="nj-fandeck-card-body">
                                <span class="nj-micro-label">DISCIPLINE <?= Html::encode($srv['num']) ?></span>
                                <h4><?= Html::encode($srv['title']) ?></h4>
                                <p><?= Html::encode($srv['short']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- PART B: 5 LARGE HORIZONTAL INTERACTIVE SERVICE PANELS (REEL 1 00:06 + PROMPT SPEC) -->
            <div class="nj-expertise-panels mt-5" id="expertisePanelsList">
                <?php foreach ($services as $index => $srv): ?>
                    <article class="nj-expertise-panel <?= $index === 0 ? 'is-expanded' : '' ?>"
                             data-service-index="<?= $index ?>"
                             data-preview-image="<?= Html::encode($srv['image']) ?>"
                             data-cursor-label="EXPLORE">
                        <div class="nj-expertise-panel-bg" style="background-image: url('<?= Html::encode($srv['image']) ?>');" aria-hidden="true"></div>

                        <div class="nj-expertise-panel-row" role="button" tabindex="0" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>">
                            <div class="nj-expertise-num-col">
                                <span class="nj-expertise-num"><?= Html::encode($srv['num']) ?></span>
                            </div>

                            <div class="nj-expertise-title-col">
                                <h3 class="nj-expertise-title"><?= Html::encode($srv['title']) ?></h3>
                            </div>

                            <div class="nj-expertise-summary-col">
                                <p class="nj-expertise-short"><?= Html::encode($srv['short']) ?></p>
                            </div>

                            <div class="nj-expertise-action-col">
                                <span class="nj-expertise-toggle-indicator" aria-hidden="true">&#8599;</span>
                            </div>
                        </div>

                        <div class="nj-expertise-drawer">
                            <div class="nj-expertise-drawer-inner">
                                <div class="nj-expertise-drawer-media">
                                    <img src="<?= Html::encode($srv['image']) ?>" alt="<?= Html::encode($srv['title']) ?> — NJ INTERIORS" loading="lazy">
                                </div>
                                <div class="nj-expertise-drawer-copy">
                                    <p><?= Html::encode($srv['detail']) ?></p>
                                    <div class="nj-expertise-tag-row">
                                        <?php foreach ($srv['tags'] as $tag): ?>
                                            <span class="nj-minimal-tag"><?= Html::encode($tag) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <a href="#contact" class="nj-text-link-gold mt-3 d-inline-block" data-prefill-project="<?= Html::encode($srv['title']) ?>">
                                        Enquire about <?= Html::encode($srv['title']) ?> &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Desktop Cursor-Following Floating Image Preview -->
        <div id="expertiseCursorPreview" class="nj-cursor-floating-preview" aria-hidden="true">
            <img id="expertiseCursorPreviewImg" src="<?= Html::encode($imgResidential) ?>" alt="">
        </div>
    </section>

    <!-- =======================================================================
         SECTION 06 — SELECTED PROJECTS / PORTFOLIO (POSTER GRID + 3D COVERFLOW STACK)
         ======================================================================= -->
    <section id="projects" class="nj-section nj-theme-ivory">
        <div class="nj-container">
            <div class="nj-section-header-split" data-reveal-up>
                <div>
                    <span class="nj-section-label">| 04 &mdash; SELECTED WORK</span>
                    <h2 class="nj-section-headline">
                        &ldquo;Spaces that speak for<br>
                        <em>themselves.</em>&rdquo;
                    </h2>
                </div>
                <div>
                    <p class="nj-section-header-note mb-3">
                        Curated residential interiors, bespoke kitchens, wardrobes, custom joinery, and hospitality concepts. Click any project for a fullscreen presentation.
                    </p>
                    <div class="nj-portfolio-filters" role="tablist" aria-label="Filter projects by category">
                        <button type="button" class="nj-filter-tab active" data-filter="all">All Works</button>
                        <button type="button" class="nj-filter-tab" data-filter="Living Spaces">Living Spaces</button>
                        <button type="button" class="nj-filter-tab" data-filter="Modular Kitchens">Modular Kitchens</button>
                        <button type="button" class="nj-filter-tab" data-filter="Bedrooms">Bedrooms</button>
                        <button type="button" class="nj-filter-tab" data-filter="Custom Furniture">Custom Furniture</button>
                        <button type="button" class="nj-filter-tab" data-filter="Residential Interiors">Residential Interiors</button>
                        <button type="button" class="nj-filter-tab" data-filter="Commercial & Hospitality Concepts">Commercial &amp; Hospitality Concepts</button>
                    </div>
                </div>
            </div>

            <!-- Asymmetrical Editorial Poster Grid (Reel 2 00:09–00:12 Style) -->
            <div class="nj-projects-asymmetric-grid" id="projectsGrid">
                <?php foreach ($projects as $idx => $proj): ?>
                    <figure class="nj-project-card <?= Html::encode($proj['layoutClass']) ?>"
                            data-project-category="<?= Html::encode($proj['category']) ?>"
                            data-project-title="<?= Html::encode($proj['title']) ?>"
                            data-project-location="<?= Html::encode($proj['location']) ?>"
                            data-project-year="<?= Html::encode($proj['year']) ?>"
                            data-project-note="<?= Html::encode($proj['statusNote']) ?>"
                            data-project-desc="<?= Html::encode($proj['description']) ?>"
                            data-project-img="<?= Html::encode($proj['image']) ?>"
                            data-cursor-label="VIEW WORK"
                            tabindex="0"
                            role="button"
                            aria-label="Inspect project: <?= Html::encode($proj['title']) ?>">
                        <div class="nj-project-poster-header">
                            <span>0<?= $idx + 1 ?> / 0<?= count($projects) ?></span>
                            <span><?= Html::encode(strtoupper($proj['category'])) ?></span>
                        </div>
                        <div class="nj-project-img-box">
                            <img src="<?= Html::encode($proj['image']) ?>"
                                 alt="<?= Html::encode($proj['title']) ?> — <?= Html::encode($proj['category']) ?>"
                                 class="nj-project-img"
                                 loading="lazy">
                            <div class="nj-project-hover-veil">
                                <span class="nj-project-index">0<?= $idx + 1 ?></span>
                                <span class="nj-project-expand-pill">Fullscreen View &#8599;</span>
                            </div>
                        </div>

                        <figcaption class="nj-project-caption">
                            <div class="nj-project-caption-top">
                                <span class="nj-micro-label"><?= Html::encode($proj['category']) ?></span>
                                <span class="nj-micro-label"><?= Html::encode($proj['location']) ?> &bull; <?= Html::encode($proj['year']) ?></span>
                            </div>
                            <h3 class="nj-project-title"><?= Html::encode($proj['title']) ?></h3>
                            <p class="nj-project-short-desc"><?= Html::encode($proj['description']) ?></p>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- REEL 2 (00:16–00:19) "BEYOND DESIGN" 3D PERSPECTIVE COVERFLOW / DEPTH CAROUSEL -->
        <div class="nj-coverflow-section mt-5" id="coverflowSection">
            <div class="nj-container">
                <div class="nj-coverflow-top-bar">
                    <div>
                        <span class="nj-micro-label">BEYOND DESIGN // 3D SPATIAL PERSPECTIVE DECK</span>
                        <h3 class="nj-coverflow-heading">Interactive Material &amp; Spatial Depth Study</h3>
                    </div>
                    <div class="nj-coverflow-controls">
                        <button type="button" id="coverflowPrevBtn" class="nj-coverflow-nav-btn" aria-label="Previous Spatial Card">&larr;</button>
                        <span id="coverflowCounter" class="nj-micro-label">03 / 06</span>
                        <button type="button" id="coverflowNextBtn" class="nj-coverflow-nav-btn" aria-label="Next Spatial Card">&rarr;</button>
                    </div>
                </div>

                <div class="nj-coverflow-stage" id="coverflowStage">
                    <?php foreach ($projects as $idx => $proj): ?>
                        <div class="nj-coverflow-card <?= $idx === 2 ? 'is-center' : '' ?>"
                             data-cf-index="<?= $idx ?>"
                             data-project-title="<?= Html::encode($proj['title']) ?>"
                             data-project-category="<?= Html::encode($proj['category']) ?>"
                             data-project-location="<?= Html::encode($proj['location']) ?>"
                             data-project-year="<?= Html::encode($proj['year']) ?>"
                             data-project-note="<?= Html::encode($proj['statusNote']) ?>"
                             data-project-desc="<?= Html::encode($proj['description']) ?>"
                             data-project-img="<?= Html::encode($proj['image']) ?>">
                            <div class="nj-coverflow-card-img-wrap">
                                <img src="<?= Html::encode($proj['image']) ?>" alt="<?= Html::encode($proj['title']) ?>" loading="lazy">
                            </div>
                            <div class="nj-coverflow-card-caption">
                                <span class="nj-micro-label">0<?= $idx + 1 ?> &mdash; <?= Html::encode($proj['category']) ?></span>
                                <h4><?= Html::encode($proj['title']) ?></h4>
                                <button type="button" class="nj-coverflow-inspect-btn">Open Fullscreen &#8599;</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 07 — THE FOUNDER / CREATIVE DIRECTOR (LAYERED DISPLAY BACKDROP)
         ======================================================================= -->
    <section id="founder" class="nj-section nj-theme-charcoal position-relative overflow-hidden">
        <!-- Giant Background Display Name Behind Portrait (Reel 1 00:00 / 00:05 Style) -->
        <div class="nj-founder-giant-backdrop" aria-hidden="true" data-parallax-speed="0.12">
            NITESH JANGDA
        </div>

        <div class="nj-container position-relative z-2">
            <div class="nj-founder-layout">
                <!-- Left Column: Supplied Personal Portrait of Nitesh Jangda -->
                <div class="nj-founder-portrait-col" data-reveal-up>
                    <div class="nj-founder-portrait-frame nj-tilt-card">
                        <div class="nj-founder-floating-quote">
                            <span class="nj-giant-quote-mark" aria-hidden="true">&ldquo;</span>
                            <p>You bring the vision.<br><span>We&rsquo;ll bring the craftsmanship.</span></p>
                        </div>
                        <div class="nj-founder-photo-crop">
                            <img src="<?= Html::encode($founderImgUrl) ?>"
                                 alt="Nitesh Kumar Jangda — Creative Director of NJ INTERIORS"
                                 class="nj-founder-photo"
                                 loading="lazy">
                        </div>
                        <div class="nj-founder-frame-caption">
                            <div>
                                <span class="nj-micro-label">NITESH KUMAR JANGDA</span>
                                <strong class="d-block">CREATIVE DIRECTOR | NJ INTERIORS</strong>
                            </div>
                            <span class="nj-founder-signature" aria-hidden="true">Nitesh Jangda</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Headline, Biography, Vision & 4-Generation Vertical Timeline -->
                <div class="nj-founder-bio-col" data-reveal-up>
                    <span class="nj-section-label">| 05 &mdash; THE PERSON BEHIND THE VISION</span>
                    <div class="nj-founder-identity-bar">
                        <h2 class="nj-founder-name-heading">NITESH KUMAR JANGDA</h2>
                        <p class="nj-founder-role-sub">CREATIVE DIRECTOR | NJ INTERIORS</p>
                    </div>

                    <h3 class="nj-founder-headline">
                        &ldquo;A legacy of craftsmanship.<br>
                        A vision for <em>modern living.</em>&rdquo;
                    </h3>

                    <div class="nj-founder-biography">
                        <p>
                            For Nitesh Jangda, interior design is more than a profession &mdash; it is a passion deeply rooted in a four-generation legacy of craftsmanship, engineering and construction.
                        </p>
                        <p>
                            His family&rsquo;s journey began with his great-grandfather, a civil contractor, followed by his grandfather&rsquo;s carpentry workshop and his father&rsquo;s entrepreneurial venture, <strong>Navadurga Engineering Works</strong>, specialising in engineering equipment, machinery, steel furniture and architectural metalwork.
                        </p>
                        <p>
                            Growing up surrounded by workshops, materials and skilled craftsmanship, Nitesh developed an early appreciation for design, construction and transforming ideas into reality.
                        </p>
                        <p>
                            An Electronics Engineering graduate, he initially began his professional journey in technical support. His passion for creativity, architecture and interior spaces eventually inspired him to pursue a different path.
                        </p>
                        <p>
                            In 2016, he founded <strong>NJ INTERIORS</strong>, combining technical knowledge, creative vision and his family&rsquo;s heritage of craftsmanship.
                        </p>
                        <p>
                            Today, he leads the firm with a design philosophy that blends contemporary aesthetics, practical functionality and exceptional craftsmanship.
                        </p>
                    </div>

                    <blockquote class="nj-founder-vision-quote">
                        <span class="nj-micro-label d-block mb-2">HIS VISION</span>
                        <p>&ldquo;To create spaces that go beyond beauty &mdash; spaces that tell stories, inspire living and stand the test of time.&rdquo;</p>
                    </blockquote>

                    <!-- Four-Generation Vertical Timeline (Reel 1 00:10 Circular Node Style) -->
                    <div class="nj-legacy-vertical-timeline">
                        <span class="nj-micro-label d-block mb-3">FOUR-GENERATION CRAFTSMANSHIP HERITAGE</span>

                        <div class="nj-v-timeline-item">
                            <span class="nj-v-timeline-circle">01</span>
                            <div class="nj-v-timeline-content">
                                <h4>GENERATION I &mdash; CIVIL CONTRACTING</h4>
                                <p>Great-grandfather, a respected civil contractor establishing structural excellence and built durability.</p>
                            </div>
                        </div>

                        <div class="nj-v-timeline-item">
                            <span class="nj-v-timeline-circle">02</span>
                            <div class="nj-v-timeline-content">
                                <h4>GENERATION II &mdash; MASTER CARPENTRY WORKSHOP</h4>
                                <p>Grandfather&rsquo;s carpentry workshop, mastering timber joinery, bespoke woodwork, and hand-finished detailing.</p>
                            </div>
                        </div>

                        <div class="nj-v-timeline-item">
                            <span class="nj-v-timeline-circle">03</span>
                            <div class="nj-v-timeline-content">
                                <h4>GENERATION III &mdash; NAVADURGA ENGINEERING WORKS</h4>
                                <p>Father&rsquo;s entrepreneurial venture specialising in engineering equipment, machinery, steel furniture, and architectural metalwork.</p>
                            </div>
                        </div>

                        <div class="nj-v-timeline-item is-current">
                            <span class="nj-v-timeline-circle">04</span>
                            <div class="nj-v-timeline-content">
                                <h4>GENERATION IV &mdash; NJ INTERIORS (EST. 2016)</h4>
                                <p>Founded by Nitesh Kumar Jangda, uniting engineering precision, contemporary interior design, and turnkey execution in Bhubaneswar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 08 — OUR PROCESS (5-STAGE INTERACTIVE TIMELINE)
         ======================================================================= -->
    <section id="process" class="nj-section nj-theme-ivory">
        <div class="nj-container">
            <div class="nj-section-header-split" data-reveal-up>
                <div>
                    <span class="nj-section-label">| 06 &mdash; HOW WE WORK</span>
                    <h2 class="nj-section-headline">
                        &ldquo;From the first idea to the<br>
                        final <em>detail.</em>&rdquo;
                    </h2>
                </div>
                <p class="nj-section-header-note">
                    A structured five-stage architectural workflow ensuring transparency, budget alignment, and meticulous quality control from initial site discovery to handover.
                </p>
            </div>

            <?php
            $processStages = [
                [
                    'num' => '01',
                    'title' => 'DISCOVERY',
                    'desc' => 'Site visit, understanding requirements, project schedule and budget alignment.',
                ],
                [
                    'num' => '02',
                    'title' => 'DESIGN & SCOPE',
                    'desc' => 'Concept direction, layouts, finishes and itemised scope.',
                ],
                [
                    'num' => '03',
                    'title' => 'COMMERCIAL PROPOSAL',
                    'desc' => 'Quotation, inclusions, exclusions, milestone payments and programme.',
                ],
                [
                    'num' => '04',
                    'title' => 'EXECUTION',
                    'desc' => 'Procurement, fabrication, installation and site coordination.',
                ],
                [
                    'num' => '05',
                    'title' => 'QUALITY & HANDOVER',
                    'desc' => 'Finishing review, snag resolution and project close-out.',
                ],
            ];
            ?>

            <div class="nj-process-timeline" id="processTimeline">
                <div class="nj-process-line-track" aria-hidden="true">
                    <div id="processLineFill" class="nj-process-line-fill"></div>
                </div>

                <div class="nj-process-stages-grid">
                    <?php foreach ($processStages as $i => $stage): ?>
                        <div class="nj-process-stage <?= $i === 0 ? 'is-active' : '' ?>" data-stage-index="<?= $i ?>" tabindex="0">
                            <div class="nj-process-node-row">
                                <span class="nj-process-circle-node"><?= Html::encode($stage['num']) ?></span>
                                <span class="nj-micro-label">STAGE <?= Html::encode($stage['num']) ?></span>
                            </div>
                            <h3 class="nj-process-stage-title"><?= Html::encode($stage['num']) ?> &mdash; <?= Html::encode($stage['title']) ?></h3>
                            <p class="nj-process-stage-desc"><?= Html::encode($stage['desc']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 09 — COLLABORATION / HOSPITALITY
         ======================================================================= -->
    <section id="collaboration" class="nj-section nj-theme-charcoal">
        <div class="nj-container">
            <div class="nj-collaboration-grid">
                <div class="nj-collaboration-copy-col" data-reveal-up>
                    <span class="nj-section-label">| 07 &mdash; BEYOND RESIDENTIAL</span>
                    <h2 class="nj-section-headline">
                        &ldquo;Building spaces.<br>
                        Building <em>partnerships.</em>&rdquo;
                    </h2>

                    <p class="nj-lead-paragraph">
                        NJ INTERIORS welcomes opportunities to collaborate on boutique hotels, resorts, restaurants, offices, showrooms and other commercial environments.
                    </p>
                    <p class="nj-body-paragraph">
                        Depending on project requirements and technical assessment, the firm can explore individual interior packages, specialist joinery scopes or broader fit-out opportunities.
                    </p>

                    <div class="nj-collab-lists-grid">
                        <div class="nj-collab-list-block">
                            <span class="nj-micro-label d-block mb-3">POTENTIAL PACKAGES</span>
                            <ul class="nj-editorial-list">
                                <li>Hotel guest rooms and suites.</li>
                                <li>Reception, lobby and common-area interiors.</li>
                                <li>Restaurant and caf&eacute; fit-outs.</li>
                                <li>Wardrobes and fixed furniture.</li>
                                <li>Custom joinery.</li>
                                <li>Ceiling and wall finishes.</li>
                            </ul>
                        </div>

                        <div class="nj-collab-list-block">
                            <span class="nj-micro-label d-block mb-3">COLLABORATION MODELS</span>
                            <ul class="nj-editorial-list">
                                <li>Direct client appointment.</li>
                                <li>Architect-led execution partnership.</li>
                                <li>Subcontracted fit-out packages.</li>
                                <li>Tender participation where eligible.</li>
                            </ul>
                        </div>
                    </div>

                    <p class="nj-collab-disclaimer">
                        Note: Hospitality and commercial scopes presented here reflect target capabilities and partnership opportunities explored following technical and commercial assessment.
                    </p>
                </div>

                <div class="nj-collaboration-visual-col" data-reveal-scale>
                    <div class="nj-collab-image-monolith nj-tilt-card">
                        <img src="<?= Html::encode($imgCommercial) ?>"
                             alt="Boutique hospitality and commercial architectural interior concept by NJ INTERIORS"
                             loading="lazy">
                        <div class="nj-collab-image-caption">
                            <span class="nj-micro-label">HOSPITALITY &amp; COMMERCIAL FIT-OUT CAPABILITIES</span>
                            <strong>Bespoke Joinery, Metalwork &amp; Coordinated Interior Packages</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 10 — OUR VISION (SCROLL-EXPANDING ARCHITECTURAL PORTAL)
         ======================================================================= -->
    <section id="vision" class="nj-vision-break" aria-label="Our Vision">
        <div class="nj-vision-media-wrap" id="visionZoomWrap">
            <img src="<?= Html::encode($imgBedroom) ?>"
                 alt="NJ INTERIORS — Timeless Architectural Interior Vision"
                 class="nj-vision-bg-img"
                 id="visionZoomImg"
                 loading="lazy">
            <div class="nj-vision-scrim"></div>
        </div>

        <div class="nj-container nj-vision-content">
            <span class="nj-vision-signature-top">NJ INTERIORS</span>
            <h2 class="nj-vision-quote" data-reveal-lines>
                &ldquo;Every space has a story.<br>
                Let&rsquo;s create <em>yours.</em>&rdquo;
            </h2>
            <span class="nj-vision-signature-bottom">CRAFTING LUXURY WITH CARE &bull; EST. 2016</span>
        </div>
    </section>

    <!-- =======================================================================
         SECTION 11 — CONTACT / FINAL CTA (REEL 2 MONUMENTAL CTA + 4 HOVER-LIFT CARDS)
         ======================================================================= -->
    <section id="contact" class="nj-section nj-theme-ivory nj-contact-section">
        <div class="nj-container">
            <!-- Monumental Editorial Closing Statement (Reel 2 00:21–00:24 Style) -->
            <div class="nj-contact-monument-header" data-reveal-up>
                <span class="nj-section-label">| 08 &mdash; INITIATE A DIALOGUE</span>
                <h2 class="nj-contact-monument-title">
                    LET&rsquo;S BUILD<br>
                    <span>SOMETHING EXCEPTIONAL.</span>
                </h2>
                <p class="nj-contact-monument-lead">
                    Have a space in mind? Let&rsquo;s discuss your vision and explore how NJ INTERIORS can bring it to life.
                </p>
            </div>

            <!-- Reel 2 (00:22–00:24) 4-Column Interactive Hover-Lift Contact Cards -->
            <div class="nj-contact-lift-grid mb-5" data-reveal-up>
                <a href="tel:+919583205010" class="nj-contact-lift-card">
                    <div class="nj-lift-card-top">
                        <span class="nj-micro-label">01 / DIRECT PHONE</span>
                        <span class="nj-lift-arrow">&#8599;</span>
                    </div>
                    <strong>+91 95832 05010</strong>
                    <span class="nj-lift-sub">Alt: +91 91240 01910</span>
                </a>

                <a href="https://wa.me/919583205010?text=<?= urlencode('Hello NJ INTERIORS (Mr. Nitesh Jangda), I would like to discuss an interior design project.') ?>"
                   target="_blank"
                   rel="noopener"
                   class="nj-contact-lift-card is-featured">
                    <div class="nj-lift-card-top">
                        <span class="nj-micro-label">02 / WHATSAPP</span>
                        <span class="nj-lift-arrow">&#8599;</span>
                    </div>
                    <strong>Instant Project Chat</strong>
                    <span class="nj-lift-sub">+91 95832 05010 &bull; Nitesh Jangda</span>
                </a>

                <a href="mailto:njinteriorbbs@gmail.com" class="nj-contact-lift-card">
                    <div class="nj-lift-card-top">
                        <span class="nj-micro-label">03 / EMAIL</span>
                        <span class="nj-lift-arrow">&#8599;</span>
                    </div>
                    <strong>njinteriorbbs@gmail.com</strong>
                    <span class="nj-lift-sub">Drawings, Briefs &amp; Tenders</span>
                </a>

                <a href="<?= Html::encode($instagramUrl) ?>" target="_blank" rel="noopener" class="nj-contact-lift-card">
                    <div class="nj-lift-card-top">
                        <span class="nj-micro-label">04 / INSTAGRAM</span>
                        <span class="nj-lift-arrow">&#8599;</span>
                    </div>
                    <strong>@njinterio</strong>
                    <span class="nj-lift-sub">Bhubaneswar, Odisha</span>
                </a>
            </div>

            <div class="nj-contact-grid">
                <!-- Left Column: Studio Office Details -->
                <div class="nj-contact-info-col" data-reveal-up>
                    <div class="nj-contact-brand-card">
                        <h3 class="nj-contact-brand-name">NJ INTERIORS</h3>
                        <p class="nj-contact-brand-sub">Crafting Luxury with Care.</p>

                        <div class="nj-contact-details-stack">
                            <div class="nj-contact-detail-group">
                                <span class="nj-micro-label">REGISTERED OFFICE</span>
                                <address class="nj-contact-address">
                                    O-5, Ground Floor, Aster Block,<br>
                                    D.N. OxyPark, Cosmopolis Road,<br>
                                    Dumuduma, Bhubaneswar,<br>
                                    Khordha, Odisha &ndash; 751019.
                                </address>
                                <a href="<?= Html::encode($googleMapsUrl) ?>" target="_blank" rel="noopener" class="nj-text-link-gold">
                                    Open in Google Maps &#8599;
                                </a>
                            </div>

                            <div class="nj-contact-detail-group">
                                <span class="nj-micro-label">DIRECT STUDIO LINES</span>
                                <p class="mb-1">
                                    <a href="tel:+919583205010" class="nj-contact-link">+91 95832 05010</a>
                                </p>
                                <p class="mb-2">
                                    <a href="tel:+919124001910" class="nj-contact-link">+91 91240 01910</a>
                                </p>
                                <span class="nj-micro-label">EMAIL &amp; SOCIAL</span>
                                <p class="mb-1">
                                    <a href="mailto:njinteriorbbs@gmail.com" class="nj-contact-link">njinteriorbbs@gmail.com</a>
                                </p>
                                <p class="mb-0">
                                    <a href="<?= Html::encode($instagramUrl) ?>" target="_blank" rel="noopener" class="nj-contact-link">@njinterio &#8599;</a>
                                </p>
                            </div>
                        </div>

                        <div class="nj-contact-quick-actions">
                            <a href="https://wa.me/919583205010?text=<?= urlencode('Hello NJ INTERIORS (Mr. Nitesh Jangda), I would like to discuss an interior design project.') ?>"
                               target="_blank"
                               rel="noopener"
                               id="directWhatsappBtn"
                               class="nj-btn-whatsapp nj-magnetic"
                               data-strength="15">
                                <span>WhatsApp Enquiry (+91 95832 05010)</span>
                                <span>&#8599;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Functional Yii2 CSRF-Protected Enquiry Form -->
                <div class="nj-contact-form-col" data-reveal-up>
                    <div class="nj-enquiry-form-shell">
                        <div class="nj-enquiry-header">
                            <span class="nj-micro-label">PROJECT ENQUIRY</span>
                            <h3 class="nj-enquiry-title">Send Your Project Brief</h3>
                        </div>

                        <?php if ($flashSuccess): ?>
                            <div class="nj-alert nj-alert-success" role="alert">
                                <?= Html::encode($flashSuccess) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($flashError): ?>
                            <div class="nj-alert nj-alert-error" role="alert">
                                <?= Html::encode($flashError) ?>
                            </div>
                        <?php endif; ?>

                        <form id="njEnquiryForm"
                              action="<?= Html::encode($contactSubmitUrl) ?>"
                              method="post"
                              class="nj-enquiry-form"
                              novalidate>
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

                            <div class="nj-honeypot" aria-hidden="true">
                                <label for="contact-website">Website</label>
                                <input type="text" id="contact-website" name="ContactForm[website]" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="nj-form-row">
                                <div class="nj-form-group">
                                    <label for="contact-name" class="nj-form-label">Full Name *</label>
                                    <input type="text"
                                           id="contact-name"
                                           name="ContactForm[name]"
                                           class="nj-form-control"
                                           placeholder="Your full name"
                                           required
                                           minlength="2"
                                           maxlength="120">
                                    <span class="nj-field-error" data-error-for="name"></span>
                                </div>

                                <div class="nj-form-group">
                                    <label for="contact-phone" class="nj-form-label">Phone Number *</label>
                                    <input type="tel"
                                           id="contact-phone"
                                           name="ContactForm[phone]"
                                           class="nj-form-control"
                                           placeholder="+91 98765 43210"
                                           required
                                           pattern="^[0-9+\-\s()]{7,22}$">
                                    <span class="nj-field-error" data-error-for="phone"></span>
                                </div>
                            </div>

                            <div class="nj-form-row">
                                <div class="nj-form-group">
                                    <label for="contact-email" class="nj-form-label">Email Address *</label>
                                    <input type="email"
                                           id="contact-email"
                                           name="ContactForm[email]"
                                           class="nj-form-control"
                                           placeholder="you@example.com"
                                           required
                                           maxlength="160">
                                    <span class="nj-field-error" data-error-for="email"></span>
                                </div>

                                <div class="nj-form-group">
                                    <label for="contact-project-type" class="nj-form-label">Project Type *</label>
                                    <select id="contact-project-type"
                                            name="ContactForm[projectType]"
                                            class="nj-form-control nj-form-select"
                                            required>
                                        <option value="">Select project category</option>
                                        <?php foreach (ContactForm::projectTypeOptions() as $val => $label): ?>
                                            <option value="<?= Html::encode($val) ?>"><?= Html::encode($label) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="nj-field-error" data-error-for="projectType"></span>
                                </div>
                            </div>

                            <div class="nj-form-group">
                                <label for="contact-message" class="nj-form-label">Your Message &amp; Project Details *</label>
                                <textarea id="contact-message"
                                          name="ContactForm[message]"
                                          class="nj-form-control nj-form-textarea"
                                          rows="4"
                                          placeholder="Tell us about your property location, approximate area, requirements, and timeline..."
                                          required
                                          minlength="10"
                                          maxlength="3000"></textarea>
                                <span class="nj-field-error" data-error-for="message"></span>
                            </div>

                            <div id="enquiryStatusBox" class="nj-alert d-none" role="status" aria-live="polite"></div>

                            <div class="nj-form-submit-row">
                                <button type="submit" id="enquirySubmitBtn" class="nj-btn-primary nj-magnetic" data-strength="18">
                                    <span id="enquirySubmitText">Submit Enquiry</span>
                                    <span aria-hidden="true">&#8599;</span>
                                </button>

                                <button type="button" id="formWhatsappSendBtn" class="nj-btn-secondary">
                                    <span>Send Form via WhatsApp</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================================================================
         FULLSCREEN PROJECT PRESENTATION MODAL
         ======================================================================= -->
    <div id="projectFullscreenModal" class="nj-project-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalProjectTitle">
        <div class="nj-project-modal-backdrop" data-close-project-modal></div>
        <div class="nj-project-modal-content">
            <button type="button" class="nj-project-modal-close" data-close-project-modal aria-label="Close fullscreen preview">
                <span>CLOSE</span>
                <span>&times;</span>
            </button>

            <div class="nj-project-modal-grid">
                <div class="nj-project-modal-media">
                    <img id="modalProjectImage" src="" alt="">
                </div>
                <div class="nj-project-modal-details">
                    <span id="modalProjectCategory" class="nj-section-label"></span>
                    <h3 id="modalProjectTitle" class="nj-modal-title"></h3>

                    <div class="nj-modal-meta-list">
                        <div>
                            <span class="nj-micro-label">LOCATION</span>
                            <strong id="modalProjectLocation"></strong>
                        </div>
                        <div>
                            <span class="nj-micro-label">PORTFOLIO YEAR</span>
                            <strong id="modalProjectYear"></strong>
                        </div>
                        <div>
                            <span class="nj-micro-label">STUDIO</span>
                            <strong>NJ INTERIORS &mdash; Nitesh Kumar Jangda</strong>
                        </div>
                    </div>

                    <p id="modalProjectDescription" class="nj-modal-desc"></p>
                    <p id="modalProjectNote" class="nj-modal-note"></p>

                    <div class="mt-4">
                        <a href="#contact" class="nj-btn-primary d-inline-flex" data-close-project-modal>
                            <span>Discuss a Similar Space</span>
                            <span>&#8599;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
