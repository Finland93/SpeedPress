<?php
// Enqueue favicons and app icons
function speedpress_enqueue_favicons() {
    echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url(get_template_directory_uri() . '/apple-touch-icon.png') . '">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url(get_template_directory_uri() . '/favicon-32x32.png') . '">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url(get_template_directory_uri() . '/favicon-16x16.png') . '">' . "\n";
    echo '<link rel="manifest" href="' . esc_url(get_template_directory_uri() . '/site.webmanifest') . '">' . "\n";
}
add_action('wp_head', 'speedpress_enqueue_favicons');

// Remove jQuery if WooCommerce is not installed
function speedpress_conditional_jquery() {
    if (!class_exists('WooCommerce')) {
        // If WooCommerce is not installed, deregister jQuery
        wp_deregister_script('jquery');
    } else {
        // If WooCommerce is installed, ensure jQuery is enqueued
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'speedpress_conditional_jquery', 5); // Run early to ensure jQuery is deregistered before being enqueued

// Enqueue styles and scripts
function speedpress_enqueue_styles_scripts() {
    // Styles
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.3.0');
    wp_enqueue_style('main-style', get_stylesheet_uri());
    wp_enqueue_style('custom-fonts', get_template_directory_uri() . '/fonts.css', array(), '1.0.0');

    // Scripts
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array(), '5.3.0', true);
}
add_action('wp_enqueue_scripts', 'speedpress_enqueue_styles_scripts');

// Remove jQuery Migrate if jQuery is loaded
function speedpress_remove_jquery_migrate($scripts) {
    if (isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            // Remove jQuery Migrate if jQuery is being loaded
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'speedpress_remove_jquery_migrate');


// Setup theme features
function speedpress_setup_theme() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'speedpress'),
    ));
    add_theme_support('widgets', 'speedpress');
}
add_action('after_setup_theme', 'speedpress_setup_theme');

// Register required plugins
require_once get_template_directory() . '/class-plugin-activation.php';

function speedpress_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'Classic Editor',
            'slug'      => 'classic-editor',
            'required'  => true,
        ),
        array(
            'name'      => 'Classic Widgets',
            'slug'      => 'classic-widgets',
            'required'  => true,
        ),
    );

    $plugin_activation = new Plugin_Activation();
    $plugin_activation->add_plugins($plugins);
}
add_action('after_setup_theme', 'speedpress_register_required_plugins');

// Remove Gutenberg block editor assets
function speedpress_remove_block_editor_assets() {
    // Styles
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS if WooCommerce is used
    wp_dequeue_style('global-styles'); // Remove Global Styles

    // Scripts
    wp_dequeue_script('wp-block-library');
    wp_dequeue_script('wp-block-library-theme');
    wp_dequeue_script('wp-element');
    wp_dequeue_script('wp-data');
    wp_dequeue_script('wp-compose');
    wp_dequeue_script('wp-hooks');
    wp_dequeue_script('wp-rich-text');
    wp_dequeue_script('wp-editor');
    wp_dequeue_script('wp-blocks');
}
add_action('wp_enqueue_scripts', 'speedpress_remove_block_editor_assets', 100);

// Disable Block Editor
add_filter('use_block_editor_for_post_type', '__return_false', 100);

// Enforce Classic Widgets
add_filter('use_widgets_block_editor', '__return_false');

// Include custom navwalker
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

