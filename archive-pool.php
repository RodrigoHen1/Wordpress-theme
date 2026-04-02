<?php
/**
 * Pool Archive Template (Gallery View)
 *
 * @package MillionDollarPools
 */

get_header();

$paged         = max(1, get_query_var('paged'));
$region_filter = sanitize_text_field( $_GET['region'] ?? '' );
$type_filter   = sanitize_text_field( $_GET['type']   ?? '' );

// Override main query if filtered
if ( $region_filter || $type_filter ) {
    $args = [
        'post_type'      => 'pool',
        'posts_per_page' => 12,
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
        $args['tax_query'] = array_merge(['relation' => 'AND'], $tax_query);
    }
    $pool_query = new WP_Query( $args );
} else {
    global $wp_query;
    $pool_query = $wp_query;
}
?>

<div class="page-hero">
    <p class="eyebrow"><?php esc_html_e( 'Gallery', 'million-dollar-pools' ); ?></p>
    <h1 class="section-title">
        <?php
        if ( $region_filter ) {
            printf( esc_html__( 'Pools in %s', 'million-dollar-pools' ), ucwords(str_replace('-', ' ', $region_filter)) );
        } elseif ( $type_filter ) {
            printf( esc_html__( '%s Pools', 'million-dollar-pools' ), ucwords(str_replace('-', ' ', $type_filter)) );
        } else {
            esc_html_e( 'Pool Gallery', 'million-dollar-pools' );
        }
        ?>
    </h1>
    <div class="divider-gold"><span class="diamond"></span></div>
    <p><?php esc_html_e( 'Browse the world\'s most breathtaking pools', 'million-dollar-pools' ); ?></p>
</div>

<section class="section" style="padding-top:40px;">
    <div class="container">
        <?php if ( $pool_query->have_posts() ) : ?>
        <div class="pools-grid">
            <?php while ( $pool_query->have_posts() ) : $pool_query->the_post(); ?>
            <?php echo mdp_pool_card( get_the_ID() ); ?>
            <?php endwhile; ?>
        </div>

        <?php if ( $pool_query->max_num_pages > 1 ) : ?>
        <nav class="pagination" aria-label="Pagination">
            <?php
            echo paginate_links([
                'total'     => $pool_query->max_num_pages,
                'current'   => $paged,
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
                'type'      => 'list',
            ]);
            ?>
        </nav>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
        <?php else : ?>
        <div style="text-align:center;padding:80px 0;">
            <p style="color:var(--white-muted);"><?php esc_html_e( 'No pools found.', 'million-dollar-pools' ); ?></p>
            <a href="<?php echo esc_url(home_url('/top-100')); ?>" class="btn btn-outline" style="margin-top:24px;">
                <?php esc_html_e( 'View Top 100', 'million-dollar-pools' ); ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
