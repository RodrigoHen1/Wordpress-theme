<?php
/**
 * Template Name: Top 100 Pools
 * Template Post Type: page
 *
 * @package MillionDollarPools
 */

get_header();

// Filters from URL params
$region_filter = sanitize_text_field( $_GET['region'] ?? '' );
$type_filter   = sanitize_text_field( $_GET['type']   ?? '' );
$search_filter = sanitize_text_field( $_GET['search'] ?? '' );
$paged         = max(1, absint( $_GET['paged'] ?? 1 ) );

// Build query
$args = [
    'post_type'      => 'pool',
    'posts_per_page' => 20,
    'paged'          => $paged,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'pool_rank',
    'order'          => 'ASC',
];

$tax_query = [];
if ( $region_filter ) {
    $tax_query[] = [ 'taxonomy' => 'pool_region', 'field' => 'slug', 'terms' => $region_filter ];
}
if ( $type_filter ) {
    $tax_query[] = [ 'taxonomy' => 'pool_type', 'field' => 'slug', 'terms' => $type_filter ];
}
if ( ! empty($tax_query) ) {
    $args['tax_query'] = array_merge( ['relation' => 'AND'], $tax_query );
}
if ( $search_filter ) {
    $args['s'] = $search_filter;
}

$pools_query = new WP_Query( $args );

// Get all regions for filter buttons
$all_regions = get_terms( [ 'taxonomy' => 'pool_region', 'hide_empty' => true ] );
$all_types   = get_terms( [ 'taxonomy' => 'pool_type',   'hide_empty' => true ] );
?>

<!-- Page Hero -->
<div class="page-hero">
    <p class="eyebrow"><?php esc_html_e( '2026 Edition', 'million-dollar-pools' ); ?></p>
    <h1 class="section-title"><?php esc_html_e( 'The World\'s Top 100 Pools', 'million-dollar-pools' ); ?></h1>
    <div class="divider-gold"><span class="diamond"></span></div>
    <p><?php esc_html_e( 'The most spectacular swimming pools on Earth — ranked by design, setting, uniqueness and experience.', 'million-dollar-pools' ); ?></p>
</div>

