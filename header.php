<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e( 'Skip to content', 'million-dollar-pools' ); ?>
</a>

<header id="site-header" role="banner">
    <div class="header-inner">

        <!-- Logo -->
        <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-logo" rel="home" aria-label="<?php bloginfo('name'); ?> - Home">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="logo-main">Million Dollar Pools</span>
                <span class="logo-sub">The World's Top 100</span>
            <?php endif; ?>
        </a>

        <!-- Primary Navigation -->
        <nav id="primary-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'million-dollar-pools' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location'  => 'primary',
                'container'       => false,
                'menu_class'      => '',
                'fallback_cb'     => 'mdp_fallback_menu',
                'items_wrap'      => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
                'depth'           => 2,
            ] );
            ?>
        </nav>

        <!-- Mobile Toggle -->
        <button class="menu-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div><!-- .header-inner -->
</header><!-- #site-header -->

<main id="main-content" tabindex="-1">

<?php
/**
 * Fallback nav for when no menu is set
 */
function mdp_fallback_menu() {
    echo '<ul role="menubar">';
    echo '<li><a href="' . esc_url( home_url('/top-100') ) . '">Top 100</a></li>';
    echo '<li><a href="' . esc_url( home_url('/gallery') ) . '">Gallery</a></li>';
    echo '<li><a href="' . esc_url( home_url('/about') ) . '">About</a></li>';
    echo '<li><a href="' . esc_url( home_url('/contact') ) . '" class="nav-cta">Contact</a></li>';
    echo '</ul>';
}