// Register Footer Widget Areas
function speedpress_register_footer_widgets() {
    register_sidebar(array(
        'name'          => __('Footer Widget Area 1', 'speedpress'),
        'id'            => 'footer-widget-area-1',
        'description'   => __('Add widgets here to appear in your footer.', 'speedpress'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area 2', 'speedpress'),
        'id'            => 'footer-widget-area-2',
        'description'   => __('Add widgets here to appear in your footer.', 'speedpress'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget Area 3', 'speedpress'),
        'id'            => 'footer-widget-area-3',
        'description'   => __('Add widgets here to appear in your footer.', 'speedpress'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'speedpress_register_footer_widgets');

// Register Sidebar Widget Area
function speedpress_register_sidebar_widgets() {
    register_sidebar(array(
        'name'          => __('Sidebar Widget Area', 'speedpress'),
        'id'            => 'sidebar-widget-area',
        'description'   => __('Add widgets here to appear in your sidebar.', 'speedpress'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="sidebar-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'speedpress_register_sidebar_widgets');

// Remove emojis from WordPress
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove TinyMCE emojis (from the editor)
add_filter('tiny_mce_plugins', 'speedpress_disable_tinymce_emojis');
function speedpress_disable_tinymce_emojis($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

// Remove emoji CDN hostname from DNS prefetching hints
add_filter('emoji_svg_url', '__return_false');

// Remove emoji script from the page if user-agent is not Internet Explorer
add_filter('wp_resource_hints', 'speedpress_disable_emojis_remove_dns_prefetch', 10, 2);
function speedpress_disable_emojis_remove_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
        $urls = array_diff($urls, array($emoji_svg_url));
    }
    return $urls;
}

// Disable support for comments and trackbacks in posts
function speedpress_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('init', 'speedpress_disable_comments_post_types_support');

// Close comments on the front-end
function speedpress_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'speedpress_disable_comments_status', 20, 2);
add_filter('pings_open', 'speedpress_disable_comments_status', 20, 2);

// Hide existing comments
function speedpress_disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'speedpress_disable_comments_hide_existing_comments', 10, 2);

// Remove comments from admin menu
function speedpress_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'speedpress_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function speedpress_disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ('edit-comments.php' === $pagenow) {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'speedpress_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function speedpress_disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'speedpress_disable_comments_dashboard');

// Remove comments links from admin bar
function speedpress_disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'speedpress_disable_comments_admin_bar');

// Remove comment count bubble from admin bar
function speedpress_disable_comments_admin_bar_css() {
    echo '<style>#wpadminbar #wp-admin-bar-comments { display: none; }</style>';
}
add_action('wp_head', 'speedpress_disable_comments_admin_bar_css');

// Remove "Comments are closed" message from admin area
function speedpress_disable_comments_closed_message($open, $post_id) {
    return false;
}
add_filter('comments_open', 'speedpress_disable_comments_closed_message', 10, 2);

// Remove comment icon from admin bar
function speedpress_disable_comments_admin_bar_icon() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'speedpress_disable_comments_admin_bar_icon');

// Add theme support for Featured Images
add_theme_support('post-thumbnails');

// Change archive image size for optimization
add_image_size('archive-banner', 582, 332, true);

// Change hero image size for optimization
add_image_size('hero-image', 1980, 367, true);



// Check if WooCommerce is active
if ( class_exists( 'WooCommerce' ) ) {
	//Support for WooCommerce
	add_theme_support( 'woocommerce' );
	
    // Remove product zoom
    add_filter('woocommerce_single_product_zoom_enabled', '__return_false');

    // Remove Order Notes Title - Additional Information & Notes Field
    add_filter('woocommerce_enable_order_notes_field', '__return_false', 9999);

    // Remove Order Notes Field
    add_filter('woocommerce_checkout_fields', 'remove_order_notes');

    function remove_order_notes($fields) {
        unset($fields['order']['order_comments']);
        return $fields;
    }

    // Redirect cart to combined checkout page if cart is not empty
    function redirect_cart_to_combined_checkout() {
        if (is_cart() && !WC()->cart->is_empty()) {
            wp_redirect(wc_get_checkout_url());
            exit;
        }
    }
    add_action('template_redirect', 'redirect_cart_to_combined_checkout');

    // Redirect empty cart to shop page
    function redirect_empty_cart_to_shop() {
        if (is_cart() && WC()->cart->is_empty()) {
            $shop_page_url = get_permalink(wc_get_page_id('shop'));
            wp_redirect($shop_page_url);
            exit;
        }
    }
    add_action('template_redirect', 'redirect_empty_cart_to_shop');

    // Set custom checkout template
    function speedpress_checkout_template($template) {
        if (is_checkout()) {
            $custom_template = locate_template('checkout.php');
            if ($custom_template) {
                return $custom_template;
            }
        }
        return $template;
    }
    add_filter('template_include', 'speedpress_checkout_template');
	
}
