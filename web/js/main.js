/**
 * NJ INTERIORS — Main Application Bootstrapper
 * Responsibilities:
 * - Preloader sequence & page reveal
 * - Lenis smooth scrolling + GSAP ScrollTrigger synchronisation
 * - Floating header transition & active section scroll-spy
 * - Three.js 3D Architectural Sculpture / Rotating Wireframe Pavilion inside the Hero Monolith
 */
(function () {
    'use strict';

    window.NJApp = window.NJApp || {};
    // Note: Windows "MinAnimate = 0" sets OS prefers-reduced-motion to true even when
    // users want full web animations. Only disable motion if explicitly requested via URL (?reducedMotion=1).
    const prefersReducedMotion = window.location.search.indexOf('reducedMotion=1') !== -1;
    window.NJApp.prefersReducedMotion = prefersReducedMotion;

    document.documentElement.classList.remove('no-js');
    document.documentElement.classList.add('js');

    /* ----------------------------------------------------------------------
       1. PRELOADER SEQUENCE
       ---------------------------------------------------------------------- */
    function initPreloader(onComplete) {
        const preloader = document.getElementById('sitePreloader');
        const fill = document.getElementById('preloaderFill');

        if (!preloader || prefersReducedMotion) {
            if (preloader) preloader.classList.add('is-hidden');
            document.body.classList.remove('is-loading');
            if (typeof onComplete === 'function') onComplete();
            return;
        }

        let progress = 0;
        const interval = setInterval(function () {
            progress += Math.floor(Math.random() * 34) + 24;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                if (fill) fill.style.width = '100%';
                setTimeout(function () {
                    preloader.classList.add('is-hidden');
                    document.body.classList.remove('is-loading');
                    if (typeof onComplete === 'function') onComplete();
                }, 220);
            } else if (fill) {
                fill.style.width = progress + '%';
            }
        }, 65);
    }

    /* ----------------------------------------------------------------------
       2. LENIS SMOOTH SCROLLING + GSAP SCROLLTRIGGER SYNC
       ---------------------------------------------------------------------- */
    function initSmoothScroll() {
        if (prefersReducedMotion || typeof window.Lenis === 'undefined') {
            return null;
        }

        const lenis = new window.Lenis({
            duration: 1.2,
            easing: function (t) {
                return Math.min(1, 1.001 - Math.pow(2, -10 * t));
            },
            smoothWheel: true,
            wheelMultiplier: 0.95,
            touchMultiplier: 1.5
        });

        window.NJApp.lenis = lenis;

        if (typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined') {
            window.gsap.registerPlugin(window.ScrollTrigger);
            lenis.on('scroll', window.ScrollTrigger.update);
            window.gsap.ticker.add(function (time) {
                lenis.raf(time * 1000);
            });
            window.gsap.ticker.lagSmoothing(0);
        } else {
            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);
        }

        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                const targetId = anchor.getAttribute('href');
                if (!targetId || targetId === '#') return;
                const targetEl = document.querySelector(targetId);
                if (targetEl) {
                    e.preventDefault();
                    lenis.scrollTo(targetEl, { offset: -72, duration: 1.25 });
                }
            });
        });

        return lenis;
    }

    /* ----------------------------------------------------------------------
       3. HEADER TRANSFORM, MOBILE DRAWER & SCROLL PROGRESS
       ---------------------------------------------------------------------- */
    function initNavigation() {
        const header = document.getElementById('siteHeader');
        const progressBar = document.getElementById('scrollProgressBar');
        const navItems = document.querySelectorAll('.nj-nav-item');
        const sections = document.querySelectorAll('section[id]');
        const burgerBtn = document.getElementById('mobileMenuBtn');
        const mobileDrawer = document.getElementById('mobileDrawer');

        if (burgerBtn && mobileDrawer) {
            burgerBtn.addEventListener('click', function () {
                const isOpen = mobileDrawer.classList.toggle('is-open');
                burgerBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                mobileDrawer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
            });

            mobileDrawer.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    mobileDrawer.classList.remove('is-open');
                    burgerBtn.setAttribute('aria-expanded', 'false');
                    mobileDrawer.setAttribute('aria-hidden', 'true');
                });
            });
        }

        function updateOnScroll() {
            const scrollY = window.scrollY || window.pageYOffset;
            const maxScroll = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);

            if (header) {
                header.classList.toggle('is-scrolled', scrollY > 60);
            }

            if (progressBar) {
                progressBar.style.width = Math.min(100, (scrollY / maxScroll) * 100).toFixed(2) + '%';
            }

            let activeId = '';
            sections.forEach(function (sec) {
                const top = sec.offsetTop - 180;
                if (scrollY >= top) {
                    activeId = sec.getAttribute('id') || '';
                }
            });

            navItems.forEach(function (item) {
                const target = item.getAttribute('data-nav-target');
                item.classList.toggle('is-active', target === activeId);
            });
        }

        window.addEventListener('scroll', updateOnScroll, { passive: true });
        updateOnScroll();
    }

    /* ----------------------------------------------------------------------
       4. THREE.JS 3D ARCHITECTURAL PAVILION & SPATIAL WIREFRAME OBJECT
       ---------------------------------------------------------------------- */
    function initHeroThreeScene() {
        const canvas = document.getElementById('heroThreeCanvas');
        const card = document.getElementById('heroMonolithCard');
        if (!canvas || !card || prefersReducedMotion || typeof window.THREE === 'undefined') {
            return;
        }

        try {
            const THREE = window.THREE;
            const rect = card.getBoundingClientRect();
            const width = rect.width || 640;
            const height = rect.height || 384;

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(38, width / height, 0.1, 100);
            camera.position.set(0, 0.3, 6.8);

            const renderer = new THREE.WebGLRenderer({
                canvas: canvas,
                alpha: true,
                antialias: true,
                powerPreference: 'high-performance'
            });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            const pavilionGroup = new THREE.Group();
            scene.add(pavilionGroup);

            const goldMat = new THREE.LineBasicMaterial({
                color: 0xE2C799,
                transparent: true,
                opacity: 0.78
            });

            const warmMat = new THREE.LineBasicMaterial({
                color: 0xC59B57,
                transparent: true,
                opacity: 0.48
            });

            // Outer Architectural Pavilion Frame
            const outerFrame = new THREE.LineSegments(
                new THREE.EdgesGeometry(new THREE.BoxGeometry(3.4, 2.2, 1.8)),
                goldMat
            );
            pavilionGroup.add(outerFrame);

            // Inner Cantilevered Mezzanine Volume
            const innerVolume = new THREE.LineSegments(
                new THREE.EdgesGeometry(new THREE.BoxGeometry(2.2, 1.5, 1.2)),
                warmMat
            );
            innerVolume.position.set(0.22, -0.18, 0.2);
            pavilionGroup.add(innerVolume);

            // Vertical Architectural Louvers (Fluted Joinery Motif)
            for (let i = -4; i <= 4; i++) {
                const louverGeo = new THREE.EdgesGeometry(new THREE.BoxGeometry(0.06, 1.5, 0.35));
                const louver = new THREE.LineSegments(louverGeo, warmMat);
                louver.position.set(i * 0.24, -0.18, 0.65);
                pavilionGroup.add(louver);
            }

            // Floating Spatial Ring
            const ringGeo = new THREE.RingGeometry(1.65, 1.69, 64);
            const ringMat = new THREE.MeshBasicMaterial({
                color: 0xC59B57,
                side: THREE.DoubleSide,
                transparent: true,
                opacity: 0.42
            });
            const ringMesh = new THREE.Mesh(ringGeo, ringMat);
            ringMesh.rotation.x = Math.PI / 2.2;
            pavilionGroup.add(ringMesh);

            pavilionGroup.rotation.y = -0.38;
            pavilionGroup.rotation.x = 0.14;

            let targetRotX = 0.14;
            let targetRotY = -0.38;

            window.addEventListener('mousemove', function (e) {
                const nx = (e.clientX / window.innerWidth) * 2 - 1;
                const ny = -(e.clientY / window.innerHeight) * 2 + 1;
                targetRotY = -0.38 + nx * 0.6;
                targetRotX = 0.14 + ny * 0.32;
            }, { passive: true });

            window.addEventListener('resize', function () {
                const r = card.getBoundingClientRect();
                if (r.width > 0 && r.height > 0) {
                    camera.aspect = r.width / r.height;
                    camera.updateProjectionMatrix();
                    renderer.setSize(r.width, r.height);
                }
            });

            function animate() {
                requestAnimationFrame(animate);
                pavilionGroup.rotation.y += (targetRotY - pavilionGroup.rotation.y) * 0.06 + 0.003;
                pavilionGroup.rotation.x += (targetRotX - pavilionGroup.rotation.x) * 0.06;
                ringMesh.rotation.z += 0.005;
                renderer.render(scene, camera);
            }
            animate();
        } catch (err) {
            // Graceful fallback
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initSmoothScroll();
        initNavigation();
        initHeroThreeScene();
        initPreloader(function () {
            document.dispatchEvent(new CustomEvent('nj:preloaderComplete'));
        });
    });
})();
