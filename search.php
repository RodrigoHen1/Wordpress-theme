<?php
/**
 * Search Results Template
 *
 * @package MillionDollarPools
 */

get_header();
$search_query = get_search_query();
?>

<div class="page-hero">
    <p class="eyebrow"><?php esc_html_e( 'Search Results', 'million-dollar-pools' ); ?></p>
    <h1 class="section-title">
        <?php printf( esc_html__( 'Results for &ldquo;%s&rdquo;', 'million-dollar-pools' ), esc_html($search_query) ); ?>
    </h1>
    <div class="divider-gold"><span class="diamond"></span></div>
</div>

<section class="section" style="padding-top:40px;">
    <div class="container">
        <?php if ( have_posts() ) : ?>
        <p style="color:var(--white-muted);margin-bottom:32px;font-size:.85rem;">
            <?php printf( esc_html__( 'Found %d result(s)', 'million-dollar-pools' ), $wp_query->found_posts ); ?>
        </p>
        <div class="pools-grid">
            <?php while ( have_posts() ) : the_post(); ?>
            <?php if ( get_post_type() === 'pool' ) : ?>
                <?php echo mdp_pool_card( get_the_ID() ); ?>
            <?php else : ?>
            <article style="background:var(--black-card);border:var(--border-gold);border-radius:var(--radius-md);padding:24px;">
                <h2 style="font-family:var(--font-display);font-size:1.2rem;margin-bottom:8px;">
                    <a href="<?php the_permalink(); ?>" style="color:var(--white);"><?php the_title(); ?></a>
                </h2>
                <p style="color:var(--white-muted);font-size:.85rem;"><?php the_excerpt(); ?></p>
            </article>
            <?php endif; ?>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
        <?php else : ?>
        <div style="text-align:center;padding:80px 0;">
            <p style="color:var(--white-muted);font-size:1.1rem;">
                <?php printf( esc_html__( 'No results found for &ldquo;%s&rdquo;.', 'million-dollar-pools' ), esc_html($search_query) ); ?>
            </p>
            <?php get_search_form(); ?>
            <a href="<?php echo esc_url(home_url('/top-100')); ?>" class="btn btn-outline" style="margin-top:24px;">
                <?php esc_html_e( 'Browse All 100 Pools', 'million-dollar-pools' ); ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
