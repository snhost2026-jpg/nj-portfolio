/**
 * NJ INTERIORS — Micro-Interactions, Custom Cursor, Expertise Panels,
 * Portfolio Gallery Modal & Yii2 CSRF Enquiry Form Handler
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const isFinePointer = window.matchMedia('(pointer: fine)').matches;

        /* ------------------------------------------------------------------
           1. CUSTOM DESKTOP CURSOR & MAGNETIC BUTTONS
           ------------------------------------------------------------------ */
        const cursorDot = document.getElementById('customCursorDot');
        const cursorRing = document.getElementById('customCursorRing');
        const cursorLabel = document.getElementById('customCursorLabel');

        if (isFinePointer && cursorDot && cursorRing) {
            let mouseX = window.innerWidth / 2;
            let mouseY = window.innerHeight / 2;
            let ringX = mouseX;
            let ringY = mouseY;

            window.addEventListener('mousemove', function (e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
                cursorDot.style.transform = 'translate3d(' + mouseX + 'px, ' + mouseY + 'px, 0) translate(-50%, -50%)';
            }, { passive: true });

            function renderCursor() {
                ringX += (mouseX - ringX) * 0.16;
                ringY += (mouseY - ringY) * 0.16;
                cursorRing.style.transform = 'translate3d(' + ringX + 'px, ' + ringY + 'px, 0) translate(-50%, -50%)';
                requestAnimationFrame(renderCursor);
            }
            requestAnimationFrame(renderCursor);

            document.querySelectorAll('[data-cursor-label]').forEach(function (el) {
                el.addEventListener('mouseenter', function () {
                    const label = el.getAttribute('data-cursor-label') || '';
                    if (cursorLabel) cursorLabel.textContent = label;
                    cursorRing.classList.add('has-label');
                });
                el.addEventListener('mouseleave', function () {
                    cursorRing.classList.remove('has-label');
                    if (cursorLabel) cursorLabel.textContent = '';
                });
            });
        }

        // Magnetic buttons
        if (isFinePointer) {
            document.querySelectorAll('.nj-magnetic').forEach(function (btn) {
                const strength = parseFloat(btn.getAttribute('data-strength') || '16');
                btn.addEventListener('mousemove', function (e) {
                    const rect = btn.getBoundingClientRect();
                    const relX = e.clientX - rect.left - rect.width / 2;
                    const relY = e.clientY - rect.top - rect.height / 2;
                    btn.style.transform = 'translate3d(' + (relX / rect.width) * strength + 'px, ' + (relY / rect.height) * strength + 'px, 0)';
                });
                btn.addEventListener('mouseleave', function () {
                    btn.style.transform = 'translate3d(0, 0, 0)';
                });
            });
        }

        /* ------------------------------------------------------------------
           2. SECTION 04 — "DISCOVER OUR APPROACH" TOGGLE
           ------------------------------------------------------------------ */
        const discoverBtn = document.getElementById('discoverApproachBtn');
        const approachPanel = document.getElementById('approachExpandPanel');

        if (discoverBtn && approachPanel) {
            discoverBtn.addEventListener('click', function () {
                const isExpanded = discoverBtn.getAttribute('aria-expanded') === 'true';
                discoverBtn.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
                approachPanel.hidden = isExpanded;
            });
        }

        /* ------------------------------------------------------------------
           3. SECTION 05 — OUR EXPERTISE PANELS & CURSOR FLOATING PREVIEW
           ------------------------------------------------------------------ */
        const expertisePanels = document.querySelectorAll('.nj-expertise-panel');
        const floatingPreview = document.getElementById('expertiseCursorPreview');
        const floatingPreviewImg = document.getElementById('expertiseCursorPreviewImg');
        const projectTypeSelect = document.getElementById('contact-project-type');

        expertisePanels.forEach(function (panel) {
            const row = panel.querySelector('.nj-expertise-panel-row');
            const imgUrl = panel.getAttribute('data-preview-image');

            if (row) {
                row.addEventListener('click', function () {
                    const alreadyExpanded = panel.classList.contains('is-expanded');
                    expertisePanels.forEach(function (p) {
                        p.classList.remove('is-expanded');
                        const r = p.querySelector('.nj-expertise-panel-row');
                        if (r) r.setAttribute('aria-expanded', 'false');
                    });
                    if (!alreadyExpanded) {
                        panel.classList.add('is-expanded');
                        row.setAttribute('aria-expanded', 'true');
                    }
                });

                row.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        row.click();
                    }
                });
            }

            if (isFinePointer && floatingPreview && floatingPreviewImg && imgUrl) {
                panel.addEventListener('mouseenter', function () {
                    floatingPreviewImg.src = imgUrl;
                    floatingPreview.classList.add('is-visible');
                });

                panel.addEventListener('mousemove', function (e) {
                    floatingPreview.style.left = (e.clientX + 140) + 'px';
                    floatingPreview.style.top = (e.clientY - 20) + 'px';
                });

                panel.addEventListener('mouseleave', function () {
                    floatingPreview.classList.remove('is-visible');
                });
            }
        });

        document.querySelectorAll('[data-prefill-project]').forEach(function (link) {
            link.addEventListener('click', function () {
                if (!projectTypeSelect) return;
                const val = (link.getAttribute('data-prefill-project') || '').toLowerCase();
                for (let i = 0; i < projectTypeSelect.options.length; i++) {
                    const optText = projectTypeSelect.options[i].text.toLowerCase();
                    if (optText.includes(val.split(' ')[0])) {
                        projectTypeSelect.selectedIndex = i;
                        break;
                    }
                }
            });
        });

        /* ------------------------------------------------------------------
           4. SECTION 06 — SELECTED PROJECTS FILTER & FULLSCREEN MODAL
           ------------------------------------------------------------------ */
        const filterTabs = document.querySelectorAll('.nj-filter-tab');
        const projectCards = document.querySelectorAll('.nj-project-card');
        const modal = document.getElementById('projectFullscreenModal');
        const modalImg = document.getElementById('modalProjectImage');
        const modalCat = document.getElementById('modalProjectCategory');
        const modalTitle = document.getElementById('modalProjectTitle');
        const modalLocation = document.getElementById('modalProjectLocation');
        const modalYear = document.getElementById('modalProjectYear');
        const modalDesc = document.getElementById('modalProjectDescription');
        const modalNote = document.getElementById('modalProjectNote');

        filterTabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                filterTabs.forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');
                const selectedCategory = tab.getAttribute('data-filter') || 'all';

                projectCards.forEach(function (card) {
                    const cardCat = card.getAttribute('data-project-category');
                    const visible = (selectedCategory === 'all' || cardCat === selectedCategory);
                    card.style.display = visible ? '' : 'none';
                });
            });
        });

        function openProjectModal(triggerEl) {
            if (!modal) return;
            if (modalImg) {
                modalImg.src = triggerEl.getAttribute('data-project-img') || '';
                modalImg.alt = triggerEl.getAttribute('data-project-title') || '';
            }
            if (modalCat) modalCat.textContent = triggerEl.getAttribute('data-project-category') || '';
            if (modalTitle) modalTitle.textContent = triggerEl.getAttribute('data-project-title') || '';
            if (modalLocation) modalLocation.textContent = triggerEl.getAttribute('data-project-location') || 'Bhubaneswar, Odisha';
            if (modalYear) modalYear.textContent = triggerEl.getAttribute('data-project-year') || 'Portfolio 2026';
            if (modalDesc) modalDesc.textContent = triggerEl.getAttribute('data-project-desc') || '';
            if (modalNote) modalNote.textContent = triggerEl.getAttribute('data-project-note') || '';

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeProjectModal() {
            if (!modal) return;
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        }

        document.querySelectorAll('.nj-project-card, .nj-h-slide, .nj-coverflow-card .nj-coverflow-inspect-btn').forEach(function (item) {
            item.addEventListener('click', function (e) {
                const sourceEl = item.closest('[data-project-title]') || item;
                openProjectModal(sourceEl);
            });
            item.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const sourceEl = item.closest('[data-project-title]') || item;
                    openProjectModal(sourceEl);
                }
            });
        });

        document.querySelectorAll('[data-close-project-modal]').forEach(function (btn) {
            btn.addEventListener('click', closeProjectModal);
        });

        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeProjectModal();
            }
        });

        /* ------------------------------------------------------------------
           5. SECTION 11 — YII2 CONTACT FORM VALIDATION, AJAX & WHATSAPP
           ------------------------------------------------------------------ */
        const enquiryForm = document.getElementById('njEnquiryForm');
        const statusBox = document.getElementById('enquiryStatusBox');
        const submitBtn = document.getElementById('enquirySubmitBtn');
        const submitText = document.getElementById('enquirySubmitText');
        const whatsappSendBtn = document.getElementById('formWhatsappSendBtn');

        function clearErrors() {
            document.querySelectorAll('.nj-field-error').forEach(function (el) {
                el.textContent = '';
            });
        }

        function setFieldError(field, msg) {
            const errEl = document.querySelector('.nj-field-error[data-error-for="' + field + '"]');
            if (errEl) errEl.textContent = msg;
        }

        function showStatus(msg, isError) {
            if (!statusBox) return;
            statusBox.textContent = msg;
            statusBox.classList.remove('d-none', 'nj-alert-error', 'nj-alert-success');
            statusBox.classList.add(isError ? 'nj-alert-error' : 'nj-alert-success');
        }

        function collectFormValues() {
            return {
                name: (document.getElementById('contact-name')?.value || '').trim(),
                phone: (document.getElementById('contact-phone')?.value || '').trim(),
                email: (document.getElementById('contact-email')?.value || '').trim(),
                projectType: (document.getElementById('contact-project-type')?.value || '').trim(),
                message: (document.getElementById('contact-message')?.value || '').trim()
            };
        }

        function validateClientSide(values) {
            clearErrors();
            let valid = true;

            if (values.name.length < 2) {
                setFieldError('name', 'Please enter your full name.');
                valid = false;
            }
            if (!/^[0-9+\-\s()]{7,22}$/.test(values.phone)) {
                setFieldError('phone', 'Please enter a valid phone or WhatsApp number.');
                valid = false;
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(values.email)) {
                setFieldError('email', 'Please enter a valid email address.');
                valid = false;
            }
            if (!values.projectType) {
                setFieldError('projectType', 'Please select a project category.');
                valid = false;
            }
            if (values.message.length < 10) {
                setFieldError('message', 'Please enter at least 10 characters describing your project.');
                valid = false;
            }
            return valid;
        }

        if (enquiryForm) {
            enquiryForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const values = collectFormValues();
                if (!validateClientSide(values)) {
                    showStatus('Please complete all required fields highlighted below.', true);
                    return;
                }

                if (submitBtn) submitBtn.disabled = true;
                if (submitText) submitText.textContent = 'Submitting...';

                const formData = new FormData(enquiryForm);

                fetch(enquiryForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (data.success) {
                            showStatus(data.message, false);
                            enquiryForm.reset();
                        } else {
                            if (data.errors) {
                                Object.keys(data.errors).forEach(function (key) {
                                    const msgs = data.errors[key];
                                    if (Array.isArray(msgs) && msgs.length) {
                                        setFieldError(key, msgs[0]);
                                    }
                                });
                            }
                            showStatus(data.message || 'Please review the form fields and try again.', true);
                        }
                    })
                    .catch(function () {
                        // Fallback to standard POST submission if fetch fails
                        enquiryForm.submit();
                    })
                    .finally(function () {
                        if (submitBtn) submitBtn.disabled = false;
                        if (submitText) submitText.textContent = 'Submit Enquiry';
                    });
            });
        }

        if (whatsappSendBtn) {
            whatsappSendBtn.addEventListener('click', function () {
                const values = collectFormValues();
                if (!values.name || !values.phone) {
                    showStatus('Please enter your Full Name and Phone Number before launching WhatsApp.', true);
                    return;
                }
                const waText = [
                    'Hello *NJ INTERIORS* (Mr. Nitesh Kumar Jangda),',
                    '',
                    'I would like to enquire about an interior project:',
                    '• *Name:* ' + values.name,
                    '• *Phone:* ' + values.phone,
                    values.email ? '• *Email:* ' + values.email : null,
                    values.projectType ? '• *Project Type:* ' + values.projectType : null,
                    values.message ? '• *Brief:* ' + values.message : null
                ].filter(Boolean).join('\n');

                window.open('https://wa.me/919583205010?text=' + encodeURIComponent(waText), '_blank', 'noopener');
            });
        }
    });
})();
