<?php
/**
 * Homepage Template
 * Displays the luxury hero, features bar, and featured pools grid
 *
 * @package MillionDollarPools
 */

get_header();

// Get the featured pool (rank #1 or custom setting)
$featured_id = get_option( 'mdp_featured_pool_id', 0 );
if ( ! $featured_id ) {
    $top_query = mdp_get_pools( [ 'posts_per_page' => 1 ] );
    if ( $top_query->have_posts() ) {
        $top_query->the_post();
        $featured_id = get_the_ID();
        wp_reset_postdata();
    }
}

$hero_title    = get_option( 'mdp_hero_title',    "The World's Most Incredible Pools" );
$hero_subtitle = get_option( 'mdp_hero_subtitle', 'Discover the 2026 Top 100' );
$hero_image    = $featured_id ? get_the_post_thumbnail_url( $featured_id, 'mdp-hero' ) : '';
$featured_rank = $featured_id ? mdp_get( 'pool_rank',            $featured_id ) : '';
$featured_name = $featured_id ? get_the_title( $featured_id )                   : '';
$featured_city = $featured_id ? mdp_get( 'pool_location_city',   $featured_id ) : '';
$featured_cntry= $featured_id ? mdp_get( 'pool_location_country',$featured_id ) : '';
$featured_url  = $featured_id ? get_permalink( $featured_id )                   : home_url('/top-100');
$featured_loc  = implode( ', ', array_filter([$featured_city, $featured_cntry]) );
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="hero" aria-labelledby="hero-heading">
    <div class="hero-media">
        <?php if ( $hero_image ) : ?>
        <img
            src="<?php echo esc_url($hero_image); ?>"
            alt="<?php echo esc_attr($featured_name); ?>"
            fetchpriority="high"
        />
        <?php else : ?>
        <div style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%); width:100%; height:100%;"></div>
        <?php endif; ?>
    </div>

    <div class="hero-overlay" aria-hidden="true"></div>

    <div class="hero-content container">
        <?php if ( $featured_rank && $featured_name ) : ?>
        <div class="hero-badge reveal">
            <span class="rank-number">#<?php echo esc_html($featured_rank); ?> &mdash;</span>
            <span class="rank-name"><?php echo esc_html($featured_name); ?></span>
            <?php if ( $featured_loc ) : ?>
            <span class="rank-location">&bull; <?php echo esc_html($featured_loc); ?></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <p class="hero-eyebrow reveal reveal-delay-1">The Most Incredible Pools on Earth</p>

        <h1 class="hero-title reveal reveal-delay-2" id="hero-heading">
            <?php
            $parts = explode( ' ', $hero_title, 4 );
            if ( count($parts) >= 3 ) {
                echo esc_html( implode( ' ', array_slice($parts, 0, 2) ) );
                echo '<span>' . esc_html( implode( ' ', array_slice($parts, 2) ) ) . '</span>';
            } else {
                echo esc_html( $hero_title );
            }
            ?>
        </h1>

        <div class="hero-actions reveal reveal-delay-3">
            <a href="<?php echo esc_url(home_url('/top-100')); ?>" class="btn btn-gold btn-lg">
                <?php esc_html_e( 'View the 2026 Top 100', 'million-dollar-pools' ); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <?php if ( $featured_id ) : ?>
            <a href="<?php echo esc_url($featured_url); ?>" class="btn btn-outline">
                <?php esc_html_e( 'View #1 Pool', 'million-dollar-pools' ); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="hero-scroll" aria-hidden="true">
        <div class="scroll-line"></div>
        <span>Scroll</span>
    </div>
</section>

<!-- ============================================================
     FEATURES BAR
     ============================================================ -->