<section class="section" style="padding-top:40px;">
    <div class="container">

        <!-- Filters + Search Bar -->
        <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:24px;margin-bottom:32px;" id="filter-bar">

            <!-- Filter Buttons -->
            <div>
                <div class="top100-filters" style="margin-bottom:12px;" role="group" aria-label="Filter by region">
                    <button class="filter-btn <?php echo !$region_filter ? 'active' : ''; ?>"
                            data-filter="region"
                            data-value=""
                            type="button">
                        <?php esc_html_e( 'All Regions', 'million-dollar-pools' ); ?>
                    </button>
                    <?php if ( ! is_wp_error($all_regions) ) : ?>
                    <?php foreach ( $all_regions as $region ) : ?>
                    <button class="filter-btn <?php echo ($region_filter === $region->slug) ? 'active' : ''; ?>"
                            data-filter="region"
                            data-value="<?php echo esc_attr($region->slug); ?>"
                            type="button">
                        <?php echo esc_html($region->name); ?>
                    </button>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if ( ! is_wp_error($all_types) && count($all_types) > 0 ) : ?>
                <div class="top100-filters" role="group" aria-label="Filter by pool type">
                    <button class="filter-btn <?php echo !$type_filter ? 'active' : ''; ?>"
                            data-filter="type"
                            data-value=""
                            type="button">
                        <?php esc_html_e( 'All Types', 'million-dollar-pools' ); ?>
                    </button>
                    <?php foreach ( $all_types as $type ) : ?>
                    <button class="filter-btn <?php echo ($type_filter === $type->slug) ? 'active' : ''; ?>"
                            data-filter="type"
                            data-value="<?php echo esc_attr($type->slug); ?>"
                            type="button">
                        <?php echo esc_html($type->name); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Search -->
            <div class="search-bar-wrap" role="search" aria-label="Search pools">
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input
                    type="search"
                    id="pool-search"
                    placeholder="<?php esc_attr_e( 'Search pools, resorts, countries...', 'million-dollar-pools' ); ?>"
                    value="<?php echo esc_attr($search_filter); ?>"
                    aria-label="<?php esc_attr_e( 'Search pools', 'million-dollar-pools' ); ?>"
                />
            </div>

        </div>

        <!-- Results count -->
        <p style="font-size:.78rem;color:var(--white-muted);margin-bottom:24px;" aria-live="polite" id="results-count">
            <?php
            printf(
                esc_html( _n( 'Showing %d pool', 'Showing %d pools', $pools_query->found_posts, 'million-dollar-pools' ) ),
                $pools_query->found_posts
            );
            ?>
        </p>

        <!-- Pool List -->
        <div id="pools-list" role="list" aria-label="Pool list">
        <?php
        if ( $pools_query->have_posts() ) :
            while ( $pools_query->have_posts() ) :
                $pools_query->the_post();
                $pid      = get_the_ID();
                $rank     = mdp_get( 'pool_rank' );
                $score    = mdp_get( 'pool_score' );
                $country  = mdp_get( 'pool_location_country' );
                $city     = mdp_get( 'pool_location_city' );
                $resort   = mdp_get( 'pool_resort_name' );
                $aff_link = mdp_get( 'pool_affiliate_link' );
                $location = implode( ', ', array_filter([$city, $country]) );
                $thumb    = get_the_post_thumbnail_url( $pid, 'mdp-thumbnail' );
        ?>
        <a href="<?php the_permalink(); ?>" class="pool-list-item" role="listitem" aria-label="<?php echo esc_attr('#' . $rank . ' ' . get_the_title()); ?>">
            <?php if ( $rank ) : ?>
            <div class="pool-list-rank" aria-label="Rank <?php echo esc_attr($rank); ?>">#<?php echo esc_html($rank); ?></div>
            <?php endif; ?>

            <?php if ( $thumb ) : ?>
            <img class="pool-list-thumb" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" />
            <?php endif; ?>

            <div class="pool-list-info">
                <h2 class="pool-list-name"><?php the_title(); ?></h2>
                <?php if ( $location ) : ?>
                <p class="pool-list-location"><?php echo esc_html($location); ?></p>
                <?php endif; ?>
                <p class="pool-list-excerpt"><?php the_excerpt(); ?></p>
                <?php if ( $resort ) : ?>
                <p style="font-size:.72rem;color:var(--white-dim);margin-top:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px;" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <?php echo esc_html($resort); ?>
                </p>
                <?php endif; ?>
            </div>

            <div style="display:flex;flex-direction:column;align-items:center;gap:16px;flex-shrink:0;">
                <?php if ( $score ) : ?>
                <div class="pool-list-score-badge" aria-label="Score: <?php echo esc_attr($score); ?>/100">
                    <span class="score-num"><?php echo esc_html($score); ?></span>
                    <span class="score-lbl">Score</span>
                </div>
                <?php endif; ?>
                <?php if ( $aff_link ) : ?>
                <span style="font-size:.65rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:var(--gold);white-space:nowrap;"
                      onclick="event.stopPropagation();event.preventDefault();window.open('<?php echo esc_url($aff_link); ?>','_blank','noopener,noreferrer');"
                      role="button"
                      tabindex="0"
                      aria-label="Book <?php echo esc_attr(get_the_title()); ?> (opens in new tab)">
                    Book →
                </span>
                <?php endif; ?>
            </div>
        </a>
        <?php
            endwhile;
        else :
        ?>
        <div style="text-align:center;padding:80px 20px;">
            <p style="color:var(--white-muted);font-size:1.1rem;"><?php esc_html_e( 'No pools found. Try adjusting your filters.', 'million-dollar-pools' ); ?></p>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-outline" style="margin-top:24px;"><?php esc_html_e( 'Clear Filters', 'million-dollar-pools' ); ?></a>
        </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
        </div><!-- #pools-list -->

        <!-- Pagination -->
        <?php if ( $pools_query->max_num_pages > 1 ) : ?>
        <nav class="pagination" aria-label="Pagination">
            <?php
            echo paginate_links( [
                'base'      => get_pagenum_link(1) . '%_%',
                'format'    => '?paged=%#%',
                'current'   => $paged,
                'total'     => $pools_query->max_num_pages,
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
                'type'      => 'list',
                'add_args'  => array_filter([
                    'region' => $region_filter,
                    'type'   => $type_filter,
                    'search' => $search_filter,
                ]),
            ] );
            ?>
        </nav>
        <?php endif; ?>

    </div><!-- .container -->
</section>

<?php get_footer(); ?>
