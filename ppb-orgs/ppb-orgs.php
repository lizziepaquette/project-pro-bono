<?php
/**
 * Plugin Name: PPB Organization Listings
 * Description: Display PPB's lists of volunteer organizations with all metadata
 * Version: 0.1
 * Author: Rahul Gosain
 * License: UNLICENSED
 *
 * This plugin adds an "Organization" post types and 3 new taxonomies to
 * categorize them: "State", "Issue" (the organization's issue focus) and
 * "Skill" (skills they need from volunteers). It also creates a meta box for
 * entering a "Learn More" link that a template can display.
 */

add_action('init', 'register_organization_post_type');
function register_organization_post_type() {
    $labels = array(
        'name'               => 'Organizations',
        'singular_name'      => 'Organization',
        'menu_name'          => 'Organizations',
        'name_admin_bar'     => 'Organization',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Organization',
        'new_item'           => 'New Organization',
        'edit_item'          => 'Edit Organization',
        'view_item'          => 'View Organization',
        'all_items'          => 'All Organizations',
        'search_items'       => 'Search Testimonials',
        'not_found'          => 'No organizations found.',
        'not_found_in_trash' => 'No organizations found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-groups',
        'query_var'          => true,
        'rewrite'            => array('slug' => 'organizations'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail')
    );

    register_post_type('organization', $args);
};


add_action('init', 'register_organization_taxonomies');
function register_organization_taxonomies() {
    register_taxonomy('issue', 'organization', array(
        'label'              => 'Issue',
        'rewrite'            => array('slug' => 'issue', 'with_front' => false),
        'hierarchical'       => true,
        'publicly_queryable' => false,
        'query_var'          => false
    ));

    register_taxonomy('skill', 'organization', array(
        'label'              => 'Skill',
        'rewrite'            => array('slug' => 'skill', 'with_front' => false),
        'hierarchical'       => false,
        'publicly_queryable' => false,
        'query_var'          => false
    ));

    register_taxonomy('state', 'organization', array(
        'label' 			 => 'State',
        'rewrite'            => array('slug' => 'state', 'with_front' => false),
        'hierarchical'       => true,
        'query_var'          => true,
        'publicly_queryable' => true,
    ));
}

register_activation_hook(__FILE__, 'my_flush_rewrite');
function my_flush_rewrite() {
    register_organization_post_type();
    register_organization_taxonomies();
    flush_rewrite_rules();
}

// == Meta Box Learn More URL ==

add_action('add_meta_boxes', 'add_learn_more_meta_box');
function add_learn_more_meta_box() {
    add_meta_box('learn_more_url_meta_box', 'Learn More URL',
        'build_learn_more_meta_box', 'organization', 'normal', 'high');
}

function build_learn_more_meta_box($post) {
    $values = get_post_meta($post->ID);
    $text = isset($values['learn_more_url'])
        ? $values['learn_more_url'][0]
        : '';
    wp_nonce_field('learn_more_meta_box_nonce', 'meta_box_nonce');
    echo '<input type="text" name="learn_more_url" id="learn_more_url" '
        . 'value="' . $text . '"' . '/>';
}

add_action('save_post', 'save_learn_more_meta_box');
function save_learn_more_meta_box($post_id) {
    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    // Don't save without valid nonce
    if (!isset($_POST['meta_box_nonce'])) return;
    if (!wp_verify_nonce( $_POST['meta_box_nonce'], 'learn_more_meta_box_nonce'))
        return;
    // Don't save if the user doesn't have edit permissions
    if (!current_user_can('edit_post', $post_id)) return;
    // Don't save if it's not an organization
    if (get_post_type($post_id) != 'organization') return;

    // Save
    $url = esc_url_raw($_POST['learn_more_url']);
    add_post_meta($post_id, 'learn_more_url', $url);
    if (empty($url)) {
        delete_post_meta($post_id, 'learn_more_url');
   } else {
        update_post_meta($post_id, 'learn_more_url', $url);
   }
} ?>
