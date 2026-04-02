/**
 * Million Dollar Pools — Main JavaScript
 * @version 1.0.0
 */

(function () {
    'use strict';

    /* ============================================================
       HEADER: Scroll behaviour
       ============================================================ */
    const header = document.getElementById('site-header');
    if (header) {
        const toggleScrolled = () => {
            header.classList.toggle('scrolled', window.scrollY > 60);
        };
        window.addEventListener('scroll', toggleScrolled, { passive: true });
        toggleScrolled();
    }

    /* ============================================================
       MOBILE MENU TOGGLE
       ============================================================ */
    const menuToggle = document.querySelector('.menu-toggle');
    const primaryNav = document.getElementById('primary-nav');

    if (menuToggle && primaryNav) {
        menuToggle.addEventListener('click', () => {
            const isOpen = primaryNav.classList.toggle('open');
            menuToggle.setAttribute('aria-expanded', isOpen.toString());
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && primaryNav.classList.contains('open')) {
                primaryNav.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
                menuToggle.focus();
            }
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (primaryNav.classList.contains('open') &&
                !primaryNav.contains(e.target) &&
                !menuToggle.contains(e.target)) {
                primaryNav.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });

        // Close nav links on click
        primaryNav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                primaryNav.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });
    }

    /* ============================================================
       SCROLL REVEAL
       ============================================================ */
    const revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length) {
        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
        );

        revealElements.forEach((el) => revealObserver.observe(el));
    }

    /* ============================================================
       SCORE BARS ANIMATION
       ============================================================ */
    const scoreBars = document.querySelectorAll('.score-bar-fill');
    if (scoreBars.length) {
        const barObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const bar = entry.target;
                        const width = bar.style.width;
                        bar.style.width = '0';
                        // Trigger reflow
                        bar.offsetWidth;
                        bar.style.width = width;
                        barObserver.unobserve(bar);
                    }
                });
            },
            { threshold: 0.5 }
        );
        scoreBars.forEach((bar) => barObserver.observe(bar));
    }

    /* ============================================================
       NEWSLETTER FORM — AJAX
       ============================================================ */
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterMsg  = document.getElementById('newsletter-message');

    if (newsletterForm && typeof MDP !== 'undefined') {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const emailInput = newsletterForm.querySelector('input[type="email"]');
            const submitBtn  = newsletterForm.querySelector('.newsletter-submit');
            const email      = emailInput ? emailInput.value.trim() : '';

            if (!email) return;

            submitBtn.textContent = 'Subscribing…';
            submitBtn.disabled    = true;

            try {
                const formData = new FormData();
                formData.append('action', 'mdp_newsletter');
                formData.append('nonce',  MDP.nonce);
                formData.append('email',  email);

                const response = await fetch(MDP.ajaxurl, {
                    method: 'POST',
                    body:   formData,
                });
                const data = await response.json();

                if (newsletterMsg) {
                    newsletterMsg.textContent = data.data.message;
                    newsletterMsg.style.display = 'block';
                    newsletterMsg.style.color = data.success ? 'var(--gold)' : '#e05';
                }

                if (data.success) {
                    emailInput.value = '';
                    submitBtn.textContent = 'Subscribed ✓';
                } else {
                    submitBtn.textContent = 'Subscribe';
                    submitBtn.disabled    = false;
                }
            } catch (err) {
                console.error('Newsletter signup error:', err);
                submitBtn.textContent = 'Subscribe';
                submitBtn.disabled    = false;
            }
        });
    }

    /* ============================================================
       TOP 100 PAGE — LIVE FILTER + SEARCH
       ============================================================ */
    const filterBtns  = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('pool-search');
    const poolsList   = document.getElementById('pools-list');
    const resultsCount= document.getElementById('results-count');

    let currentFilters = {
        region: new URLSearchParams(window.location.search).get('region') || '',
        type:   new URLSearchParams(window.location.search).get('type')   || '',
        search: new URLSearchParams(window.location.search).get('search') || '',
        paged:  1,
    };

    // Debounce utility
    const debounce = (fn, delay) => {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => fn(...args), delay);
        };
    };

    // Fetch filtered pools via AJAX
    const fetchPools = async () => {
        if (!poolsList || typeof MDP === 'undefined') return;

        poolsList.style.opacity = '0.4';
        poolsList.style.pointerEvents = 'none';

        try {
            const formData = new FormData();
            formData.append('action', 'mdp_filter_pools');
            formData.append('nonce',  MDP.nonce);
            Object.entries(currentFilters).forEach(([k, v]) => formData.append(k, v));

            const response = await fetch(MDP.ajaxurl, { method: 'POST', body: formData });
            const data     = await response.json();

            if (data.success) {
                poolsList.innerHTML = data.data.html;
                if (resultsCount) {
                    resultsCount.textContent = `Showing ${data.data.total} pool${data.data.total !== 1 ? 's' : ''}`;
                }
                // Re-init scroll reveals in loaded content
                poolsList.querySelectorAll('.reveal').forEach((el) => el.classList.add('revealed'));
            }
        } catch (err) {
            console.error('Filter pools error:', err);
        } finally {
            poolsList.style.opacity      = '1';
            poolsList.style.pointerEvents= '';
        }
    };

    // Handle region / type filter buttons
    filterBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const filterType = btn.dataset.filter;
            const value      = btn.dataset.value;

            // Update active state for this group
            document.querySelectorAll(`.filter-btn[data-filter="${filterType}"]`).forEach((b) => {
                b.classList.toggle('active', b === btn);
            });

            currentFilters[filterType] = value;
            currentFilters.paged = 1;
            fetchPools();
        });
    });

    // Handle search input (debounced)
    if (searchInput) {
        searchInput.addEventListener(
            'input',
            debounce(() => {
                currentFilters.search = searchInput.value.trim();
                currentFilters.paged  = 1;
                fetchPools();
            }, 400)
        );
    }

    /* ============================================================
       POOL GALLERY — Lightbox (vanilla, no dependency)
       ============================================================ */
    const galleryLinks = document.querySelectorAll('.pool-gallery-item');

    if (galleryLinks.length) {
        // Build lightbox DOM once
        const lightbox = document.createElement('div');
        lightbox.id    = 'mdp-lightbox';
        lightbox.setAttribute('role', 'dialog');
        lightbox.setAttribute('aria-modal', 'true');
        lightbox.setAttribute('aria-label', 'Image lightbox');
        lightbox.innerHTML = `
            <div class="lb-backdrop"></div>
            <div class="lb-content">
                <button class="lb-prev" aria-label="Previous image">&#8592;</button>
                <img class="lb-img" src="" alt="" />
                <button class="lb-next" aria-label="Next image">&#8594;</button>
                <button class="lb-close" aria-label="Close lightbox">&times;</button>
                <p class="lb-caption"></p>
            </div>
        `;

        // Inline styles for lightbox
        const style = document.createElement('style');
        style.textContent = `
            #mdp-lightbox{position:fixed;inset:0;z-index:9999;display:none;align-items:center;justify-content:center;}
            #mdp-lightbox.open{display:flex;}
            .lb-backdrop{position:absolute;inset:0;background:rgba(0,0,0,.95);}
            .lb-content{position:relative;max-width:90vw;max-height:90vh;display:flex;align-items:center;gap:16px;}
            .lb-img{max-width:80vw;max-height:85vh;object-fit:contain;border:1px solid rgba(201,168,76,.3);display:block;}
            .lb-close{position:fixed;top:20px;right:24px;background:none;border:none;color:var(--gold);font-size:2rem;cursor:pointer;line-height:1;z-index:2;}
            .lb-prev,.lb-next{background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.4);color:var(--gold);font-size:1.5rem;width:44px;height:44px;border-radius:50%;cursor:pointer;flex-shrink:0;transition:background .2s;}
            .lb-prev:hover,.lb-next:hover{background:rgba(201,168,76,.35);}
            .lb-caption{position:absolute;bottom:-28px;left:0;right:0;text-align:center;font-size:.72rem;letter-spacing:.15em;color:var(--white-muted);}
        `;
        document.head.appendChild(style);
        document.body.appendChild(lightbox);

        const lbImg     = lightbox.querySelector('.lb-img');
        const lbCaption = lightbox.querySelector('.lb-caption');
        const lbPrev    = lightbox.querySelector('.lb-prev');
        const lbNext    = lightbox.querySelector('.lb-next');
        const lbClose   = lightbox.querySelector('.lb-close');
        const lbBackdrop= lightbox.querySelector('.lb-backdrop');

        let currentIndex = 0;
        const images     = Array.from(galleryLinks);

        const openLightbox = (index) => {
            currentIndex = index;
            const link   = images[currentIndex];
            lbImg.src    = link.href;
            lbImg.alt    = link.querySelector('img')?.alt || '';
            lbCaption.textContent = lbImg.alt;
            lightbox.classList.add('open');
            document.body.style.overflow = 'hidden';
            lbClose.focus();
        };

        const closeLightbox = () => {
            lightbox.classList.remove('open');
            document.body.style.overflow = '';
            images[currentIndex].focus();
        };

        const goPrev = () => openLightbox((currentIndex - 1 + images.length) % images.length);
        const goNext = () => openLightbox((currentIndex + 1) % images.length);

        images.forEach((link, i) => {
            link.addEventListener('click', (e) => { e.preventDefault(); openLightbox(i); });
        });

        lbClose.addEventListener('click',   closeLightbox);
        lbBackdrop.addEventListener('click',closeLightbox);
        lbPrev.addEventListener('click',    goPrev);
        lbNext.addEventListener('click',    goNext);

        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('open')) return;
            if (e.key === 'Escape')     closeLightbox();
            if (e.key === 'ArrowLeft')  goPrev();
            if (e.key === 'ArrowRight') goNext();
        });
    }

    /* ============================================================
       ACTIVE NAV LINK HIGHLIGHT
       ============================================================ */
    const currentPath = window.location.pathname;
    document.querySelectorAll('#primary-nav a').forEach((link) => {
        if (link.pathname === currentPath || (link.pathname !== '/' && currentPath.startsWith(link.pathname))) {
            link.classList.add('active');
        }
    });

    /* ============================================================
       AFFILIATE LINK TRACKING (optional console log for analytics)
       ============================================================ */
    document.querySelectorAll('a[rel*="sponsored"]').forEach((link) => {
        link.addEventListener('click', () => {
            // Extend this with your analytics (GA4, Plausible, etc.)
            if (typeof gtag !== 'undefined') {
                gtag('event', 'affiliate_click', {
                    event_category: 'Affiliate',
                    event_label:    link.href,
                    page_title:     document.title,
                });
            }
        });
    });

})();
