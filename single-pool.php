<?php
/**
 * Single Pool Profile Template
 *
 * @package MillionDollarPools
 */

get_header();

if ( ! have_posts() ) {
    wp_redirect( home_url('/top-100') );
    exit;
}

the_post();
$post_id  = get_the_ID();

// Meta fields
$rank          = mdp_get( 'pool_rank' );
$score         = mdp_get( 'pool_score' );
$resort        = mdp_get( 'pool_resort_name' );
$city          = mdp_get( 'pool_location_city' );
$country       = mdp_get( 'pool_location_country' );
$architect     = mdp_get( 'pool_architect' );
$year          = mdp_get( 'pool_year_built' );
$length        = mdp_get( 'pool_pool_length' );
$depth         = mdp_get( 'pool_pool_depth' );
$elevation     = mdp_get( 'pool_elevation' );
$best_time     = mdp_get( 'pool_best_time_to_visit' );
$price         = mdp_get( 'pool_price_range' );
$aff_link      = mdp_get( 'pool_affiliate_link' );
$aff_label     = mdp_get( 'pool_affiliate_label' ) ?: __( 'Book Your Stay', 'million-dollar-pools' );
$lat           = mdp_get( 'pool_coordinates_lat' );
$lng           = mdp_get( 'pool_coordinates_lng' );

// Score breakdown
$s_design      = mdp_get( 'pool_score_design' );
$s_setting     = mdp_get( 'pool_score_setting' );
$s_unique      = mdp_get( 'pool_score_uniqueness' );
$s_experience  = mdp_get( 'pool_score_experience' );
$s_access      = mdp_get( 'pool_score_accessibility' );

$location      = implode( ', ', array_filter([$city, $country]) );
$hero_image    = get_the_post_thumbnail_url( $post_id, 'mdp-hero' );
$gallery       = get_post_gallery_images( $post_id ); // for classic gallery blocks

// Get adjacent pools for prev/next
$prev_pool = get_previous_post( false, '', 'pool' );
$next_pool = get_next_post( false, '', 'pool' );
?>

<!-- ============================================================
     POOL HERO
     ============================================================ -->
<section class="pool-hero" aria-label="<?php echo esc_attr(get_the_title()); ?>">
    <?php if ( $hero_image ) : ?>
    <img
        class="pool-hero-image"
        src="<?php echo esc_url($hero_image); ?>"
        alt="<?php echo esc_attr(get_the_title() . ' pool'); ?>"
        fetchpriority="high"
    />
    <?php endif; ?>
    <div class="pool-hero-overlay" aria-hidden="true"></div>

    <div class="pool-hero-content container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e( 'Home', 'million-dollar-pools' ); ?></a>
            <span class="sep" aria-hidden="true">›</span>
            <a href="<?php echo esc_url(home_url('/top-100')); ?>"><?php esc_html_e( 'Top 100', 'million-dollar-pools' ); ?></a>
            <span class="sep" aria-hidden="true">›</span>
            <span aria-current="page"><?php the_title(); ?></span>
        </nav>

        <?php if ( $rank ) : ?>
        <div class="pool-rank-badge">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <?php printf( esc_html__( 'Rank #%s — 2026 Edition', 'million-dollar-pools' ), esc_html($rank) ); ?>
        </div>
        <?php endif; ?>

        <h1 class="pool-profile-title"><?php the_title(); ?></h1>

        <?php if ( $location ) : ?>
        <p class="pool-profile-location">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:6px;" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <?php echo esc_html($location); ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================================
     STATS STRIP
     ============================================================ -->
