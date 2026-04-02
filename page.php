<?php
/**
 * Default Page Template
 *
 * @package MillionDollarPools
 */

get_header();
?>

<div class="page-hero">
    <?php if ( have_posts() ) : the_post(); ?>
    <p class="eyebrow"><?php bloginfo('name'); ?></p>
    <h1 class="section-title"><?php the_title(); ?></h1>
    <div class="divider-gold"><span class="diamond"></span></div>
    <?php endif; ?>
</div>

<section class="section">
    <div class="container" style="max-width:840px;">
        <div class="pool-body-content">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
