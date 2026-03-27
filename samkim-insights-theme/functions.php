<?php
/**
 * Sam Kim Insights — functions.php
 */

/* ── Theme setup ── */
function ski_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', ['search-form','comment-form','comment-list','gallery','caption'] );
    add_theme_support( 'custom-logo' );

    register_nav_menus([
        'primary' => __( 'Primary Navigation', 'ski' ),
    ]);
}
add_action( 'after_setup_theme', 'ski_setup' );

/* ── Enqueue assets ── */
function ski_enqueue() {
    // Google Fonts
    wp_enqueue_style( 'ski-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;500;600;700;800&display=swap',
        [], null );

    // Theme stylesheet
    wp_enqueue_style( 'ski-style', get_stylesheet_uri(), ['ski-google-fonts'], '1.0' );

    // Tailwind CDN (play CDN — fine for staging/production small sites)
    wp_enqueue_script( 'tailwind-cdn',
        'https://cdn.tailwindcss.com',
        [], null, false );

    // EmailJS (optional — for contact form)
    wp_enqueue_script( 'emailjs',
        'https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js',
        [], null, true );

    // Theme JS
    wp_enqueue_script( 'ski-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [], '1.0', true );

    // Pass data to JS
    wp_localize_script( 'ski-main', 'SKI', [
        'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
        'loginUrl'    => wp_login_url( home_url() ),
        'registerUrl' => wp_registration_url(),
        'logoutUrl'   => wp_logout_url( home_url() ),
        'isLoggedIn'  => is_user_logged_in(),
        'currentUser' => is_user_logged_in() ? wp_get_current_user()->display_name : '',
    ]);
}
add_action( 'wp_enqueue_scripts', 'ski_enqueue' );

/* ── Create default categories on theme activation ── */
function ski_create_categories() {
    $cats = [
        'Special Report'          => 'special-report',
        'Spotlight'               => 'spotlight',
        'Case Studies & Insights' => 'case-studies',
        'Deep Dive Blog'          => 'deep-dive',
    ];
    foreach ( $cats as $name => $slug ) {
        if ( ! term_exists( $slug, 'category' ) ) {
            wp_insert_term( $name, 'category', [ 'slug' => $slug ] );
        }
    }
}
add_action( 'after_switch_theme', 'ski_create_categories' );

/* ── Helper: query posts by category slug ── */
function ski_get_posts( $cat_slug, $count = 4 ) {
    return new WP_Query([
        'category_name'  => $cat_slug,
        'posts_per_page' => $count,
        'post_status'    => 'publish',
    ]);
}

/* ── Helper: category label color ── */
function ski_cat_color( $slug ) {
    return $slug === 'special-report' ? 'bg-red-600 text-white' : 'text-red-600';
}

/* ── Excerpt length ── */
add_filter( 'excerpt_length', fn() => 22 );
add_filter( 'excerpt_more',   fn() => '…' );

/* ── Remove WordPress admin bar on front-end (optional) ── */
// add_filter( 'show_admin_bar', '__return_false' );

/* ── Custom login redirect ── */
add_filter( 'login_redirect', function( $redirect_to, $request, $user ) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'administrator', $user->roles ) ) {
            return admin_url();
        }
        return home_url();
    }
    return $redirect_to;
}, 10, 3 );
