<?php
/**
 * Million Dollar Pools - Theme Functions
 *
 * @package MillionDollarPools
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'MDP_VERSION',   '1.0.0' );
define( 'MDP_DIR',       get_template_directory() );
define( 'MDP_URI',       get_template_directory_uri() );

/* ============================================================
   THEME SETUP
   ============================================================ */
function mdp_setup() {
    load_theme_textdomain( 'million-dollar-pools', MDP_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'
    ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ] );

    // Custom image sizes
    add_image_size( 'mdp-hero',        1920, 1080, true );
    add_image_size( 'mdp-card',         800,  600, true );
    add_image_size( 'mdp-thumbnail',    400,  300, true );
    add_image_size( 'mdp-gallery',      800,  600, true );

    // Navigation menus
    register_nav_menus( [
        'primary'  => __( 'Primary Navigation', 'million-dollar-pools' ),
        'footer-1' => __( 'Footer Column 1',    'million-dollar-pools' ),
        'footer-2' => __( 'Footer Column 2',    'million-dollar-pools' ),
        'footer-3' => __( 'Footer Column 3',    'million-dollar-pools' ),
    ] );
}
add_action( 'after_setup_theme', 'mdp_setup' );

/* ============================================================
   ENQUEUE STYLES & SCRIPTS
   ============================================================ */
function mdp_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'mdp-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Cinzel:wght@400;600;700;900&family=Montserrat:wght@300;400;500;600;700&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style( 'mdp-style', get_stylesheet_uri(), [ 'mdp-google-fonts' ], MDP_VERSION );

    // Main JS
    wp_enqueue_script(
        'mdp-main',
        MDP_URI . '/assets/js/main.js',
        [],
        MDP_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script( 'mdp-main', 'MDP', [
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'mdp_nonce' ),
        'siteurl' => get_site_url(),
    ] );

    // Comments script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'mdp_enqueue_assets' );

/* ============================================================
   CUSTOM POST TYPE: POOLS
   ============================================================ */
function mdp_register_pool_cpt() {
    $labels = [
        'name'               => __( 'Pools',             'million-dollar-pools' ),
        'singular_name'      => __( 'Pool',              'million-dollar-pools' ),
        'add_new'            => __( 'Add New Pool',       'million-dollar-pools' ),
        'add_new_item'       => __( 'Add New Pool',       'million-dollar-pools' ),
        'edit_item'          => __( 'Edit Pool',          'million-dollar-pools' ),
        'new_item'           => __( 'New Pool',           'million-dollar-pools' ),
        'view_item'          => __( 'View Pool',          'million-dollar-pools' ),
        'search_items'       => __( 'Search Pools',       'million-dollar-pools' ),
        'not_found'          => __( 'No pools found',     'million-dollar-pools' ),
        'not_found_in_trash' => __( 'No pools in trash',  'million-dollar-pools' ),
        'menu_name'          => __( 'Pools',              'million-dollar-pools' ),
    ];

    register_post_type( 'pool', [
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'pools' ],
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
        'menu_icon'           => 'dashicons-palmtree',
        'show_in_rest'        => true,
        'menu_position'       => 5,
    ] );
}
add_action( 'init', 'mdp_register_pool_cpt' );

/* ============================================================
   CUSTOM TAXONOMY: REGION / COUNTRY
   ============================================================ */
function mdp_register_taxonomies() {
    // Region taxonomy
    register_taxonomy( 'pool_region', 'pool', [
        'label'        => __( 'Regions', 'million-dollar-pools' ),
        'hierarchical' => true,
        'rewrite'      => [ 'slug' => 'region' ],
        'show_in_rest' => true,
    ] );

    // Pool type taxonomy
    register_taxonomy( 'pool_type', 'pool', [
        'label'        => __( 'Pool Types', 'million-dollar-pools' ),
        'hierarchical' => false,
        'rewrite'      => [ 'slug' => 'pool-type' ],
        'show_in_rest' => true,
    ] );
}
add_action( 'init', 'mdp_register_taxonomies' );