<div class="features-bar" role="complementary" aria-label="Site highlights">
    <div class="features-bar-inner">
        <div class="feature-item">
            <div class="feature-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            </div>
            <div class="feature-text">
                <p class="feature-title"><?php esc_html_e( 'Luxury Destinations', 'million-dollar-pools' ); ?></p>
                <p class="feature-desc"><?php esc_html_e( 'Explore Breathtaking Escapes', 'million-dollar-pools' ); ?></p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div class="feature-text">
                <p class="feature-title"><?php esc_html_e( 'Expertly Ranked', 'million-dollar-pools' ); ?></p>
                <p class="feature-desc"><?php esc_html_e( 'The Elite Pools Worldwide', 'million-dollar-pools' ); ?></p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div class="feature-text">
                <p class="feature-title"><?php esc_html_e( 'Ultimate Bucket List', 'million-dollar-pools' ); ?></p>
                <p class="feature-desc"><?php esc_html_e( 'A Dream for Pool Lovers', 'million-dollar-pools' ); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     DISCOVER TOP 100 GRID
     ============================================================ -->
<section class="section" aria-labelledby="discover-heading">
    <div class="container">
        <div class="section-header reveal">
            <p class="eyebrow"><?php esc_html_e( '2026 Edition', 'million-dollar-pools' ); ?></p>
            <h2 class="section-title" id="discover-heading"><?php esc_html_e( 'Discover the 2026 Top 100', 'million-dollar-pools' ); ?></h2>
            <div class="divider-gold"><span class="diamond"></span></div>
            <p class="section-subtitle" style="margin-top:12px;"><?php esc_html_e( 'The Most Spectacular Pools on Earth', 'million-dollar-pools' ); ?></p>
        </div>

        <?php
        $featured_pools = mdp_get_pools( [ 'posts_per_page' => 5 ] );
        if ( $featured_pools->have_posts() ) :
        ?>
        <div class="pools-grid featured-layout reveal">
            <?php
            $i = 0;
            while ( $featured_pools->have_posts() ) :
                $featured_pools->the_post();
                $class = ( $i === 0 ) ? 'large' : '';
                echo mdp_pool_card( get_the_ID(), $class );
                $i++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <?php else : ?>
        <p style="text-align:center;color:var(--white-muted);">
            <?php esc_html_e( 'No pools published yet. Add pools from the WordPress admin.', 'million-dollar-pools' ); ?>
        </p>
        <?php endif; ?>

        <div style="text-align:center;margin-top:48px;" class="reveal">
            <a href="<?php echo esc_url(home_url('/top-100')); ?>" class="btn btn-outline btn-lg">
                <?php esc_html_e( 'View All 100 Pools', 'million-dollar-pools' ); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     REGION CALLOUTS
     ============================================================ -->
<section class="section" style="background:var(--black-surface);border-top:var(--border-gold);border-bottom:var(--border-gold);" aria-labelledby="regions-heading">
    <div class="container">
        <div class="section-header reveal">
            <p class="eyebrow"><?php esc_html_e( 'Explore by Region', 'million-dollar-pools' ); ?></p>
            <h2 class="section-title" id="regions-heading"><?php esc_html_e( 'Around the World', 'million-dollar-pools' ); ?></h2>
            <div class="divider-gold"><span class="diamond"></span></div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;" class="reveal">
            <?php
            $regions = [
                [ 'label' => 'Asia',         'slug' => 'asia',        'icon' => '🌏' ],
                [ 'label' => 'Europe',        'slug' => 'europe',      'icon' => '🏛️' ],
                [ 'label' => 'Americas',      'slug' => 'americas',    'icon' => '🌎' ],
                [ 'label' => 'Middle East',   'slug' => 'middle-east', 'icon' => '🌅' ],
                [ 'label' => 'Oceania',       'slug' => 'oceania',     'icon' => '🌊' ],
                [ 'label' => 'Africa',        'slug' => 'africa',      'icon' => '🦁' ],
            ];
            foreach ( $regions as $region ) :
            ?>
            <a href="<?php echo esc_url(home_url('/pools?region=' . $region['slug'])); ?>"
               style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:28px 20px;background:var(--black-card);border:var(--border-gold);border-radius:var(--radius-md);text-decoration:none;transition:all var(--transition);"
               onmouseover="this.style.borderColor='var(--gold)';this.style.background='rgba(201,168,76,0.06)';"
               onmouseout="this.style.borderColor='rgba(201,168,76,0.35)';this.style.background='var(--black-card)';"
               >
                <span style="font-size:2rem;" aria-hidden="true"><?php echo $region['icon']; ?></span>
                <span style="font-family:var(--font-body);font-size:.72rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--white);"><?php echo esc_html($region['label']); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
