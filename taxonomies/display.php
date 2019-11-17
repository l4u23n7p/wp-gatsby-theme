<?php

/**
 * Sets columns in admin for color fields.
 *
 * @param  array $columns Default columns display in admin.
 * @return array Columns for color fields.
 */
function colors_columns( $columns ) {
	$columns['color']      = __( 'Color' );
	$columns['text_color'] = __( 'Text Color' );

	return $columns;
}
add_filter( 'manage_edit-category_columns', 'colors_columns' );
add_filter( 'manage_edit-filter_columns', 'colors_columns' );
add_filter( 'manage_edit-post_tag_columns', 'colors_columns' );

/**
 * Sets columns content for color fields column.
 *
 * @param  string $taxonomy Taxonomy slug.
 * @param  string $content Default content to display.
 * @param  string $column_name Column name.
 * @param  string $term_id Term ID.
 * @return string Content to display.
 */
function colors_columns_content( $taxonomy, $content, $column_name, $term_id ) {
	$term = get_term( $term_id, $taxonomy );

	if ( 'color' == $column_name ) {
		$color   = get_field( 'color', $term );
		$content = '<div id="background-colorbox" class="background-colorbox" style="background-color: ' . $color . ';">';
	}
	if ( 'text_color' == $column_name ) {
		$text_color = get_field( 'text_color', $term );
		$content    = '<div id="text-colorbox" class="text-colorbox" style="background-color: ' . $text_color . ';">';
	}
	return $content;
}

function category_columns_content( $content, $column_name, $term_id ) {
	return colors_columns_content( 'category', $content, $column_name, $term_id );
}
add_filter( 'manage_category_custom_column', 'category_columns_content', 10, 3 );

function filter_columns_content( $content, $column_name, $term_id ) {
	return colors_columns_content( 'filter', $content, $column_name, $term_id );
}
add_filter( 'manage_filter_custom_column', 'filter_columns_content', 10, 3 );

function post_tag_columns_content( $content, $column_name, $term_id ) {
	return colors_columns_content( 'post_tag', $content, $column_name, $term_id );
}
add_filter( 'manage_post_tag_custom_column', 'post_tag_columns_content', 10, 3 );
