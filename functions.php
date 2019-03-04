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

// Fonction pour modifier l'adresse email de l'expéditeur
function wpm_email_from( $original_email_address ) {

    $domain_name = substr(strrchr($original_email_address, "@"), 1);

    return 'no-reply@' . $domain_name;

}
add_filter( 'wp_mail_from', 'wpm_email_from' );


// Fonction pour changer le nom de l'expéditeur de l'email
function wpm_expediteur( $original_email_from ) {

    return 'System';

}
add_filter( 'wp_mail_from_name', 'wpm_expediteur' );
