<?php

/**
 * Custom post types and taxonomies
 */

add_action('init', 'custom_post_types');
add_action('init', 'add_project_taxonomy', 20);
add_filter('manage_edit-category_columns' , 'custom_taxonomy_columns');
add_filter('manage_edit-filter_columns' , 'custom_taxonomy_columns');
add_filter( 'manage_category_custom_column', 'category_columns_content', 10, 3 );
add_filter( 'manage_filter_custom_column', 'filter_columns_content', 10, 3 );

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
                'add_new_item' => __('Add Filter'),
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

function custom_taxonomy_columns( $columns )
{
	$columns['color'] = __('Color');
	$columns['text_color'] = __('Text Color');

	return $columns;
}

function taxonomy_columns_content( $taxonomy, $content, $column_name, $term_id )
{
    $term = get_term( $term_id, $taxonomy);

    if ('color' == $column_name) {
        $color = get_field('color', $term);
        $content = '<div style="background-color: ' . $color . ';height: 25px;box-shadow: 1px 1px 4px black;">';
    }
    if ( 'text_color' == $column_name ) {
        $text_color = get_field('text_color', $term);
        $content = '<div style="background-color: ' . $text_color . ';height: 25px;box-shadow: 1px 1px 4px black;">';
		
    }
	return $content;
}

function category_columns_content( $content, $column_name, $term_id) {
    return taxonomy_columns_content( 'category', $content, $column_name, $term_id );
}

function filter_columns_content( $content, $column_name, $term_id) {
    return taxonomy_columns_content( 'filter', $content, $column_name, $term_id );
}