<div class="pool-stats-strip" role="region" aria-label="Pool statistics">
    <div class="pool-stats-inner container" style="max-width:var(--max-width);">
        <?php if ( $score ) : ?>
        <div class="pool-stat">
            <span class="stat-value gold-shimmer"><?php echo esc_html($score); ?></span>
            <span class="stat-label"><?php esc_html_e( 'Overall Score', 'million-dollar-pools' ); ?></span>
        </div>
        <?php endif; ?>
        <?php if ( $rank ) : ?>
        <div class="pool-stat">
            <span class="stat-value">#<?php echo esc_html($rank); ?></span>
            <span class="stat-label"><?php esc_html_e( 'Global Rank', 'million-dollar-pools' ); ?></span>
        </div>
        <?php endif; ?>
        <?php if ( $year ) : ?>
        <div class="pool-stat">
            <span class="stat-value"><?php echo esc_html($year); ?></span>
            <span class="stat-label"><?php esc_html_e( 'Year Built', 'million-dollar-pools' ); ?></span>
        </div>
        <?php endif; ?>
        <?php if ( $length ) : ?>
        <div class="pool-stat">
            <span class="stat-value"><?php echo esc_html($length); ?></span>
            <span class="stat-label"><?php esc_html_e( 'Pool Length', 'million-dollar-pools' ); ?></span>
        </div>
        <?php endif; ?>
        <?php if ( $elevation ) : ?>
        <div class="pool-stat">
            <span class="stat-value"><?php echo esc_html($elevation); ?></span>
            <span class="stat-label"><?php esc_html_e( 'Elevation', 'million-dollar-pools' ); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ============================================================
     MAIN CONTENT + SIDEBAR
     ============================================================ -->
