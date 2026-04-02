<?php
/**
 * Customizer Settings
 *
 * @package MillionDollarPools
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function mdp_customizer_register( $wp_customize ) {

    /* ── Section: Hero ── */
    $wp_customize->add_section( 'mdp_hero', [
        'title'    => __( 'Hero Section', 'million-dollar-pools' ),
        'priority' => 30,
    ] );

    $wp_customize->add_setting( 'mdp_hero_title', [
        'default'           => "The World's Most Incredible Pools",
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'mdp_hero_title', [
        'label'   => __( 'Hero Headline', 'million-dollar-pools' ),
        'section' => 'mdp_hero',
        'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'mdp_hero_subtitle', [
        'default'           => 'Discover the 2026 Top 100',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'mdp_hero_subtitle', [
        'label'   => __( 'Hero Subheading', 'million-dollar-pools' ),
        'section' => 'mdp_hero',
        'type'    => 'text',
    ] );

    /* ── Section: Colors ── */
    $wp_customize->add_section( 'mdp_colors', [
        'title'    => __( 'Brand Colors', 'million-dollar-pools' ),
        'priority' => 35,
    ] );

    $wp_customize->add_setting( 'mdp_gold_color', [
        'default'           => '#C9A84C',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mdp_gold_color', [
        'label'   => __( 'Gold Accent Color', 'million-dollar-pools' ),
        'section' => 'mdp_colors',
    ] ) );

    /* ── Section: Footer ── */
    $wp_customize->add_section( 'mdp_footer', [
        'title'    => __( 'Footer', 'million-dollar-pools' ),
        'priority' => 40,
    ] );

    $wp_customize->add_setting( 'mdp_affiliate_disclaimer', [
        'default'           => 'This site contains affiliate links. We may earn a commission on bookings made through our links, at no additional cost to you.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ] );
    $wp_customize->add_control( 'mdp_affiliate_disclaimer', [
        'label'   => __( 'Affiliate Disclaimer', 'million-dollar-pools' ),
        'section' => 'mdp_footer',
        'type'    => 'textarea',
    ] );
}
add_action( 'customize_register', 'mdp_customizer_register' );

/* ── Output dynamic CSS for customizer settings ── */
function mdp_customizer_css() {
    $gold = get_theme_mod( 'mdp_gold_color', '#C9A84C' );
    if ( $gold === '#C9A84C' ) return; // no overrides needed
    ?>
    <style id="mdp-customizer-css">
        :root {
            --gold: <?php echo sanitize_hex_color($gold); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'mdp_customizer_css' );
