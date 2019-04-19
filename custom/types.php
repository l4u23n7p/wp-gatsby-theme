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