<div class="pool-content-grid" role="main">

    <!-- Main Body -->
    <article class="pool-body-content">

        <div class="pool-excerpt" style="font-family:var(--font-display);font-size:1.25rem;color:var(--white-muted);line-height:1.75;margin-bottom:40px;padding-bottom:40px;border-bottom:var(--border-gold);">
            <?php the_excerpt(); ?>
        </div>

        <?php the_content(); ?>

        <!-- Gallery from post -->
        <?php
        $image_ids = get_post_meta( $post_id, '_pool_gallery_images', true );
        if ( $image_ids ) :
            $ids = explode(',', $image_ids);
        ?>
        <h2><?php esc_html_e( 'Photo Gallery', 'million-dollar-pools' ); ?></h2>
        <div class="pool-gallery" role="list" aria-label="Pool photo gallery">
            <?php foreach ( $ids as $img_id ) :
                $img_id = trim($img_id);
                if ( ! $img_id ) continue;
                $src  = wp_get_attachment_image_url( $img_id, 'mdp-gallery' );
                $full = wp_get_attachment_image_url( $img_id, 'full' );
                $alt  = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
            ?>
            <a href="<?php echo esc_url($full); ?>" class="pool-gallery-item" role="listitem" aria-label="<?php echo esc_attr($alt ?: 'Pool photo'); ?>">
                <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy" />
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Score Breakdown -->
        <?php if ( $s_design || $s_setting || $s_unique || $s_experience || $s_access ) : ?>
        <h2><?php esc_html_e( 'Score Breakdown', 'million-dollar-pools' ); ?></h2>
        <div class="score-breakdown" role="list" aria-label="Score breakdown">
            <?php
            $score_cats = [
                'Design & Architecture' => $s_design,
                'Setting & Views'       => $s_setting,
                'Uniqueness'            => $s_unique,
                'Experience & Amenities'=> $s_experience,
                'Accessibility'         => $s_access,
            ];
            foreach ( $score_cats as $cat => $val ) :
                if ( ! $val ) continue;
            ?>
            <div class="score-row" role="listitem">
                <span class="score-cat"><?php echo esc_html($cat); ?></span>
                <div class="score-bar-wrap">
                    <div class="score-bar-fill" style="width:<?php echo esc_attr($val); ?>%;" aria-valuenow="<?php echo esc_attr($val); ?>" aria-valuemin="0" aria-valuemax="100" role="progressbar" aria-label="<?php echo esc_attr($cat . ': ' . $val . '/100'); ?>"></div>
                </div>
                <span class="score-num" aria-hidden="true"><?php echo esc_html($val); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Navigation: Prev / Next Pool -->
        <nav class="pool-navigation" style="display:flex;justify-content:space-between;gap:20px;margin-top:60px;padding-top:40px;border-top:var(--border-gold);" aria-label="Pool navigation">
            <?php if ( $prev_pool ) : ?>
            <a href="<?php echo esc_url(get_permalink($prev_pool)); ?>" style="display:flex;flex-direction:column;gap:4px;padding:20px;background:var(--black-card);border:var(--border-gold);border-radius:var(--radius-md);flex:1;transition:all var(--transition);text-decoration:none;" onmouseover="this.style.borderColor='var(--gold)';" onmouseout="this.style.borderColor='rgba(201,168,76,0.35)';">
                <span style="font-size:.65rem;letter-spacing:.2em;text-transform:uppercase;color:var(--white-muted);">&#8592; <?php esc_html_e( 'Previous', 'million-dollar-pools' ); ?></span>
                <span style="font-family:var(--font-display);font-size:1.1rem;color:var(--white);">
                    #<?php echo esc_html(get_post_meta($prev_pool->ID, 'pool_rank', true)); ?>
                    <?php echo esc_html(get_the_title($prev_pool)); ?>
                </span>
            </a>
            <?php endif; ?>
            <?php if ( $next_pool ) : ?>
            <a href="<?php echo esc_url(get_permalink($next_pool)); ?>" style="display:flex;flex-direction:column;align-items:flex-end;gap:4px;padding:20px;background:var(--black-card);border:var(--border-gold);border-radius:var(--radius-md);flex:1;text-align:right;transition:all var(--transition);text-decoration:none;" onmouseover="this.style.borderColor='var(--gold)';" onmouseout="this.style.borderColor='rgba(201,168,76,0.35)';">
                <span style="font-size:.65rem;letter-spacing:.2em;text-transform:uppercase;color:var(--white-muted);"><?php esc_html_e( 'Next', 'million-dollar-pools' ); ?> &#8594;</span>
                <span style="font-family:var(--font-display);font-size:1.1rem;color:var(--white);">
                    #<?php echo esc_html(get_post_meta($next_pool->ID, 'pool_rank', true)); ?>
                    <?php echo esc_html(get_the_title($next_pool)); ?>
                </span>
            </a>
            <?php endif; ?>
        </nav>

    </article>

    <!-- Sidebar -->
    <aside class="pool-sidebar" aria-label="Pool information">

        <!-- Affiliate Booking Box -->
        <?php if ( $aff_link ) : ?>
        <div class="booking-box">
            <p class="booking-eyebrow"><?php esc_html_e( 'Plan Your Visit', 'million-dollar-pools' ); ?></p>
            <h3 class="booking-title"><?php esc_html_e( 'Book Your Stay', 'million-dollar-pools' ); ?></h3>
            <p class="booking-desc">
                <?php
                if ( $resort ) {
                    printf( esc_html__( 'Experience %s and this legendary pool for yourself.', 'million-dollar-pools' ), '<strong>' . esc_html($resort) . '</strong>' );
                } else {
                    esc_html_e( 'Experience this legendary pool for yourself. Find availability and best rates.', 'million-dollar-pools' );
                }
                ?>
            </p>
            <a href="<?php echo esc_url($aff_link); ?>"
               class="btn btn-gold"
               target="_blank"
               rel="noopener noreferrer nofollow sponsored"
               aria-label="<?php printf( esc_attr__( 'Book your stay at %s (opens in new tab)', 'million-dollar-pools' ), esc_attr(get_the_title()) ); ?>">
                <?php echo esc_html($aff_label); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
            <p class="booking-disclaimer">
                <?php esc_html_e( 'Affiliate link — we may earn a small commission at no extra cost to you.', 'million-dollar-pools' ); ?>
            </p>
        </div>
        <?php endif; ?>

        <!-- Quick Facts -->
        <div class="sidebar-card">
            <div class="sidebar-card-header">
                <h3><?php esc_html_e( 'Quick Facts', 'million-dollar-pools' ); ?></h3>
            </div>
            <div class="sidebar-card-body">
                <?php
                $facts = [
                    __( 'Global Rank',    'million-dollar-pools' ) => $rank ? '#' . $rank : null,
                    __( 'Score',          'million-dollar-pools' ) => $score ? $score . '/100' : null,
                    __( 'Resort',         'million-dollar-pools' ) => $resort,
                    __( 'Location',       'million-dollar-pools' ) => $location,
                    __( 'Designer',       'million-dollar-pools' ) => $architect,
                    __( 'Year Built',     'million-dollar-pools' ) => $year,
                    __( 'Length',         'million-dollar-pools' ) => $length,
                    __( 'Depth',          'million-dollar-pools' ) => $depth,
                    __( 'Elevation',      'million-dollar-pools' ) => $elevation,
                    __( 'Best Time',      'million-dollar-pools' ) => $best_time,
                    __( 'Price Range',    'million-dollar-pools' ) => $price,
                ];
                foreach ( $facts as $label => $value ) :
                    if ( ! $value ) continue;
                ?>
                <div class="sidebar-info-row">
                    <span class="info-label"><?php echo esc_html($label); ?></span>
                    <span class="info-value"><?php echo esc_html($value); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Taxonomy Tags -->
        <?php
        $regions = get_the_terms( $post_id, 'pool_region' );
        $types   = get_the_terms( $post_id, 'pool_type' );
        if ( $regions || $types ) :
        ?>
        <div class="sidebar-card">
            <div class="sidebar-card-header">
                <h3><?php esc_html_e( 'Tags', 'million-dollar-pools' ); ?></h3>
            </div>
            <div class="sidebar-card-body">
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    <?php if ( $regions && ! is_wp_error($regions) ) : ?>
                    <?php foreach ( $regions as $term ) : ?>
                    <a href="<?php echo esc_url(get_term_link($term)); ?>" style="padding:6px 14px;background:transparent;border:var(--border-gold);border-radius:100px;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--gold);transition:all var(--transition);">
                        <?php echo esc_html($term->name); ?>
                    </a>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ( $types && ! is_wp_error($types) ) : ?>
                    <?php foreach ( $types as $term ) : ?>
                    <a href="<?php echo esc_url(get_term_link($term)); ?>" style="padding:6px 14px;background:transparent;border:var(--border-gold);border-radius:100px;font-size:.68rem;letter-spacing:.15em;text-transform:uppercase;color:var(--white-muted);transition:all var(--transition);">
                        <?php echo esc_html($term->name); ?>
                    </a>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Map Link -->
        <?php if ( $lat && $lng ) : ?>
        <div class="sidebar-card">
            <div class="sidebar-card-header">
                <h3><?php esc_html_e( 'Location', 'million-dollar-pools' ); ?></h3>
            </div>
            <div class="sidebar-card-body" style="padding:0;">
                <a href="https://maps.google.com/?q=<?php echo esc_attr($lat); ?>,<?php echo esc_attr($lng); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   style="display:flex;align-items:center;gap:12px;padding:20px 24px;color:var(--gold);font-size:.82rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;"
                   aria-label="<?php printf(esc_attr__('View %s on Google Maps (opens in new tab)', 'million-dollar-pools'), esc_attr(get_the_title())); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <?php esc_html_e( 'View on Google Maps', 'million-dollar-pools' ); ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:auto;" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Share -->
        <div class="sidebar-card">
            <div class="sidebar-card-header">
                <h3><?php esc_html_e( 'Share This Pool', 'million-dollar-pools' ); ?></h3>
            </div>
            <div class="sidebar-card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                    <?php
                    $share_url   = urlencode( get_permalink() );
                    $share_title = urlencode( get_the_title() );
                    $shares = [
                        'Pinterest'  => 'https://pinterest.com/pin/create/button/?url=' . $share_url . '&media=' . urlencode($hero_image) . '&description=' . $share_title,
                        'Facebook'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url,
                        'X (Twitter)'=> 'https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_title,
                        'WhatsApp'   => 'https://wa.me/?text=' . $share_title . '%20' . $share_url,
                    ];
                    foreach ( $shares as $platform => $url ) :
                    ?>
                    <a href="<?php echo esc_url($url); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       style="display:flex;align-items:center;justify-content:center;gap:8px;padding:10px;background:var(--black-elevated);border:var(--border-gold);border-radius:var(--radius-sm);font-size:.68rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--white-muted);text-decoration:none;transition:all var(--transition);"
                       aria-label="Share on <?php echo esc_attr($platform); ?> (opens in new tab)"
                       onmouseover="this.style.color='var(--gold)';this.style.borderColor='var(--gold)';"
                       onmouseout="this.style.color='var(--white-muted)';this.style.borderColor='rgba(201,168,76,0.35)';"
                       >
                        <?php echo esc_html($platform); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </aside>

</div><!-- .pool-content-grid -->

<?php get_footer(); ?>
