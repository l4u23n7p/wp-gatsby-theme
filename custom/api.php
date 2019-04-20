<?php
/**
 * Rest API modifications
 */

add_action('rest_api_init', 'wp_rest_api_alter');
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
    register_rest_field(
        'project',
        'featured_media_url',
        array(
            'get_callback' => 'get_post_featured_media',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field('post', 'author_meta', array(
        'get_callback' => 'get_author_meta',
        'update_callback' => null,
        'schema' => null,
    ));
    register_rest_field('project', 'project_meta', array(
        'get_callback' => 'get_project_meta',
        'update_callback' => null,
        'schema' => null,
    ));
}

function get_post_categories($data, $field, $request)
{
    $formatted_categories = array();
    $categories = get_the_category($data['id']);
    if ($categories) {
        foreach ($categories as $category) {
            array_push($formatted_categories, (object) [
                'text_color' => get_field('text_color', $category),
                'color' => get_field('color', $category),
                'title' => $category->name,
                'slug' => $type->slug,
            ]);
        }
        return $formatted_categories;
    }
    return [];
}

function get_project_types($data, $field, $request) 
{
    $formatted_types = array();
    $types = get_the_terms( $data['id'], 'type' );
    if ($types) {
        foreach ($types as $type) {
            array_push($formatted_types, (object) [
                'text_color' => get_field('text_color', $type),
                'color' => get_field('color', $type),
                'title' => $type->name,
                'slug' => $type->slug,
            ]);
        }
        return $formatted_types;
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

function get_author_meta($data, $field, $request)
{
    $author_meta = array();
    $user_data = get_userdata($data['author']);
    $display_name = $user_data->data->display_name;
    $avatar_url = get_avatar_url($user_data->data->ID);
    $twitter_url = get_the_author_meta('twitter', $user_data->data->ID);
    $linkedin_url = get_the_author_meta('linkedin', $user_data->data->ID);

    $author_meta['display_name'] = $display_name;
    $author_meta['avatar_url'] = $avatar_url;
    $author_meta['twitter_url'] = $twitter_url;
    $author_meta['linkedin_url'] = $linkedin_url;

    return $author_meta;
}

function get_project_meta($data, $field, $request)
{
    $fields = get_fields($data['id']);
   
    return $fields;
}