/* ============================================================
   CUSTOM META FIELDS (via register_post_meta)
   ============================================================ */
function mdp_register_meta_fields() {
    $string_fields = [
        'pool_rank',
        'pool_score',
        'pool_location_country',
        'pool_location_city',
        'pool_resort_name',
        'pool_architect',
        'pool_year_built',
        'pool_pool_length',
        'pool_pool_depth',
        'pool_elevation',
        'pool_pool_type',
        'pool_affiliate_link',
        'pool_affiliate_label',
        'pool_best_time_to_visit',
        'pool_price_range',
        'pool_coordinates_lat',
        'pool_coordinates_lng',
        // Score breakdown
        'pool_score_design',
        'pool_score_setting',
        'pool_score_uniqueness',
        'pool_score_experience',
        'pool_score_accessibility',
    ];

    foreach ( $string_fields as $key ) {
        register_post_meta( 'pool', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => function() { return current_user_can( 'edit_posts' ); },
        ] );
    }
}
add_action( 'init', 'mdp_register_meta_fields' );

/* ============================================================
   ADMIN META BOX FOR POOL DETAILS
   ============================================================ */
function mdp_add_pool_meta_boxes() {
    add_meta_box(
        'mdp_pool_details',
        __( 'Pool Details & Ranking', 'million-dollar-pools' ),
        'mdp_pool_details_callback',
        'pool',
        'normal',
        'high'
    );
    add_meta_box(
        'mdp_pool_affiliate',
        __( 'Affiliate Booking Link', 'million-dollar-pools' ),
        'mdp_pool_affiliate_callback',
        'pool',
        'side',
        'high'
    );
    add_meta_box(
        'mdp_pool_scores',
        __( 'Score Breakdown', 'million-dollar-pools' ),
        'mdp_pool_scores_callback',
        'pool',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'mdp_add_pool_meta_boxes' );

function mdp_pool_details_callback( $post ) {
    wp_nonce_field( 'mdp_save_pool_meta', 'mdp_pool_nonce' );
    $fields = [
        'pool_rank'               => [ 'label' => 'Overall Rank (e.g. 1)',        'type' => 'number' ],
        'pool_score'              => [ 'label' => 'Overall Score (e.g. 98.5)',     'type' => 'text' ],
        'pool_resort_name'        => [ 'label' => 'Resort / Hotel Name',           'type' => 'text' ],
        'pool_location_city'      => [ 'label' => 'City',                          'type' => 'text' ],
        'pool_location_country'   => [ 'label' => 'Country',                       'type' => 'text' ],
        'pool_architect'          => [ 'label' => 'Designer / Architect',          'type' => 'text' ],
        'pool_year_built'         => [ 'label' => 'Year Built / Opened',           'type' => 'text' ],
        'pool_pool_length'        => [ 'label' => 'Pool Length (e.g. 150m)',       'type' => 'text' ],
        'pool_pool_depth'         => [ 'label' => 'Pool Depth (e.g. 1.4m)',        'type' => 'text' ],
        'pool_elevation'          => [ 'label' => 'Elevation (e.g. 200m above sea level)', 'type' => 'text' ],
        'pool_best_time_to_visit' => [ 'label' => 'Best Time to Visit',            'type' => 'text' ],
        'pool_price_range'        => [ 'label' => 'Price Range (e.g. $$$$$)',      'type' => 'text' ],
        'pool_coordinates_lat'    => [ 'label' => 'GPS Latitude',                  'type' => 'text' ],
        'pool_coordinates_lng'    => [ 'label' => 'GPS Longitude',                 'type' => 'text' ],
    ];
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:12px 0;">';
    foreach ( $fields as $key => $field ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<div>';
        echo '<label style="display:block;font-weight:600;margin-bottom:6px;color:#1d2327;" for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label>';
        echo '<input type="' . esc_attr($field['type']) . '" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px 10px;border:1px solid #8c8f94;border-radius:4px;" />';
        echo '</div>';
    }
    echo '</div>';
}

function mdp_pool_affiliate_callback( $post ) {
    $link  = get_post_meta( $post->ID, 'pool_affiliate_link',  true );
    $label = get_post_meta( $post->ID, 'pool_affiliate_label', true );
    ?>
    <p>
        <label style="display:block;font-weight:600;margin-bottom:6px;" for="pool_affiliate_link">Booking URL (affiliate link)</label>
        <input type="url" id="pool_affiliate_link" name="pool_affiliate_link"
               value="<?php echo esc_attr($link); ?>"
               placeholder="https://booking.com/..." style="width:100%;" />
    </p>
    <p>
        <label style="display:block;font-weight:600;margin-bottom:6px;" for="pool_affiliate_label">Button Label</label>
        <input type="text" id="pool_affiliate_label" name="pool_affiliate_label"
               value="<?php echo esc_attr($label ?: 'Book Your Stay'); ?>"
               style="width:100%;" />
    </p>
    <p style="font-size:12px;color:#666;">
        Paste your affiliate booking URL. This will appear as a prominent call-to-action on the pool profile page.
    </p>
    <?php
}

function mdp_pool_scores_callback( $post ) {
    $score_fields = [
        'pool_score_design'       => 'Design & Architecture (0-100)',
        'pool_score_setting'      => 'Setting & Views (0-100)',
        'pool_score_uniqueness'   => 'Uniqueness (0-100)',
        'pool_score_experience'   => 'Experience & Amenities (0-100)',
        'pool_score_accessibility'=> 'Accessibility (0-100)',
    ];
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:12px 0;">';
    foreach ( $score_fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<div>';
        echo '<label style="display:block;font-weight:600;margin-bottom:6px;" for="' . esc_attr($key) . '">' . esc_html($label) . '</label>';
        echo '<input type="number" min="0" max="100" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px 10px;border:1px solid #8c8f94;border-radius:4px;" />';
        echo '</div>';
    }
    echo '</div>';
}

/* ============================================================
   SAVE META FIELDS
   ============================================================ */
function mdp_save_pool_meta( $post_id ) {
    if ( ! isset( $_POST['mdp_pool_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['mdp_pool_nonce'], 'mdp_save_pool_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $all_fields = [
        'pool_rank', 'pool_score', 'pool_location_country', 'pool_location_city',
        'pool_resort_name', 'pool_architect', 'pool_year_built', 'pool_pool_length',
        'pool_pool_depth', 'pool_elevation', 'pool_affiliate_link', 'pool_affiliate_label',
        'pool_best_time_to_visit', 'pool_price_range', 'pool_coordinates_lat',
        'pool_coordinates_lng', 'pool_score_design', 'pool_score_setting',
        'pool_score_uniqueness', 'pool_score_experience', 'pool_score_accessibility',
    ];

    foreach ( $all_fields as $field ) {
        if ( isset( $_POST[$field] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
    }
}
add_action( 'save_post_pool', 'mdp_save_pool_meta' );

/* ============================================================
   ADMIN COLUMNS FOR POOL LIST
   ============================================================ */
function mdp_pool_admin_columns( $columns ) {
    $new = [];
    foreach ( $columns as $key => $title ) {
        $new[$key] = $title;
        if ( $key === 'title' ) {
            $new['pool_rank']    = __( 'Rank',    'million-dollar-pools' );
            $new['pool_score']   = __( 'Score',   'million-dollar-pools' );
            $new['pool_country'] = __( 'Country', 'million-dollar-pools' );
        }
    }
    return $new;
}
add_filter( 'manage_pool_posts_columns', 'mdp_pool_admin_columns' );

function mdp_pool_admin_column_data( $column, $post_id ) {
    switch ( $column ) {
        case 'pool_rank':
            $rank = get_post_meta( $post_id, 'pool_rank', true );
            echo $rank ? '<strong>#' . esc_html($rank) . '</strong>' : '—';
            break;
        case 'pool_score':
            $score = get_post_meta( $post_id, 'pool_score', true );
            echo $score ? esc_html($score) . '/100' : '—';
            break;
        case 'pool_country':
            $country = get_post_meta( $post_id, 'pool_location_country', true );
            echo $country ? esc_html($country) : '—';
            break;
    }
}
add_action( 'manage_pool_posts_custom_column', 'mdp_pool_admin_column_data', 10, 2 );

function mdp_pool_sortable_columns( $columns ) {
    $columns['pool_rank']  = 'pool_rank';
    $columns['pool_score'] = 'pool_score';
    return $columns;
}
add_filter( 'manage_edit-pool_sortable_columns', 'mdp_pool_sortable_columns' );

/* ============================================================
   HELPER FUNCTIONS
   ============================================================ */

/**
 * Get pool meta shorthand
 */
function mdp_get( $key, $post_id = null ) {
    if ( ! $post_id ) $post_id = get_the_ID();
    return get_post_meta( $post_id, $key, true );
}

/**
 * Render star rating
 */
function mdp_star_rating( $score ) {
    $stars = round( $score / 20 ); // convert 0-100 to 0-5
    $output = '<span class="star-rating" aria-label="' . esc_attr($score) . '/100">';
    for ( $i = 1; $i <= 5; $i++ ) {
        $output .= $i <= $stars ? '★' : '☆';
    }
    $output .= '</span>';
    return $output;
}

/**
 * Get pools ordered by rank
 */
function mdp_get_pools( $args = [] ) {
    $defaults = [
        'post_type'      => 'pool',
        'posts_per_page' => 10,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'pool_rank',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ];
    return new WP_Query( array_merge( $defaults, $args ) );
}

/**
 * Pool card template tag
 */
function mdp_pool_card( $post_id, $class = '' ) {
    $rank          = mdp_get( 'pool_rank',            $post_id );
    $score         = mdp_get( 'pool_score',           $post_id );
    $country       = mdp_get( 'pool_location_country',$post_id );
    $city          = mdp_get( 'pool_location_city',   $post_id );
    $thumb_url     = get_the_post_thumbnail_url( $post_id, 'mdp-card' );
    $permalink     = get_permalink( $post_id );
    $name          = get_the_title( $post_id );
    $location      = implode( ', ', array_filter([$city, $country]) );

    $placeholder = MDP_URI . '/assets/images/pool-placeholder.jpg';

    ob_start();
    ?>
    <article class="pool-card <?php echo esc_attr($class); ?>" aria-label="<?php echo esc_attr($name); ?>">
        <a href="<?php echo esc_url($permalink); ?>" tabindex="0" aria-label="View <?php echo esc_attr($name); ?>">
            <img
                class="pool-card-image"
                src="<?php echo esc_url($thumb_url ?: $placeholder); ?>"
                alt="<?php echo esc_attr($name); ?>"
                loading="lazy"
            />
            <div class="pool-card-overlay"></div>

            <?php if ( $rank ) : ?>
            <div class="pool-card-rank">#<?php echo esc_html($rank); ?></div>
            <?php endif; ?>

            <?php if ( $score ) : ?>
            <div class="pool-card-score">
                <span class="score-value"><?php echo esc_html($score); ?></span>
                <span class="score-label">Score</span>
            </div>
            <?php endif; ?>

            <div class="pool-card-info">
                <h3 class="pool-card-name"><?php echo esc_html($name); ?></h3>
                <?php if ( $location ) : ?>
                <p class="pool-card-location"><?php echo esc_html($location); ?></p>
                <?php endif; ?>
                <span class="pool-card-cta">
                    View Profile
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </span>
            </div>
        </a>
    </article>
    <?php
    return ob_get_clean();
}

/* ============================================================
   WIDGETS
   ============================================================ */
function mdp_register_sidebars() {
    register_sidebar( [
        'name'          => __( 'Pool Sidebar', 'million-dollar-pools' ),
        'id'            => 'pool-sidebar',
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'mdp_register_sidebars' );

/* ============================================================
   AJAX: NEWSLETTER SIGNUP
   ============================================================ */
function mdp_newsletter_signup() {
    check_ajax_referer( 'mdp_nonce', 'nonce' );
    $email = sanitize_email( $_POST['email'] ?? '' );
    if ( ! is_email( $email ) ) {
        wp_send_json_error( [ 'message' => __( 'Please enter a valid email address.', 'million-dollar-pools' ) ] );
    }
    // Store subscriber in options (can be integrated with Mailchimp, etc.)
    $subscribers = get_option( 'mdp_subscribers', [] );
    if ( ! in_array( $email, $subscribers ) ) {
        $subscribers[] = $email;
        update_option( 'mdp_subscribers', $subscribers );
    }
    wp_send_json_success( [ 'message' => __( 'Welcome to the journey! Check your inbox.', 'million-dollar-pools' ) ] );
}
add_action( 'wp_ajax_mdp_newsletter',        'mdp_newsletter_signup' );
add_action( 'wp_ajax_nopriv_mdp_newsletter', 'mdp_newsletter_signup' );

/* ============================================================
   AJAX: POOL FILTER
   ============================================================ */
function mdp_filter_pools() {
    check_ajax_referer( 'mdp_nonce', 'nonce' );
    $region = sanitize_text_field( $_POST['region'] ?? '' );
    $type   = sanitize_text_field( $_POST['type']   ?? '' );
    $search = sanitize_text_field( $_POST['search'] ?? '' );
    $paged  = absint( $_POST['paged'] ?? 1 );

    $args = [
        'post_type'      => 'pool',
        'posts_per_page' => 20,
        'paged'          => $paged,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'pool_rank',
        'order'          => 'ASC',
    ];

    $tax_query = [];
    if ( $region ) {
        $tax_query[] = [ 'taxonomy' => 'pool_region', 'field' => 'slug', 'terms' => $region ];
    }
    if ( $type ) {
        $tax_query[] = [ 'taxonomy' => 'pool_type', 'field' => 'slug', 'terms' => $type ];
    }
    if ( ! empty( $tax_query ) ) {
        $args['tax_query'] = $tax_query;
    }
    if ( $search ) {
        $args['s'] = $search;
    }

    $query = new WP_Query( $args );
    ob_start();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/pool-list-row', null, [ 'post_id' => get_the_ID() ] );
        }
    } else {
        echo '<p class="no-results">No pools found matching your criteria.</p>';
    }
    wp_reset_postdata();
    $html = ob_get_clean();

    wp_send_json_success( [
        'html'        => $html,
        'total'       => $query->found_posts,
        'total_pages' => $query->max_num_pages,
    ] );
}
add_action( 'wp_ajax_mdp_filter_pools',        'mdp_filter_pools' );
add_action( 'wp_ajax_nopriv_mdp_filter_pools', 'mdp_filter_pools' );

/* ============================================================
   THEME OPTIONS PAGE
   ============================================================ */
function mdp_add_options_page() {
    add_theme_page(
        __( 'MDP Settings', 'million-dollar-pools' ),
        __( 'MDP Settings', 'million-dollar-pools' ),
        'manage_options',
        'mdp-settings',
        'mdp_options_page_html'
    );
}
add_action( 'admin_menu', 'mdp_add_options_page' );

function mdp_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( isset( $_POST['mdp_options_nonce'] ) && wp_verify_nonce( $_POST['mdp_options_nonce'], 'mdp_save_options' ) ) {
        update_option( 'mdp_hero_title',         sanitize_text_field( $_POST['mdp_hero_title']         ?? '' ) );
        update_option( 'mdp_hero_subtitle',      sanitize_text_field( $_POST['mdp_hero_subtitle']      ?? '' ) );
        update_option( 'mdp_featured_pool_id',   absint(              $_POST['mdp_featured_pool_id']   ?? 0  ) );
        update_option( 'mdp_affiliate_disclaimer', sanitize_textarea_field( $_POST['mdp_affiliate_disclaimer'] ?? '' ) );
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }
    $hero_title     = get_option( 'mdp_hero_title',     "The World's Most Incredible Pools" );
    $hero_subtitle  = get_option( 'mdp_hero_subtitle',  'Discover the 2026 Top 100' );
    $featured_id    = get_option( 'mdp_featured_pool_id', 0 );
    $disclaimer     = get_option( 'mdp_affiliate_disclaimer', 'This site contains affiliate links. We may earn a commission on bookings at no extra cost to you.' );
    ?>
    <div class="wrap">
        <h1><?php _e( 'Million Dollar Pools — Settings', 'million-dollar-pools' ); ?></h1>
        <form method="post">
            <?php wp_nonce_field( 'mdp_save_options', 'mdp_options_nonce' ); ?>
            <table class="form-table">
                <tr>
                    <th><?php _e( 'Hero Headline', 'million-dollar-pools' ); ?></th>
                    <td><input type="text" name="mdp_hero_title" value="<?php echo esc_attr($hero_title); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><?php _e( 'Hero Subheading', 'million-dollar-pools' ); ?></th>
                    <td><input type="text" name="mdp_hero_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><?php _e( 'Featured Pool (Hero)', 'million-dollar-pools' ); ?></th>
                    <td>
                        <input type="number" name="mdp_featured_pool_id" value="<?php echo esc_attr($featured_id); ?>" class="small-text" />
                        <p class="description"><?php _e( 'Enter the Pool post ID to feature in the hero. Leave 0 for rank #1.', 'million-dollar-pools' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Affiliate Disclaimer', 'million-dollar-pools' ); ?></th>
                    <td><textarea name="mdp_affiliate_disclaimer" rows="3" class="large-text"><?php echo esc_textarea($disclaimer); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/* ============================================================
   SEO: STRUCTURED DATA FOR POOLS
   ============================================================ */
function mdp_structured_data() {
    if ( ! is_singular( 'pool' ) ) return;
    $post_id  = get_the_ID();
    $rank     = mdp_get( 'pool_rank' );
    $country  = mdp_get( 'pool_location_country' );
    $city     = mdp_get( 'pool_location_city' );
    $resort   = mdp_get( 'pool_resort_name' );
    $score    = mdp_get( 'pool_score' );
    $lat      = mdp_get( 'pool_coordinates_lat' );
    $lng      = mdp_get( 'pool_coordinates_lng' );
    $thumb    = get_the_post_thumbnail_url( $post_id, 'mdp-hero' );

    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'TouristAttraction',
        'name'     => get_the_title(),
        'url'      => get_permalink(),
        'description' => get_the_excerpt(),
        'image'    => $thumb,
    ];
    if ( $resort )   $schema['containedInPlace'] = [ '@type' => 'LodgingBusiness', 'name' => $resort ];
    if ( $city || $country ) {
        $schema['address'] = [
            '@type'           => 'PostalAddress',
            'addressLocality' => $city,
            'addressCountry'  => $country,
        ];
    }
    if ( $lat && $lng ) {
        $schema['geo'] = [ '@type' => 'GeoCoordinates', 'latitude' => $lat, 'longitude' => $lng ];
    }
    if ( $score ) {
        $schema['aggregateRating'] = [
            '@type'       => 'AggregateRating',
            'ratingValue' => $score,
            'bestRating'  => '100',
            'worstRating' => '0',
            'ratingCount' => '1',
        ];
    }
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'mdp_structured_data' );

/* ============================================================
   EXCERPT LENGTH
   ============================================================ */
add_filter( 'excerpt_length', fn() => 25 );
add_filter( 'excerpt_more',   fn() => '&hellip;' );

/* ============================================================
   REMOVE EMOJI BLOAT
   ============================================================ */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/* ============================================================
   SECURITY: REMOVE WP VERSION
   ============================================================ */
remove_action( 'wp_head', 'wp_generator' );
