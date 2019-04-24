<?php

/**
 * Custom post types and taxonomies
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
add_action('init', 'add_project_taxonomy');
function add_project_taxonomy()
{
    register_taxonomy(
        'filter',
        'project',
        array(
            'label' => __('Filters'),
            'labels' => array(
                'name' => __('Filters'),
                'singular_name' => __('Filter'),
                'all_items' => __('All Filters'),
                'edit_item' => __('Edit Filter'),
                'view_item' => __('Show Filter'),
                'update_item' => __('Update Filter'),
                'add_new_item' => __('Add Filter',
                'new_item_name' => __('New Filter'),
                'search_items' => __('Search Filters'),
                'popular_items' => __('Popular Filters'),
            ),
            'hierarchical' => true,
            'rest_base' => 'filters',
            'public' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
        )
    );
}
