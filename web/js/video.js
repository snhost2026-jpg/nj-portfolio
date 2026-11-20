/**
 * NJ INTERIORS — Section 03 Cinematic Company Video Controller
 * Manages the actual supplied 2160x3840 (9:16 4K portrait) company walkthrough video
 * and synchronises the ambient background video layer.
 */
(function () {
    'use strict';

    function formatTimecode(sec) {
        if (!isFinite(sec) || sec < 0) return '00:00';
        const m = Math.floor(sec / 60);
        const s = Math.floor(sec % 60);
        return (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const mainVideo = document.getElementById('companyMainVideo');
        const ambientVideo = document.getElementById('ambientBackdropVideo');
        const videoFrame = document.getElementById('companyVideoFrame');
        const playBtn = document.getElementById('companyVideoPlayBtn');
        const playIcon = document.getElementById('companyVideoPlayIcon');
        const playText = document.getElementById('companyVideoPlayText');
        const muteBtn = document.getElementById('companyVideoMuteBtn');
        const muteText = document.getElementById('companyVideoMuteText');
        const fullscreenBtn = document.getElementById('companyVideoFullscreenBtn');
        const timecodeEl = document.getElementById('companyVideoTimecode');
        const scrubberTrack = document.getElementById('companyVideoScrubberTrack');
        const scrubberFill = document.getElementById('companyVideoScrubberFill');

        if (!mainVideo) return;

        function updatePlayUI() {
            const isPaused = mainVideo.paused;
            if (playIcon) playIcon.innerHTML = isPaused ? '&#9654;' : '&#10074;&#10074;';
            if (playText) playText.textContent = isPaused ? 'Play Film' : 'Pause Film';
        }

        function updateMuteUI() {
            const isMuted = mainVideo.muted;
            if (muteText) muteText.textContent = isMuted ? 'Unmute Audio' : 'Mute Audio';
        }

        function togglePlay() {
            if (mainVideo.paused) {
                mainVideo.play().catch(function () {});
                if (ambientVideo) ambientVideo.play().catch(function () {});
            } else {
                mainVideo.pause();
                if (ambientVideo) ambientVideo.pause();
            }
            updatePlayUI();
        }

        function toggleMute() {
            mainVideo.muted = !mainVideo.muted;
            updateMuteUI();
        }

        if (playBtn) playBtn.addEventListener('click', togglePlay);
        if (videoFrame) videoFrame.addEventListener('click', togglePlay);
        if (muteBtn) muteBtn.addEventListener('click', toggleMute);

        if (fullscreenBtn && videoFrame) {
            fullscreenBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (!document.fullscreenElement) {
                    if (mainVideo.requestFullscreen) {
                        mainVideo.requestFullscreen().catch(function () {});
                    } else if (videoFrame.requestFullscreen) {
                        videoFrame.requestFullscreen().catch(function () {});
                    }
                } else if (document.exitFullscreen) {
                    document.exitFullscreen().catch(function () {});
                }
            });
        }

        mainVideo.addEventListener('play', updatePlayUI);
        mainVideo.addEventListener('pause', updatePlayUI);

        mainVideo.addEventListener('loadedmetadata', function () {
            if (timecodeEl) {
                timecodeEl.textContent = '00:00 / ' + formatTimecode(mainVideo.duration || 31);
            }
        });

        mainVideo.addEventListener('timeupdate', function () {
            const duration = mainVideo.duration || 31;
            const current = mainVideo.currentTime || 0;
            const pct = Math.min(100, (current / duration) * 100);

            if (scrubberFill) {
                scrubberFill.style.width = pct.toFixed(2) + '%';
            }
            if (scrubberTrack) {
                scrubberTrack.setAttribute('aria-valuenow', pct.toFixed(0));
            }
            if (timecodeEl) {
                timecodeEl.textContent = formatTimecode(current) + ' / ' + formatTimecode(duration);
            }
        });

        if (scrubberTrack) {
            scrubberTrack.addEventListener('click', function (e) {
                const rect = scrubberTrack.getBoundingClientRect();
                const ratio = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                if (mainVideo.duration) {
                    mainVideo.currentTime = ratio * mainVideo.duration;
                    if (ambientVideo && ambientVideo.duration) {
                        ambientVideo.currentTime = mainVideo.currentTime;
                    }
                }
            });
        }

        // Scroll-triggered autoplay & pause when out of viewport for performance
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        mainVideo.play().catch(function () {});
                        if (ambientVideo) ambientVideo.play().catch(function () {});
                    } else {
                        mainVideo.pause();
                        if (ambientVideo) ambientVideo.pause();
                    }
                });
            }, { threshold: 0.25 });

            observer.observe(mainVideo);
        }

        updatePlayUI();
        updateMuteUI();
    });
})();
