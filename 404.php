<?php
/**
 * 404 Template
 *
 * @package MillionDollarPools
 */

get_header();
?>

<section style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:var(--gutter);">
    <div>
        <p class="eyebrow" style="margin-bottom:16px;">404 Error</p>
        <h1 class="display-title" style="font-size:clamp(4rem,12vw,10rem);line-height:1;margin-bottom:24px;">404</h1>
        <div class="divider-gold"><span class="diamond"></span></div>
        <h2 style="font-family:var(--font-display);font-size:1.8rem;color:var(--white);margin:24px 0 12px;">
            <?php esc_html_e( 'This Pool Is Off the Map', 'million-dollar-pools' ); ?>
        </h2>
        <p style="color:var(--white-muted);max-width:400px;margin:0 auto 32px;">
            <?php esc_html_e( 'The page you\'re looking for doesn\'t exist. Perhaps it was ranked out of the Top 100.', 'million-dollar-pools' ); ?>
        </p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-gold">
                <?php esc_html_e( 'Back to Homepage', 'million-dollar-pools' ); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/top-100')); ?>" class="btn btn-outline">
                <?php esc_html_e( 'View Top 100', 'million-dollar-pools' ); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
