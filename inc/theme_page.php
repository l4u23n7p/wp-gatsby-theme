<?php

function get_page_settings( $option = null ) {
	return wp_gatsby_theme_get_settings( 'wp_gatsby_theme_page_settings', $option );
}

function acf_location_rules_types( $choices ) {
	$choices['Page']['theme_page'] = 'Theme Page';

	return $choices;
}
add_filter( 'acf/location/rule_types', 'acf_location_rules_types' );

function acf_location_rule_values_theme_page( $choices ) {
	$choices['home']  = 'Home';
	$choices['about'] = 'About';

	return $choices;
}
add_filter( 'acf/location/rule_values/theme_page', 'acf_location_rule_values_theme_page' );

function acf_location_rule_match_theme_page( $match, $rule, $options, $field_group ) {
	$selected_theme_page = get_page_settings( $rule['value'] );

	if ( $rule['operator'] == '==' ) {
		$match = ( get_the_ID() == $selected_theme_page );
	} elseif ( $rule['operator'] == '!=' ) {
		$match = ( get_the_ID() != $selected_theme_page );
	}

	return $match;
}
add_filter( 'acf/location/rule_match/theme_page', 'acf_location_rule_match_theme_page', 10, 4 );
