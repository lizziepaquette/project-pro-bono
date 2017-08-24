<?php
add_theme_support('post-thumbnails');
add_theme_support('title-tag');

add_action('init', 'register_navbar_menu');
function register_navbar_menu() {
    register_nav_menu('navbar-menu', 'Navigation Bar');
}

add_action('wp_enqueue_scripts', 'quotidian_load_page_resources');
function quotidian_load_page_resources() {
    wp_enqueue_style('font-awesome', get_theme_file_uri('/assets/icomoon/style.css'));
    wp_enqueue_style('normalize', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css', array(), '7.0.0');
    wp_enqueue_style('quot-base', get_stylesheet_uri());

    wp_enqueue_script('quot-nav', get_theme_file_uri('/assets/js/navigation.js'));
    // register, but don't enqueue: only load these on pages displaying a map
    wp_register_script('raphael','https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js', array(), '2.2.7');
    wp_register_script('quot-map',
        get_theme_file_uri('/assets/js/us-map.js'),
        array('raphael'),
        '1.0.3',
        true);
}

// The frontpage uses a shortcode so that placing the map is intuitive
add_shortcode('state_selector_map', 'quotidian_state_selector_map_handler');
function quotidian_state_selector_map_handler() {
    wp_enqueue_script('quot-map');
    return ("<div id='map-container'>
        <div id='map'></div>
        <div id='state-name'></div>
    </div>");
}

// Responsive layout doesn't work with fixed image sizes, but Wordpress assigns
// them by default. Code from here: https://wordpress.stackexchange.com/a/5606
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
function remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', '', $html);
    return $html;
}
