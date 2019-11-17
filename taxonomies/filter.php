<?php

/**
 * Registers the `filter` taxonomy,
 * for use with 'project'.
 */
function filter_init() {
	register_taxonomy(
		'filter',
		array( 'project' ),
		array(
			'hierarchical'          => true,
			'public'                => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => true,
			'capabilities'          => array(
				'manage_terms' => 'manage_categories',
				'edit_terms'   => 'manage_categories',
				'delete_terms' => 'manage_categories',
				'assign_terms' => 'edit_posts',
			),
			'labels'                => array(
				'name'                       => __( 'Filters', 'wp-gatsby-theme' ),
				'singular_name'              => _x( 'Filter', 'taxonomy general name', 'wp-gatsby-theme' ),
				'search_items'               => __( 'Search Filters', 'wp-gatsby-theme' ),
				'popular_items'              => __( 'Popular Filters', 'wp-gatsby-theme' ),
				'all_items'                  => __( 'All Filters', 'wp-gatsby-theme' ),
				'parent_item'                => __( 'Parent Filter', 'wp-gatsby-theme' ),
				'parent_item_colon'          => __( 'Parent Filter:', 'wp-gatsby-theme' ),
				'edit_item'                  => __( 'Edit Filter', 'wp-gatsby-theme' ),
				'update_item'                => __( 'Update Filter', 'wp-gatsby-theme' ),
				'view_item'                  => __( 'View Filter', 'wp-gatsby-theme' ),
				'add_new_item'               => __( 'Add New Filter', 'wp-gatsby-theme' ),
				'new_item_name'              => __( 'New Filter', 'wp-gatsby-theme' ),
				'separate_items_with_commas' => __( 'Separate filters with commas', 'wp-gatsby-theme' ),
				'add_or_remove_items'        => __( 'Add or remove filters', 'wp-gatsby-theme' ),
				'choose_from_most_used'      => __( 'Choose from the most used filters', 'wp-gatsby-theme' ),
				'not_found'                  => __( 'No filters found.', 'wp-gatsby-theme' ),
				'no_terms'                   => __( 'No filters', 'wp-gatsby-theme' ),
				'menu_name'                  => __( 'Filters', 'wp-gatsby-theme' ),
				'items_list_navigation'      => __( 'Filters list navigation', 'wp-gatsby-theme' ),
				'items_list'                 => __( 'Filters list', 'wp-gatsby-theme' ),
				'most_used'                  => _x( 'Most Used', 'filter', 'wp-gatsby-theme' ),
				'back_to_items'              => __( '&larr; Back to Filters', 'wp-gatsby-theme' ),
			),
			'show_in_rest'          => true,
			'rest_base'             => 'filters',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		)
	);
}
add_action( 'init', 'filter_init', 20 );

/**
 * Sets the post updated messages for the `filter` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `filter` taxonomy.
 */
function filter_updated_messages( $messages ) {
	$messages['filter'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Filter added.', 'wp-gatsby-theme' ),
		2 => __( 'Filter deleted.', 'wp-gatsby-theme' ),
		3 => __( 'Filter updated.', 'wp-gatsby-theme' ),
		4 => __( 'Filter not added.', 'wp-gatsby-theme' ),
		5 => __( 'Filter not updated.', 'wp-gatsby-theme' ),
		6 => __( 'Filters deleted.', 'wp-gatsby-theme' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'filter_updated_messages' );
