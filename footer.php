</main><!-- #main-content -->

<!-- Newsletter Section -->
<?php if ( ! is_page('contact') ) : ?>
<section class="newsletter-section">
    <div class="newsletter-inner">
        <p class="eyebrow"><?php esc_html_e( 'Join The Journey', 'million-dollar-pools' ); ?></p>
        <h2 class="section-title"><?php esc_html_e( 'Dream Pools, Delivered', 'million-dollar-pools' ); ?></h2>
        <div class="divider-gold"><span class="diamond"></span></div>
        <p style="color:var(--white-muted);font-size:.9rem;margin-top:12px;">
            <?php esc_html_e( 'Subscribe for exclusive pool rankings, travel inspiration, and luxury escape guides.', 'million-dollar-pools' ); ?>
        </p>
        <form class="newsletter-form" id="newsletter-form" novalidate>
            <?php wp_nonce_field( 'mdp_nonce', 'newsletter_nonce' ); ?>
            <input
                class="newsletter-input"
                type="email"
                name="email"
                placeholder="<?php esc_attr_e( 'Enter your email address', 'million-dollar-pools' ); ?>"
                required
                aria-label="<?php esc_attr_e( 'Email address', 'million-dollar-pools' ); ?>"
            />
            <button type="submit" class="newsletter-submit">
                <?php esc_html_e( 'Subscribe', 'million-dollar-pools' ); ?>
            </button>
        </form>
        <p id="newsletter-message" style="margin-top:12px;font-size:.82rem;color:var(--gold);display:none;"></p>
    </div>
</section>
<?php endif; ?>

<!-- Footer -->
<footer id="site-footer" role="contentinfo">
    <div class="footer-inner">
        <div class="footer-top">

            <!-- Brand column -->
            <div class="footer-brand">
                <div class="footer-logo">Million Dollar Pools</div>
                <p>
                    <?php esc_html_e( 'The definitive guide to the world\'s most extraordinary swimming pools. From rooftop infinity pools to hidden jungle oases — we rank them all.', 'million-dollar-pools' ); ?>
                </p>
                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Pinterest">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="X / Twitter">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Footer nav columns -->
            <div class="footer-col">
                <h4><?php esc_html_e( 'Explore', 'million-dollar-pools' ); ?></h4>
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer-1',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul>';
                        echo '<li><a href="' . esc_url(home_url('/top-100')) . '">2026 Top 100</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?region=asia')) . '">Asia</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?region=europe')) . '">Europe</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?region=americas')) . '">Americas</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?region=middle-east')) . '">Middle East</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?region=oceania')) . '">Oceania</a></li>';
                        echo '</ul>';
                    },
                ] );
                ?>
            </div>

            <div class="footer-col">
                <h4><?php esc_html_e( 'Categories', 'million-dollar-pools' ); ?></h4>
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer-2',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul>';
                        echo '<li><a href="' . esc_url(home_url('/pools?type=infinity')) . '">Infinity Pools</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?type=rooftop')) . '">Rooftop Pools</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?type=overwater')) . '">Overwater Pools</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?type=natural')) . '">Natural Pools</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/pools?type=underground')) . '">Underground Pools</a></li>';
                        echo '</ul>';
                    },
                ] );
                ?>
            </div>

            <div class="footer-col">
                <h4><?php esc_html_e( 'About', 'million-dollar-pools' ); ?></h4>
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer-3',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul>';
                        echo '<li><a href="' . esc_url(home_url('/about')) . '">Our Methodology</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/contact')) . '">Contact Us</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/submit-a-pool')) . '">Submit a Pool</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/advertise')) . '">Advertise</a></li>';
                        echo '</ul>';
                    },
                ] );
                ?>
            </div>

        </div><!-- .footer-top -->

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e( 'All rights reserved.', 'million-dollar-pools' ); ?></p>
            <div class="footer-links">
                <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php esc_html_e( 'Privacy Policy', 'million-dollar-pools' ); ?></a>
                <a href="<?php echo esc_url(home_url('/terms-of-service')); ?>"><?php esc_html_e( 'Terms of Service', 'million-dollar-pools' ); ?></a>
                <a href="<?php echo esc_url(home_url('/affiliate-disclosure')); ?>"><?php esc_html_e( 'Affiliate Disclosure', 'million-dollar-pools' ); ?></a>
            </div>
        </div>

        <?php $disclaimer = get_option('mdp_affiliate_disclaimer', 'This site contains affiliate links. We may earn a commission on bookings made through our links, at no additional cost to you. This helps us keep the rankings free and independent.'); ?>
        <p class="affiliate-notice"><?php echo esc_html($disclaimer); ?></p>

    </div><!-- .footer-inner -->
</footer><!-- #site-footer -->

<?php wp_footer(); ?>
</body>
</html>
