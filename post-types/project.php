<?php

/**
 * Registers the `project` post type.
 */
function project_init() {
	register_post_type( 'project', array(
		'labels'                => array(
			'name'                  => __( 'Projects', 'wp-gatsby-theme' ),
			'singular_name'         => __( 'Project', 'wp-gatsby-theme' ),
			'all_items'             => __( 'All Projects', 'wp-gatsby-theme' ),
			'archives'              => __( 'Project Archives', 'wp-gatsby-theme' ),
			'attributes'            => __( 'Project Attributes', 'wp-gatsby-theme' ),
			'insert_into_item'      => __( 'Insert into Project', 'wp-gatsby-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Project', 'wp-gatsby-theme' ),
			'featured_image'        => _x( 'Featured Image', 'project', 'wp-gatsby-theme' ),
			'set_featured_image'    => _x( 'Set featured image', 'project', 'wp-gatsby-theme' ),
			'remove_featured_image' => _x( 'Remove featured image', 'project', 'wp-gatsby-theme' ),
			'use_featured_image'    => _x( 'Use as featured image', 'project', 'wp-gatsby-theme' ),
			'filter_items_list'     => __( 'Filter Projects list', 'wp-gatsby-theme' ),
			'items_list_navigation' => __( 'Projects list navigation', 'wp-gatsby-theme' ),
			'items_list'            => __( 'Projects list', 'wp-gatsby-theme' ),
			'new_item'              => __( 'New Project', 'wp-gatsby-theme' ),
			'add_new'               => __( 'Add New', 'wp-gatsby-theme' ),
			'add_new_item'          => __( 'Add New Project', 'wp-gatsby-theme' ),
			'edit_item'             => __( 'Edit Project', 'wp-gatsby-theme' ),
			'view_item'             => __( 'View Project', 'wp-gatsby-theme' ),
			'view_items'            => __( 'View Projects', 'wp-gatsby-theme' ),
			'search_items'          => __( 'Search Projects', 'wp-gatsby-theme' ),
			'not_found'             => __( 'No Projects found', 'wp-gatsby-theme' ),
			'not_found_in_trash'    => __( 'No Projects found in trash', 'wp-gatsby-theme' ),
			'parent_item_colon'     => __( 'Parent Project:', 'wp-gatsby-theme' ),
			'menu_name'             => __( 'Projects', 'wp-gatsby-theme' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_rest'          => true,
		'rest_base'             => 'projects',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'project_init' );

/**
 * Sets the post updated messages for the `project` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `project` post type.
 */
function project_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['project'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Project updated. <a target="_blank" href="%s">View Project</a>', 'wp-gatsby-theme' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'wp-gatsby-theme' ),
		3  => __( 'Custom field deleted.', 'wp-gatsby-theme' ),
		4  => __( 'Project updated.', 'wp-gatsby-theme' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Project restored to revision from %s', 'wp-gatsby-theme' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Project published. <a href="%s">View Project</a>', 'wp-gatsby-theme' ), esc_url( $permalink ) ),
		7  => __( 'Project saved.', 'wp-gatsby-theme' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Project submitted. <a target="_blank" href="%s">Preview Project</a>', 'wp-gatsby-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Project</a>', 'wp-gatsby-theme' ),
		date_i18n( __( 'M j, Y @ G:i', 'wp-gatsby-theme' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Project draft updated. <a target="_blank" href="%s">Preview Project</a>', 'wp-gatsby-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'project_updated_messages' );
