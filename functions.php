<?php
/**
 * wp-gatsby-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-gatsby-theme
 */

/**
 * Register a book post type, with REST API support
 *
 * Based on example at: https://codex.wordpress.org/Function_Reference/register_post_type
 */

add_action('init', 'custom_post_types');
function custom_post_types()
{
    register_post_type(
        'project',
        array(
            'labels' => array('name' => __('Projects'), 'singular_name' => __('Project')),
            'public' => true,
            'has_archive' => true,
            'rest_base' => 'projects',
            'public' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_icon' => 'dashicons-welcome-learn-more',
        )
    );
}

add_action('publish_post', 'post_published_notification', 10, 2);
function post_published_notification($ID, $post)
{
    wp_remote_post('https: //api.netlify.com/build_hooks/5c3c61c7ccd232cd98299079');
}
