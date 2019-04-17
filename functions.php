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
function wpm_email_from($original_email_address)
{
    $domain_name = substr(strrchr($original_email_address, "@"), 1);

    return 'no-reply@' . $domain_name;
}
add_filter('wp_mail_from', 'wpm_email_from');


// Fonction pour changer le nom de l'expéditeur de l'email
function wpm_expediteur($original_email_from)
{
    return 'System';
}
add_filter('wp_mail_from_name', 'wpm_expediteur');

function add_project_field_group()
{
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
        'key' => 'group_5c3a00c425e00',
        'title' => 'project_fields',
        'fields' => array(
            array(
                'key' => 'field_5c3a0190aef9b',
                'label' => 'Informations',
                'name' => 'informations',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_5c3a181549aea',
                'label' => 'Thumbnail',
                'name' => 'thumbnail',
                'type' => 'image',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'full',
                'library' => 'uploadedTo',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_5c3a17afac612',
                'label' => 'Gallery',
                'name' => 'gallery',
                'type' => 'gallery',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'min' => 1,
                'max' => '',
                'insert' => 'append',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => 'png, jpeg, jpg',
            ),
            array(
                'key' => 'field_5c3a01baaef9c',
                'label' => 'Descriptions',
                'name' => 'descriptions',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_5c3a01f8aef9d',
                'label' => 'Stacks',
                'name' => 'stacks',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_5c3a0212aef9e',
                'label' => 'Link',
                'name' => 'link',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'project',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    }
}
add_action('acf/init', 'add_project_field_group');
