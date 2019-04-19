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
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
));

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
add_action('init', 'add_project_taxonomy');
function add_project_taxonomy()
{
    register_taxonomy(
        'type',
        'project',
        array(
            'label' => 'Types',
            'labels' => array(
                'name' => 'Types',
                'singular_name' => 'Type',
                'all_items' => 'Tous les types',
                'edit_item' => 'Éditer le type',
                'view_item' => 'Voir le type',
                'update_item' => 'Mettre à jour le type',
                'add_new_item' => 'Ajouter un type',
                'new_item_name' => 'Nouveau type',
                'search_items' => 'Rechercher parmi les types',
                'popular_items' => 'Types les plus utilisés',
            ),
            'hierarchical' => true,
            'rest_base' => 'types',
            'public' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
        )
    );
}
add_action('publish_post', 'post_published_notification', 10, 2);
function post_published_notification($ID, $post)
{
    wp_remote_post('https: //api.netlify.com/build_hooks/5c3c61c7ccd232cd98299079');
}
// Fonction pour modifier l'adresse email de l'expéditeur
add_filter('wp_mail_from', 'wpm_email_from');
function wpm_email_from($original_email_address)
{
    $domain_name = substr(strrchr($original_email_address, "@"), 1);
    return 'no-reply@' . $domain_name;
}
// Fonction pour changer le nom de l'expéditeur de l'email
add_filter('wp_mail_from_name', 'wpm_expediteur');
function wpm_expediteur($original_email_from)
{
    return 'System';
}
add_action('acf/init', 'add_project_field_group');
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
add_filter('rest_prepare_post', 'wp_api_encode_yoast', 10, 3);
add_filter('rest_prepare_page', 'wp_api_encode_yoast', 10, 3);
add_filter('rest_prepare_project', 'wp_api_encode_yoast', 10, 3);
function wp_api_encode_yoast($data, $post, $context)
{
    $yoastMeta = array(
        'yoast_wpseo_focuskw' => get_post_meta($post->ID, '_yoast_wpseo_focuskw', true),
        'yoast_wpseo_title' => get_post_meta($post->ID, '_yoast_wpseo_title', true),
        'yoast_wpseo_metadesc' => get_post_meta($post->ID, '_yoast_wpseo_metadesc', true),
        'yoast_wpseo_linkdex' => get_post_meta($post->ID, '_yoast_wpseo_linkdex', true),
        'yoast_wpseo_metakeywords' => get_post_meta($post->ID, '_yoast_wpseo_metakeywords', true),
        'yoast_wpseo_meta-robots-noindex' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-noindex', true),
        'yoast_wpseo_meta-robots-nofollow' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-nofollow', true),
        'yoast_wpseo_meta-robots-adv' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-adv', true),
        'yoast_wpseo_canonical' => get_post_meta($post->ID, '_yoast_wpseo_canonical', true),
        'yoast_wpseo_redirect' => get_post_meta($post->ID, '_yoast_wpseo_redirect', true),
        'yoast_wpseo_opengraph-title' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-title', true),
        'yoast_wpseo_opengraph-description' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-description', true),
        'yoast_wpseo_opengraph-image' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-image', true),
        'yoast_wpseo_twitter-title' => get_post_meta($post->ID, '_yoast_wpseo_twitter-title', true),
        'yoast_wpseo_twitter-description' => get_post_meta($post->ID, '_yoast_wpseo_twitter-description', true),
        'yoast_wpseo_twitter-image' => get_post_meta($post->ID, '_yoast_wpseo_twitter-image', true),
    );
    $data->data['yoast_meta'] = (array) $yoastMeta;
    return $data;
}
add_action('rest_api_init', 'wp_rest_api_alter');
function wp_rest_api_alter()
{
    register_rest_field(
        'post',
        'post_categories',
        array(
            'get_callback' => 'get_post_categories',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field(
        'post',
        'featured_media_url',
        array(
            'get_callback' => 'get_post_featured_media',
            'update_callback' => null,
            'schema' => null,
        )
    );
}
function get_post_categories($data, $field, $request)
{
    $formatted_categories = array();
    $categories = get_the_category($data['id']);
    if ($categories) {
        foreach ($categories as $category) {
            $formatted_categories[] = $category->name;
        }
        return $formatted_categories;
    }
    return [];
}
function get_post_featured_media($data, $field, $request)
{
    $featured_media_url = wp_get_attachment_image_src(get_post_thumbnail_id($data->id), 'full')['0'];
    if ($featured_media_url) {
        return $featured_media_url;
    }
    return "";
}
