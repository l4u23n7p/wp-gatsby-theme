<?php
/**
 * Rest API modifications
 */


function wp_api_encode_yoast( $data, $post, $context ) {
	$yoastMeta                = array(
		'yoast_wpseo_focuskw'               => get_post_meta( $post->ID, '_yoast_wpseo_focuskw', true ),
		'yoast_wpseo_title'                 => get_post_meta( $post->ID, '_yoast_wpseo_title', true ),
		'yoast_wpseo_metadesc'              => get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ),
		'yoast_wpseo_linkdex'               => get_post_meta( $post->ID, '_yoast_wpseo_linkdex', true ),
		'yoast_wpseo_metakeywords'          => get_post_meta( $post->ID, '_yoast_wpseo_metakeywords', true ),
		'yoast_wpseo_meta-robots-noindex'   => get_post_meta( $post->ID, '_yoast_wpseo_meta-robots-noindex', true ),
		'yoast_wpseo_meta-robots-nofollow'  => get_post_meta( $post->ID, '_yoast_wpseo_meta-robots-nofollow', true ),
		'yoast_wpseo_meta-robots-adv'       => get_post_meta( $post->ID, '_yoast_wpseo_meta-robots-adv', true ),
		'yoast_wpseo_canonical'             => get_post_meta( $post->ID, '_yoast_wpseo_canonical', true ),
		'yoast_wpseo_redirect'              => get_post_meta( $post->ID, '_yoast_wpseo_redirect', true ),
		'yoast_wpseo_opengraph-title'       => get_post_meta( $post->ID, '_yoast_wpseo_opengraph-title', true ),
		'yoast_wpseo_opengraph-description' => get_post_meta( $post->ID, '_yoast_wpseo_opengraph-description', true ),
		'yoast_wpseo_opengraph-image'       => get_post_meta( $post->ID, '_yoast_wpseo_opengraph-image', true ),
		'yoast_wpseo_twitter-title'         => get_post_meta( $post->ID, '_yoast_wpseo_twitter-title', true ),
		'yoast_wpseo_twitter-description'   => get_post_meta( $post->ID, '_yoast_wpseo_twitter-description', true ),
		'yoast_wpseo_twitter-image'         => get_post_meta( $post->ID, '_yoast_wpseo_twitter-image', true ),
	);
	$data->data['yoast_meta'] = (array) $yoastMeta;
	return $data;
}
add_filter( 'rest_prepare_post', 'wp_api_encode_yoast', 10, 3 );
add_filter( 'rest_prepare_page', 'wp_api_encode_yoast', 10, 3 );
add_filter( 'rest_prepare_project', 'wp_api_encode_yoast', 10, 3 );

function wp_rest_api_alter() {
	register_rest_route(
		'wp/v2',
		'/theme-settings',
		array(
			'methods'  => 'GET',
			'callback' => 'get_theme_settings',
		)
	);

	register_rest_field(
		'post',
		'post_categories',
		array(
			'get_callback'    => 'get_post_categories',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	register_rest_field(
		'project',
		'project_filters',
		array(
			'get_callback'    => 'get_project_filters',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	register_rest_field(
		'post',
		'featured_media_url',
		array(
			'get_callback'    => 'get_post_featured_media',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	register_rest_field(
		'project',
		'featured_media_url',
		array(
			'get_callback'    => 'get_post_featured_media',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	register_rest_field(
		'post',
		'author_meta',
		array(
			'get_callback'    => 'get_author_meta',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	register_rest_field(
		'page',
		'acf_meta',
		array(
			'get_callback'    => 'get_acf_meta',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	register_rest_field(
		'project',
		'acf_meta',
		array(
			'get_callback'    => 'get_acf_meta',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}
add_action( 'rest_api_init', 'wp_rest_api_alter' );


function get_theme_settings() {
	 $settings = array();

	$settings['social'] = wp_gatsby_theme_get_settings( 'wp_gatsby_theme_social_settings' );
	$settings['page']   = wp_gatsby_theme_expand_rest_url( get_page_settings() );

	return $settings;
}

function get_post_categories( $data, $field, $request ) {
	return wp_gatsby_theme_get_terms( 'category', $data, $field, $request );
}

function get_project_filters( $data, $field, $request ) {
	return wp_gatsby_theme_get_terms( 'filter', $data, $field, $request );
}

function wp_gatsby_theme_get_terms( $taxonomy, $data, $field, $request ) {
	$formatted_terms = array();
	$terms           = get_the_terms( $data['id'], $taxonomy );
	if ( $terms ) {
		foreach ( $terms as $term ) {
			array_push(
				$formatted_terms,
				(object) array(
					'text_color' => get_field( 'text_color', $term ),
					'color'      => get_field( 'color', $term ),
					'title'      => $term->name,
					'slug'       => $term->slug,
				)
			);
		}
	}
	return $formatted_terms;
}

function get_post_featured_media( $data, $field, $request ) {
	$media_id = get_post_thumbnail_id( $data['id'] );
	if ( $media_id != '' ) {
		$featured_media = wp_get_attachment_image_src( $media_id, 'full' );
		if ( $featured_media ) {
			return $featured_media['0'];
		}
	}
	return '';
}

function get_author_meta( $data, $field, $request ) {
	$author_meta = array();
	$user_data   = get_userdata( $data['author'] );
	if ( $user_data ) {
		$display_name = $user_data->data->display_name;
		$avatar_url   = get_avatar_url( $user_data->data->ID );
		$twitter_url  = get_the_author_meta( 'twitter', $user_data->data->ID );
		$linkedin_url = get_the_author_meta( 'linkedin', $user_data->data->ID );

		$author_meta['display_name'] = $display_name;
		$author_meta['avatar_url']   = $avatar_url;
		$author_meta['twitter_url']  = $twitter_url;
		$author_meta['linkedin_url'] = $linkedin_url;
	}
	return $author_meta;
}

function get_acf_meta( $data, $field, $request ) {
	$fields = get_fields( $data['id'] );

	return $fields;
}
