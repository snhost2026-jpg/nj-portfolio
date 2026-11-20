/**
 * NJ INTERIORS — High-Impact Continuous Scroll-Driven & 3D Motion Choreography
 *
 * Key Root-Cause Fix:
 * Windows "MinAnimate = 0" sets OS `prefers-reduced-motion: reduce` to true in Chrome/Edge,
 * which previously caused `initAnimations()` to exit early and skipped all ScrollTrigger
 * registrations while still allowing button-click animations.
 * All scroll-driven animations, 3D card decks, image curtain reveals, and parallax motions
 * now run unconditionally by default.
 */
(function () {
    'use strict';

    function splitTextToChars(element) {
        if (!element || element.dataset.splitDone === 'true') return;
        const text = element.textContent || '';
        element.textContent = '';
        element.dataset.splitDone = 'true';

        for (let i = 0; i < text.length; i++) {
            const ch = text[i];
            const span = document.createElement('span');
            span.className = 'nj-char';
            span.textContent = ch === ' ' ? '\u00A0' : ch;
            element.appendChild(span);
        }
    }

    function splitLinesToWords(container) {
        if (!container || container.dataset.wordSplitDone === 'true') return;
        container.dataset.wordSplitDone = 'true';

        container.querySelectorAll('.nj-line-inner').forEach(function (line) {
            const rawHTML = line.innerHTML;
            const temp = document.createElement('div');
            temp.innerHTML = rawHTML;
            line.innerHTML = '';

            Array.from(temp.childNodes).forEach(function (node) {
                if (node.nodeType === Node.TEXT_NODE) {
                    const words = (node.textContent || '').split(/(\s+)/);
                    words.forEach(function (w) {
                        if (/^\s+$/.test(w)) {
                            line.appendChild(document.createTextNode(w));
                        } else if (w.length > 0) {
                            const span = document.createElement('span');
                            span.className = 'nj-scrub-word';
                            span.textContent = w;
                            line.appendChild(span);
                        }
                    });
                } else if (node.nodeType === Node.ELEMENT_NODE) {
                    const wrapper = document.createElement(node.tagName.toLowerCase());
                    wrapper.className = 'nj-scrub-word ' + (node.className || '');
                    wrapper.innerHTML = node.innerHTML;
                    line.appendChild(wrapper);
                }
            });
        });
    }

    /* ----------------------------------------------------------------------
       1. CONTINUOUS SCROLL-DRIVEN 3D FAN DECK // DISCIPLINES
       Cards fan open as the section enters the viewport and glide continuously
       across the 3D arc from Card 01 to Card 05 as you scroll!
       ---------------------------------------------------------------------- */
    function initFanDeck3D(gsap, ScrollTrigger) {
        const cards = Array.from(document.querySelectorAll('.nj-fandeck-card'));
        const tabs = Array.from(document.querySelectorAll('.nj-fandeck-tab'));
        const stageWrap = document.getElementById('fanDeckStageWrap');
        if (!cards.length || !stageWrap) return;

        // progressIndex: 0.00 -> 4.00 (which card is centered)
        // spreadFactor: 0.15 -> 1.00 (how fanned-out the deck is as it enters view)
        const deckState = {
            progressIndex: 0,
            spreadFactor: 1
        };

        function renderFanDeck() {
            const floatIdx = deckState.progressIndex;
            const spread = deckState.spreadFactor;
            const nearestInt = Math.max(0, Math.min(cards.length - 1, Math.round(floatIdx)));
            const isMobile = window.innerWidth < 768;

            tabs.forEach(function (tab, i) {
                tab.classList.toggle('is-active', i === nearestInt);
            });

            cards.forEach(function (card, i) {
                const offset = i - floatIdx;
                const absOffset = Math.abs(offset);

                const spreadX = offset * (isMobile ? 95 : 210) * spread;
                const dropY = ((offset * offset) * (isMobile ? 8 : 16) - 10) * spread + (1 - spread) * 70;
                const rotZ = offset * (isMobile ? 6.5 : 11) * spread;
                const rotY = offset * -15 * spread;
                const translateZ = -absOffset * 85 * spread;
                const scale = Math.max(0.74, (1.06 - absOffset * 0.11) * (0.85 + 0.15 * spread));
                const opacity = Math.max(0.2, 1 - absOffset * 0.32);
                const brightness = Math.max(0.38, 1 - absOffset * 0.3);

                card.classList.toggle('is-active', absOffset < 0.45);
                card.style.zIndex = String(Math.round(100 - absOffset * 20));
                card.style.opacity = opacity.toFixed(3);
                card.style.filter = 'brightness(' + brightness.toFixed(2) + ')';
                card.style.transform =
                    'translate3d(' + spreadX.toFixed(2) + 'px, ' + dropY.toFixed(2) + 'px, ' + translateZ.toFixed(2) + 'px) ' +
                    'rotateZ(' + rotZ.toFixed(2) + 'deg) rotateY(' + rotY.toFixed(2) + 'deg) scale(' + scale.toFixed(3) + ')';
            });
        }

        function animateToCard(targetIndex) {
            if (gsap) {
                gsap.to(deckState, {
                    progressIndex: targetIndex,
                    spreadFactor: 1,
                    duration: 0.9,
                    ease: 'power3.out',
                    overwrite: 'auto',
                    onUpdate: renderFanDeck
                });
            } else {
                deckState.progressIndex = targetIndex;
                deckState.spreadFactor = 1;
                renderFanDeck();
            }
        }

        cards.forEach(function (card, idx) {
            card.addEventListener('click', function () {
                animateToCard(idx);
            });
        });

        tabs.forEach(function (tab, idx) {
            tab.addEventListener('click', function () {
                animateToCard(idx);
            });
        });

        window.addEventListener('resize', renderFanDeck);

        // Continuous scroll listener that ALWAYS glides the Fan Deck cards as you scroll through the viewport
        function updateFanDeckOnViewportScroll() {
            const rect = stageWrap.getBoundingClientRect();
            const vh = window.innerHeight;
            // As the stage moves from entering the bottom (rect.top = vh * 0.85)
            // to leaving the top (rect.bottom = vh * 0.25)
            const totalTravel = vh * 0.85 + rect.height * 0.75;
            const currentTravel = vh * 0.85 - rect.top;
            const rawRatio = currentTravel / Math.max(1, totalTravel);
            const clampedRatio = Math.max(0, Math.min(1, rawRatio));

            // First 20% of travel fans the deck open from stacked -> full arc;
            // Across 0% -> 100% of travel, progressIndex smoothly sweeps 0.00 -> 4.00
            const targetSpread = Math.min(1, 0.25 + (clampedRatio / 0.25) * 0.75);
            const targetIndex = clampedRatio * (cards.length - 1);

            if (gsap) {
                gsap.to(deckState, {
                    progressIndex: targetIndex,
                    spreadFactor: targetSpread,
                    duration: 0.45,
                    ease: 'power2.out',
                    overwrite: 'auto',
                    onUpdate: renderFanDeck
                });
            } else {
                deckState.progressIndex = targetIndex;
                deckState.spreadFactor = targetSpread;
                renderFanDeck();
            }
        }

        window.addEventListener('scroll', updateFanDeckOnViewportScroll, { passive: true });
        updateFanDeckOnViewportScroll();
    }

    /* ----------------------------------------------------------------------
       2. CONTINUOUS SCROLL-DRIVEN 3D COVERFLOW / SPATIAL DEPTH STACK
       Cards glide smoothly in 3D Z-space from Card 01 to Card 06 as you scroll!
       ---------------------------------------------------------------------- */
    function initCoverflow3D(gsap) {
        const cards = Array.from(document.querySelectorAll('.nj-coverflow-card'));
        const prevBtn = document.getElementById('coverflowPrevBtn');
        const nextBtn = document.getElementById('coverflowNextBtn');
        const counterEl = document.getElementById('coverflowCounter');
        const sectionEl = document.getElementById('coverflowSection');
        if (!cards.length || !sectionEl) return;

        const cfState = {
            progressIndex: 0,
            spreadFactor: 1
        };

        function renderCoverflow() {
            const floatIdx = cfState.progressIndex;
            const spread = cfState.spreadFactor;
            const nearestInt = Math.max(0, Math.min(cards.length - 1, Math.round(floatIdx)));
            if (counterEl) {
                counterEl.textContent = '0' + (nearestInt + 1) + ' / 0' + cards.length;
            }

            const isMobile = window.innerWidth < 768;

            cards.forEach(function (card, i) {
                const offset = i - floatIdx;
                const absOffset = Math.abs(offset);

                const tx = offset * (isMobile ? 185 : 295) * spread;
                const ty = (1 - spread) * 60;
                const tz = -absOffset * 130 * spread;
                const ry = offset * -16 * spread;
                const scale = Math.max(0.72, (1.06 - absOffset * 0.12) * (0.85 + 0.15 * spread));
                const opacity = Math.max(0, 1 - absOffset * 0.35);
                const blurPx = Math.max(0, (absOffset - 0.15) * 1.8);

                card.classList.toggle('is-center', absOffset < 0.45);
                card.style.zIndex = String(Math.round(100 - absOffset * 20));
                card.style.opacity = opacity.toFixed(3);
                card.style.pointerEvents = absOffset > 2.2 ? 'none' : 'auto';
                card.style.filter = blurPx > 0.1 ? 'blur(' + blurPx.toFixed(2) + 'px)' : 'none';
                card.style.transform =
                    'translate3d(' + tx.toFixed(2) + 'px, ' + ty.toFixed(2) + 'px, ' + tz.toFixed(2) + 'px) ' +
                    'rotateY(' + ry.toFixed(2) + 'deg) scale(' + scale.toFixed(3) + ')';
            });
        }

        function animateToSlide(targetIdx) {
            const clamped = Math.max(0, Math.min(cards.length - 1, targetIdx));
            if (gsap) {
                gsap.to(cfState, {
                    progressIndex: clamped,
                    spreadFactor: 1,
                    duration: 0.9,
                    ease: 'power3.out',
                    overwrite: 'auto',
                    onUpdate: renderCoverflow
                });
            } else {
                cfState.progressIndex = clamped;
                cfState.spreadFactor = 1;
                renderCoverflow();
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                animateToSlide(Math.round(cfState.progressIndex) - 1);
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                animateToSlide(Math.round(cfState.progressIndex) + 1);
            });
        }

        cards.forEach(function (card, idx) {
            card.addEventListener('click', function (e) {
                if (Math.abs(idx - cfState.progressIndex) > 0.35) {
                    e.stopPropagation();
                    animateToSlide(idx);
                }
            });
        });

        window.addEventListener('resize', renderCoverflow);

        // Continuous scroll listener that smoothly glides across all 6 Coverflow cards as you scroll
        function updateCoverflowOnViewportScroll() {
            const rect = sectionEl.getBoundingClientRect();
            const vh = window.innerHeight;
            const totalTravel = vh * 0.85 + rect.height * 0.75;
            const currentTravel = vh * 0.85 - rect.top;
            const clampedRatio = Math.max(0, Math.min(1, currentTravel / Math.max(1, totalTravel)));

            const targetSpread = Math.min(1, 0.25 + (clampedRatio / 0.25) * 0.75);
            const targetIndex = clampedRatio * (cards.length - 1);

            if (gsap) {
                gsap.to(cfState, {
                    progressIndex: targetIndex,
                    spreadFactor: targetSpread,
                    duration: 0.45,
                    ease: 'power2.out',
                    overwrite: 'auto',
                    onUpdate: renderCoverflow
                });
            } else {
                cfState.progressIndex = targetIndex;
                cfState.spreadFactor = targetSpread;
                renderCoverflow();
            }
        }

        window.addEventListener('scroll', updateCoverflowOnViewportScroll, { passive: true });
        updateCoverflowOnViewportScroll();
    }

    function initAnimations() {
        const brandTitle = document.getElementById('heroBrandTitle');
        if (brandTitle) {
            splitTextToChars(brandTitle);
        }

        const gsap = typeof window.gsap !== 'undefined' ? window.gsap : null;
        const ScrollTrigger = typeof window.ScrollTrigger !== 'undefined' ? window.ScrollTrigger : null;
        if (gsap && ScrollTrigger) {
            gsap.registerPlugin(ScrollTrigger);
        }

        initFanDeck3D(gsap, ScrollTrigger);
        initCoverflow3D(gsap, ScrollTrigger);

        if (!gsap) return;

        /* ------------------------------------------------------------------
           3. HERO OPENING CHOREOGRAPHY & CONTINUOUS SCROLL TRANSFORM
           ------------------------------------------------------------------ */
        const heroSection = document.getElementById('hero');
        const heroGiantText = document.getElementById('heroGiantTextLayer');
        const heroMonolith = document.getElementById('heroMonolithCard');
        const heroFlankLeft = document.getElementById('heroFlankLeft');
        const heroFlankRight = document.getElementById('heroFlankRight');
        const heroBottomBar = document.getElementById('heroBottomBar');

        function playHeroIntro() {
            const chars = document.querySelectorAll('#heroBrandTitle .nj-char');
            const metaEls = document.querySelectorAll('.nj-hero-reveal-meta');
            const heroBg = document.querySelector('.nj-hero-bg-image');

            const tl = gsap.timeline({ defaults: { ease: 'expo.out' } });

            if (heroBg) {
                tl.fromTo(heroBg, { scale: 1.24 }, { scale: 1.0, duration: 2.1 }, 0);
            }

            if (chars.length) {
                tl.fromTo(chars,
                    { yPercent: 115, rotateX: -80, opacity: 0 },
                    { yPercent: 0, rotateX: 0, opacity: 1, duration: 1.4, stagger: 0.035 },
                    0.12
                );
            }

            if (heroMonolith) {
                tl.fromTo(heroMonolith,
                    { y: 95, scale: 0.82, rotateX: 16, opacity: 0, clipPath: 'inset(24% 18% 24% 18%)' },
                    { y: 0, scale: 1, rotateX: 0, opacity: 1, clipPath: 'inset(0% 0% 0% 0%)', duration: 1.55 },
                    0.25
                );
            }

            if (metaEls.length) {
                tl.fromTo(metaEls,
                    { y: 24, opacity: 0 },
                    { y: 0, opacity: 1, duration: 1.05, stagger: 0.08 },
                    0.45
                );
            }
        }

        document.addEventListener('nj:preloaderComplete', playHeroIntro);

        // Cursor-reactive 3D tilt on Hero Portal & Giant Title
        if (window.matchMedia('(pointer: fine)').matches && heroMonolith) {
            window.addEventListener('mousemove', function (e) {
                if (window.scrollY > 250) return;
                const nx = (e.clientX / window.innerWidth) - 0.5;
                const ny = (e.clientY / window.innerHeight) - 0.5;

                gsap.to(heroMonolith, {
                    rotateY: nx * 12,
                    rotateX: -ny * 10,
                    x: nx * 20,
                    y: ny * 12,
                    duration: 0.6,
                    ease: 'power2.out',
                    overwrite: 'auto'
                });

                if (heroGiantText) {
                    gsap.to(heroGiantText, {
                        x: -nx * 26,
                        y: -ny * 12,
                        duration: 0.75,
                        ease: 'power2.out',
                        overwrite: 'auto'
                    });
                }
            }, { passive: true });
        }

        if (!ScrollTrigger) return;

        // Hero scroll transformation as user scrolls down into Section 02
        if (heroSection && heroMonolith) {
            const heroScrollTl = gsap.timeline({
                scrollTrigger: {
                    trigger: heroSection,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 0.65
                }
            });

            if (heroGiantText) {
                heroScrollTl.to(heroGiantText, { yPercent: -65, scale: 0.88, opacity: 0.08, ease: 'none' }, 0);
            }
            if (heroFlankLeft) {
                heroScrollTl.to(heroFlankLeft, { xPercent: -45, yPercent: -20, opacity: 0, ease: 'none' }, 0);
            }
            if (heroFlankRight) {
                heroScrollTl.to(heroFlankRight, { xPercent: 45, yPercent: -20, opacity: 0, ease: 'none' }, 0);
            }
            if (heroMonolith) {
                heroScrollTl.to(heroMonolith, { scale: 1.24, yPercent: 14, ease: 'none' }, 0);
            }
        }

        /* ------------------------------------------------------------------
           4. ALL SECTION HEADERS, LABELS & HEADLINES — DYNAMIC SCROLL MOTION
           ------------------------------------------------------------------ */
        document.querySelectorAll('.nj-section-label').forEach(function (label) {
            gsap.fromTo(label,
                { x: -45, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: label,
                        start: 'top 95%',
                        end: 'top 62%',
                        scrub: 0.6
                    }
                }
            );
        });

        document.querySelectorAll('.nj-section-headline, .nj-video-headline, .nj-founder-headline, .nj-contact-monument-title, .nj-coverflow-heading').forEach(function (heading) {
            gsap.fromTo(heading,
                { y: 75, rotateX: -18, scale: 0.94, opacity: 0, transformPerspective: 900 },
                {
                    y: 0,
                    rotateX: 0,
                    scale: 1,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: heading,
                        start: 'top 95%',
                        end: 'top 55%',
                        scrub: 0.7
                    }
                }
            );
        });

        document.querySelectorAll('.nj-section-header-note, .nj-contact-monument-lead').forEach(function (note) {
            gsap.fromTo(note,
                { y: 48, opacity: 0 },
                {
                    y: 0,
                    opacity: 0.88,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: note,
                        start: 'top 95%',
                        end: 'top 60%',
                        scrub: 0.65
                    }
                }
            );
        });

        /* ------------------------------------------------------------------
           5. SECTION 02 — BRAND STATEMENT (SLIDING LINES + JOINERY REVEAL)
           ------------------------------------------------------------------ */
        const statementHeadline = document.querySelector('.nj-statement-headline');
        if (statementHeadline) {
            splitLinesToWords(statementHeadline);
            const scrubWords = statementHeadline.querySelectorAll('.nj-scrub-word');
            if (scrubWords.length) {
                gsap.fromTo(scrubWords,
                    { opacity: 0.1, y: 36, rotateX: -25 },
                    {
                        opacity: 1,
                        y: 0,
                        rotateX: 0,
                        stagger: 0.08,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: statementHeadline,
                            start: 'top 88%',
                            end: 'bottom 45%',
                            scrub: 0.65
                        }
                    }
                );
            }

            const lines = statementHeadline.querySelectorAll('.nj-line-wrap');
            lines.forEach(function (line, idx) {
                const startX = idx === 0 ? -95 : (idx === 1 ? 85 : -75);
                gsap.fromTo(line,
                    { x: startX },
                    {
                        x: 0,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: statementHeadline,
                            start: 'top 94%',
                            end: 'bottom 38%',
                            scrub: 0.75
                        }
                    }
                );
            });
        }

        // Section 02 Joinery Image Frame — starts tilted, clipped, and displaced
        const statementAccentFrame = document.querySelector('.nj-statement-visual-accent .nj-mask-image-frame');
        if (statementAccentFrame) {
            const innerImg = statementAccentFrame.querySelector('img');
            gsap.fromTo(statementAccentFrame,
                { y: 120, x: 45, rotateZ: 5, rotateY: -14, scale: 0.84, clipPath: 'inset(28% 18% 28% 18%)', opacity: 0 },
                {
                    y: 0,
                    x: 0,
                    rotateZ: 0,
                    rotateY: 0,
                    scale: 1,
                    clipPath: 'inset(0% 0% 0% 0%)',
                    opacity: 1,
                    transformPerspective: 1000,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: statementAccentFrame,
                        start: 'top 95%',
                        end: 'top 42%',
                        scrub: 0.75
                    }
                }
            );
            if (innerImg) {
                gsap.fromTo(innerImg,
                    { scale: 1.28, yPercent: -10 },
                    {
                        scale: 1.0,
                        yPercent: 10,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: statementAccentFrame,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 0.8
                        }
                    }
                );
            }
        }

        /* ------------------------------------------------------------------
           6. SECTION 03 — 3D VIDEO MONOLITH SWING-IN & CONSOLE GLIDE
           ------------------------------------------------------------------ */
        const videoMonolith = document.getElementById('companyVideoFrame');
        const videoSection = document.getElementById('company-video');
        if (videoMonolith && videoSection) {
            gsap.fromTo(videoMonolith,
                { clipPath: 'inset(26% 20% 26% 20%)', y: 125, scale: 0.78, rotateY: -26, rotateX: 10, opacity: 0.1 },
                {
                    clipPath: 'inset(0% 0% 0% 0%)',
                    y: 0,
                    scale: 1,
                    rotateY: 0,
                    rotateX: 0,
                    opacity: 1,
                    transformPerspective: 1200,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: videoSection,
                        start: 'top 86%',
                        end: 'top 20%',
                        scrub: 0.8
                    }
                }
            );
        }

        document.querySelectorAll('.nj-video-control-console, .nj-video-spec-pill').forEach(function (el, idx) {
            gsap.fromTo(el,
                { x: -65, y: 45 + idx * 15, opacity: 0 },
                {
                    x: 0,
                    y: 0,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 95%',
                        end: 'top 58%',
                        scrub: 0.7
                    }
                }
            );
        });

        /* ------------------------------------------------------------------
           7. SECTION 04 — ABOUT IMAGES CURTAIN UNCLIP & OVERLAPPING MOTION
           ------------------------------------------------------------------ */
        const aboutPrimaryWrap = document.querySelector('.nj-about-primary-img-wrap');
        if (aboutPrimaryWrap) {
            const pImg = aboutPrimaryWrap.querySelector('img');
            gsap.fromTo(aboutPrimaryWrap,
                { clipPath: 'inset(35% 22% 35% 22%)', y: 110, rotateY: 14, scale: 0.85, opacity: 0.1 },
                {
                    clipPath: 'inset(0% 0% 0% 0%)',
                    y: 0,
                    rotateY: 0,
                    scale: 1,
                    opacity: 1,
                    transformPerspective: 1100,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: aboutPrimaryWrap,
                        start: 'top 94%',
                        end: 'top 30%',
                        scrub: 0.8
                    }
                }
            );
            if (pImg) {
                gsap.fromTo(pImg,
                    { scale: 1.3, yPercent: -12 },
                    {
                        scale: 1.0,
                        yPercent: 12,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: aboutPrimaryWrap,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 0.8
                        }
                    }
                );
            }
        }

        const aboutSecondaryWrap = document.querySelector('.nj-about-secondary-img-wrap');
        if (aboutSecondaryWrap) {
            gsap.fromTo(aboutSecondaryWrap,
                { y: 145, x: 75, rotateZ: 7, scale: 0.8, opacity: 0 },
                {
                    y: -25,
                    x: 0,
                    rotateZ: 0,
                    scale: 1,
                    opacity: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: aboutSecondaryWrap,
                        start: 'top 98%',
                        end: 'top 35%',
                        scrub: 0.8
                    }
                }
            );
        }

        const floatingYearBadge = document.querySelector('.nj-floating-year-badge');
        if (floatingYearBadge) {
            gsap.fromTo(floatingYearBadge,
                { x: -70, y: -45, scale: 0.78, opacity: 0 },
                {
                    x: 0,
                    y: 25,
                    scale: 1,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: floatingYearBadge,
                        start: 'top 95%',
                        end: 'bottom 20%',
                        scrub: 0.8
                    }
                }
            );
        }

        document.querySelectorAll('.nj-about-prose p, .nj-lead-paragraph, .nj-body-paragraph, .nj-micro-manifesto').forEach(function (p) {
            gsap.fromTo(p,
                { y: 45, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: p,
                        start: 'top 95%',
                        end: 'top 62%',
                        scrub: 0.65
                    }
                }
            );
        });

        const quoteBox = document.querySelector('.nj-editorial-quote-box');
        if (quoteBox) {
            gsap.fromTo(quoteBox,
                { x: 75, y: 70, rotateY: -12, scale: 0.9, opacity: 0 },
                {
                    x: 0,
                    y: 0,
                    rotateY: 0,
                    scale: 1,
                    opacity: 1,
                    transformPerspective: 1000,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: quoteBox,
                        start: 'top 95%',
                        end: 'top 48%',
                        scrub: 0.75
                    }
                }
            );
        }

        /* ------------------------------------------------------------------
           8. SECTION 05 — 5 HORIZONTAL EXPERTISE ROWS (ALTERNATING 3D GLIDE)
           ------------------------------------------------------------------ */
        document.querySelectorAll('.nj-expertise-panel').forEach(function (panel, idx) {
            const startX = idx % 2 === 0 ? -70 : 70;
            gsap.fromTo(panel,
                { y: 60, x: startX, opacity: 0 },
                {
                    y: 0,
                    x: 0,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: panel,
                        start: 'top 95%',
                        end: 'top 60%',
                        scrub: 0.7
                    }
                }
            );
        });

        /* ------------------------------------------------------------------
           9. SECTION 06 — PROJECT POSTER CARDS (3D TILTED ENTRANCE + ZOOM)
           ------------------------------------------------------------------ */
        const filterContainer = document.querySelector('.nj-portfolio-filters');
        if (filterContainer) {
            const tabs = filterContainer.querySelectorAll('.nj-filter-tab');
            gsap.fromTo(tabs,
                { y: 30, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    stagger: 0.05,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: filterContainer,
                        start: 'top 95%',
                        end: 'top 65%',
                        scrub: 0.65
                    }
                }
            );
        }

        document.querySelectorAll('.nj-project-card').forEach(function (card, idx) {
            const imgBox = card.querySelector('.nj-project-img-box');
            const img = card.querySelector('.nj-project-img');
            const caption = card.querySelector('.nj-project-caption');
            const isLeft = idx % 2 === 0;

            gsap.fromTo(card,
                {
                    y: 135,
                    x: isLeft ? -55 : 55,
                    rotateZ: isLeft ? -3.5 : 3.5,
                    rotateX: 10,
                    scale: 0.86,
                    opacity: 0
                },
                {
                    y: 0,
                    x: 0,
                    rotateZ: 0,
                    rotateX: 0,
                    scale: 1,
                    opacity: 1,
                    transformPerspective: 1100,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 96%',
                        end: 'top 44%',
                        scrub: 0.75
                    }
                }
            );

            if (imgBox) {
                gsap.fromTo(imgBox,
                    { clipPath: 'inset(18% 12% 18% 12%)' },
                    {
                        clipPath: 'inset(0% 0% 0% 0%)',
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: card,
                            start: 'top 95%',
                            end: 'top 45%',
                            scrub: 0.75
                        }
                    }
                );
            }

            if (img) {
                gsap.fromTo(img,
                    { yPercent: -12, scale: 1.24 },
                    {
                        yPercent: 12,
                        scale: 1.02,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: card,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 0.8
                        }
                    }
                );
            }

            if (caption) {
                gsap.fromTo(caption,
                    { y: 35, opacity: 0 },
                    {
                        y: 0,
                        opacity: 1,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: card,
                            start: 'top 80%',
                            end: 'top 40%',
                            scrub: 0.7
                        }
                    }
                );
            }

            if (window.matchMedia('(pointer: fine)').matches) {
                card.addEventListener('mousemove', function (e) {
                    const rect = card.getBoundingClientRect();
                    const nx = ((e.clientX - rect.left) / rect.width) - 0.5;
                    const ny = ((e.clientY - rect.top) / rect.height) - 0.5;
                    gsap.to(card, {
                        rotateY: nx * 8,
                        rotateX: -ny * 8,
                        transformPerspective: 1000,
                        duration: 0.4,
                        ease: 'power2.out'
                    });
                });
                card.addEventListener('mouseleave', function () {
                    gsap.to(card, {
                        rotateY: 0,
                        rotateX: 0,
                        duration: 0.6,
                        ease: 'power3.out'
                    });
                });
            }
        });

        /* ------------------------------------------------------------------
           10. SECTION 07 — FOUNDER PORTRAIT 3D REVEAL, BACKDROP & 4-GEN NODES
           ------------------------------------------------------------------ */
        const founderBackdrop = document.querySelector('.nj-founder-giant-backdrop');
        const founderSection = document.getElementById('founder');
        if (founderBackdrop && founderSection) {
            gsap.fromTo(founderBackdrop,
                { xPercent: -16, yPercent: -20 },
                {
                    xPercent: 12,
                    yPercent: 30,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: founderSection,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: 0.85
                    }
                }
            );
        }

        const founderFrame = document.querySelector('.nj-founder-portrait-frame');
        if (founderFrame) {
            const fPhoto = founderFrame.querySelector('.nj-founder-photo');
            gsap.fromTo(founderFrame,
                { y: 120, x: -55, rotateY: 16, scale: 0.86, opacity: 0 },
                {
                    y: 0,
                    x: 0,
                    rotateY: 0,
                    scale: 1,
                    opacity: 1,
                    transformPerspective: 1100,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: founderFrame,
                        start: 'top 95%',
                        end: 'top 38%',
                        scrub: 0.8
                    }
                }
            );
            if (fPhoto) {
                gsap.fromTo(fPhoto,
                    { scale: 1.24, yPercent: -8 },
                    {
                        scale: 1.0,
                        yPercent: 8,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: founderFrame,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 0.8
                        }
                    }
                );
            }
        }

        document.querySelectorAll('.nj-founder-biography p, .nj-founder-vision-quote').forEach(function (el) {
            gsap.fromTo(el,
                { y: 45, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 94%',
                        end: 'top 60%',
                        scrub: 0.7
                    }
                }
            );
        });

        document.querySelectorAll('.nj-v-timeline-item').forEach(function (item) {
            gsap.fromTo(item,
                { x: 65, y: 36, opacity: 0 },
                {
                    x: 0,
                    y: 0,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 94%',
                        end: 'top 58%',
                        scrub: 0.7
                    }
                }
            );
        });

        /* ------------------------------------------------------------------
           11. SECTION 08 — PROCESS TIMELINE CARDS & PROGRESS BEAM
           ------------------------------------------------------------------ */
        const processSection = document.getElementById('processTimeline');
        const processFill = document.getElementById('processLineFill');
        const processStages = document.querySelectorAll('.nj-process-stage');

        processStages.forEach(function (stage, idx) {
            gsap.fromTo(stage,
                { y: 90 + idx * 14, rotateX: -16, scale: 0.88, opacity: 0, transformPerspective: 900 },
                {
                    y: 0,
                    rotateX: 0,
                    scale: 1,
                    opacity: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: stage,
                        start: 'top 96%',
                        end: 'top 54%',
                        scrub: 0.75
                    }
                }
            );
        });

        if (processSection && processStages.length) {
            ScrollTrigger.create({
                trigger: processSection,
                start: 'top 75%',
                end: 'bottom 40%',
                scrub: 0.6,
                onUpdate: function (self) {
                    const pct = Math.max(0.15, Math.min(1, self.progress));
                    if (processFill) {
                        processFill.style.width = (pct * 100).toFixed(1) + '%';
                    }
                    const floatStage = self.progress * (processStages.length - 1);
                    processStages.forEach(function (stage, idx) {
                        stage.classList.toggle('is-active', idx <= Math.round(floatStage));
                    });
                }
            });

            processStages.forEach(function (stage, index) {
                stage.addEventListener('mouseenter', function () {
                    if (processFill) {
                        processFill.style.width = (((index + 1) / processStages.length) * 100).toFixed(0) + '%';
                    }
                    processStages.forEach(function (s, idx) {
                        s.classList.toggle('is-active', idx === index);
                    });
                });
            });
        }

        /* ------------------------------------------------------------------
           12. SECTION 09 — COLLABORATION MONOLITH & PACKAGE LISTS
           ------------------------------------------------------------------ */
        const collabMonolith = document.querySelector('.nj-collab-image-monolith');
        if (collabMonolith) {
            const cImg = collabMonolith.querySelector('img');
            gsap.fromTo(collabMonolith,
                { clipPath: 'inset(26% 20% 26% 20%)', y: 115, x: 55, rotateY: -16, scale: 0.84, opacity: 0 },
                {
                    clipPath: 'inset(0% 0% 0% 0%)',
                    y: 0,
                    x: 0,
                    rotateY: 0,
                    scale: 1,
                    opacity: 1,
                    transformPerspective: 1100,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: collabMonolith,
                        start: 'top 95%',
                        end: 'top 36%',
                        scrub: 0.8
                    }
                }
            );
            if (cImg) {
                gsap.fromTo(cImg,
                    { scale: 1.26, yPercent: -10 },
                    {
                        scale: 1.0,
                        yPercent: 10,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: collabMonolith,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 0.8
                        }
                    }
                );
            }
        }

        document.querySelectorAll('.nj-editorial-list li').forEach(function (li) {
            gsap.fromTo(li,
                { x: -38, y: 20, opacity: 0 },
                {
                    x: 0,
                    y: 0,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: li,
                        start: 'top 95%',
                        end: 'top 65%',
                        scrub: 0.65
                    }
                }
            );
        });

        /* ------------------------------------------------------------------
           13. SECTION 10 — OUR VISION SCROLL-EXPANDING PORTAL & QUOTE DRIFT
           ------------------------------------------------------------------ */
        const visionSection = document.getElementById('vision');
        const visionWrap = document.getElementById('visionZoomWrap');
        const visionImg = document.getElementById('visionZoomImg');
        const visionQuote = document.querySelector('.nj-vision-quote');

        if (visionSection && visionWrap && visionImg) {
            const visionTl = gsap.timeline({
                scrollTrigger: {
                    trigger: visionSection,
                    start: 'top 90%',
                    end: 'center center',
                    scrub: 0.8
                }
            });

            visionTl.fromTo(visionWrap,
                { clipPath: 'inset(24% 20% 24% 20%)' },
                { clipPath: 'inset(0% 0% 0% 0%)', ease: 'none' },
                0
            );

            visionTl.fromTo(visionImg,
                { scale: 1.35 },
                { scale: 1.0, ease: 'none' },
                0
            );

            if (visionQuote) {
                visionTl.fromTo(visionQuote,
                    { y: 75, scale: 0.88, opacity: 0 },
                    { y: 0, scale: 1, opacity: 1, ease: 'power2.out' },
                    0.05
                );
            }
        }

        /* ------------------------------------------------------------------
           14. SECTION 11 — CONTACT LIFT CARDS, BRAND CARD, FORM & FOOTER
           ------------------------------------------------------------------ */
        document.querySelectorAll('.nj-contact-lift-card').forEach(function (card, idx) {
            gsap.fromTo(card,
                { y: 75 + idx * 16, rotateX: -15, scale: 0.9, opacity: 0, transformPerspective: 900 },
                {
                    y: 0,
                    rotateX: 0,
                    scale: 1,
                    opacity: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 96%',
                        end: 'top 56%',
                        scrub: 0.7
                    }
                }
            );
        });

        document.querySelectorAll('.nj-contact-brand-card, .nj-enquiry-form-shell').forEach(function (panel, idx) {
            gsap.fromTo(panel,
                { y: 90, x: idx === 0 ? -50 : 50, rotateY: idx === 0 ? 10 : -10, scale: 0.92, opacity: 0, transformPerspective: 1100 },
                {
                    y: 0,
                    x: 0,
                    rotateY: 0,
                    scale: 1,
                    opacity: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: panel,
                        start: 'top 94%',
                        end: 'top 46%',
                        scrub: 0.75
                    }
                }
            );
        });

        const footerMonument = document.querySelector('.nj-footer-brand-lockup');
        if (footerMonument) {
            gsap.fromTo(footerMonument,
                { y: 65, scale: 0.9, opacity: 0 },
                {
                    y: 0,
                    scale: 1,
                    opacity: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: footerMonument,
                        start: 'top 96%',
                        end: 'top 64%',
                        scrub: 0.75
                    }
                }
            );
        }

        /* ------------------------------------------------------------------
           15. MULTI-LAYER CONTINUOUS PARALLAX ELEMENTS ([data-parallax-speed])
           ------------------------------------------------------------------ */
        document.querySelectorAll('[data-parallax-speed]').forEach(function (el) {
            const speed = parseFloat(el.getAttribute('data-parallax-speed') || '0.15');
            gsap.to(el, {
                yPercent: speed * 100,
                ease: 'none',
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.85
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initAnimations);
})();
