<?php

function add_theme_settings_page() {
    add_theme_page( __( 'Settings Page' ), __( 'Settings' ), 'manage_options', 'theme-settings', 'theme_settings_page' );
}
add_action( 'admin_menu', 'add_theme_settings_page' );

function theme_settings_page() {
    include( 'settings_page.php' );
}

function plugin_admin_init() {

    // Page settings
    register_setting(
        'theme-settings',
        'wp_gatsby_theme_page_settings',
        array(
            'sanitize_callback' => 'page_options_validate'
        )
    );

    add_settings_section( 'wp_gatsby_theme_page_settings_section', 'Page Settings', 'page_settings_text', 'theme-settings' );

    add_settings_field( 'wp_gatsby_theme_page_home', 'Home page', 'wp_gatsby_theme_page_home_callback', 'theme-settings', 'wp_gatsby_theme_page_settings_section' );

    add_settings_field( 'wp_gatsby_theme_page_about', 'About page', 'wp_gatsby_theme_page_about_callback', 'theme-settings', 'wp_gatsby_theme_page_settings_section' );

    // Deploy settings
    register_setting(
        'theme-settings',
        'wp_gatsby_theme_deploy_settings',
        array(
            'sanitize_callback' => 'deploy_options_validate'
        )
    );
    
    add_settings_section( 'wp_gatsby_theme_deploy_settings_section', 'Deploy Settings', 'deploy_settings_text', 'theme-settings' );

    add_settings_field( 'wp_gatsby_theme_deploy_hook', 'Site Deploy Hook', 'wp_gatsby_theme_deploy_hook_callback', 'theme-settings', 'wp_gatsby_theme_deploy_settings_section' );
    
    add_settings_field( 'wp_gatsby_theme_deploy_status_image', 'Site Status Image', 'wp_gatsby_theme_deploy_status_image_callback', 'theme-settings', 'wp_gatsby_theme_deploy_settings_section' );
    
    add_settings_field( 'wp_gatsby_theme_deploy_status_link', 'Site Status Link', 'wp_gatsby_theme_deploy_status_link_callback', 'theme-settings', 'wp_gatsby_theme_deploy_settings_section' );

    add_settings_field( 'wp_gatsby_theme_deploy_auto', 'Auto Deploy', 'wp_gatsby_theme_deploy_auto_callback', 'theme-settings', 'wp_gatsby_theme_deploy_settings_section' );
    
    add_settings_field( 'wp_gatsby_theme_deploy_manual', 'Manual Deploy', 'wp_gatsby_theme_deploy_manual_callback', 'theme-settings', 'wp_gatsby_theme_deploy_settings_section' );
    
    add_settings_field( 'wp_gatsby_theme_deploy_cron', 'CRON Deploy', 'wp_gatsby_theme_deploy_cron_callback', 'theme-settings', 'wp_gatsby_theme_deploy_settings_section' );
    
    // JWT Auth settings
    register_setting(
        'theme-settings',
        'wp_gatsby_theme_jwt_settings',
        array(
            'sanitize_callback' => 'jwt_options_validate'
        )
    );
    
    add_settings_section( 'wp_gatsby_theme_jwt_settings_section', 'JWT Auth Settings', 'jwt_settings_text', 'theme-settings' );

    add_settings_field( 'wp_gatsby_theme_jwt_expire', 'Token Expire Time', 'wp_gatsby_theme_jwt_expire_callback', 'theme-settings', 'wp_gatsby_theme_jwt_settings_section' );
}
add_action( 'admin_init', 'plugin_admin_init' );

/**
 * Section text
 */
function page_settings_text() {
    echo '<p>Special page used by theme</p>';
}

function deploy_settings_text() {
    echo '<p>Custom the way the theme is deploy with Gatsby.</p>';
}

function jwt_settings_text() {
    echo '<p>WP JWT Auth settings.</p>';
}

/**
 * Settings Field callback
 */
function wp_gatsby_theme_page_home_callback() {
    $choices = array(
        '' => ''
    );
    $pages = get_pages();
	foreach ( $pages as $page ) {
        $choices[$page->ID] = $page->post_title;
	}
    settings_input_select( 'wp_gatsby_theme_page_settings', 'home', $choices, '' );
}

function wp_gatsby_theme_page_about_callback() {
    $choices = array(
        '' => ''
    );
    $pages = get_pages();
	foreach ($pages as $page) {
        $choices[$page->ID] = $page->post_title;
	}
    settings_input_select( 'wp_gatsby_theme_page_settings', 'about', $choices, '' );
}

function wp_gatsby_theme_deploy_manual_callback() {
    settings_input_button( 'wp_gatsby_theme_deploy_settings', 'manual', 'trigger_manual_deploy', 'Deploy' );
}

function wp_gatsby_theme_deploy_auto_callback() {
    settings_input_checkbox( 'wp_gatsby_theme_deploy_settings', 'auto', 0, 'Check to enable auto deploy on post publication (page, article, project, ...)' );
}

function wp_gatsby_theme_deploy_cron_callback() {
    $choices = array(
        'disable' => 'Disable'
    );
    $schedules = wp_get_schedules(  );
    uasort($schedules, 'sort_schedules');
	foreach ($schedules as $key => $schedule) {
        $choices[$key] = $schedule['display'];
	}
    settings_input_select( 'wp_gatsby_theme_deploy_settings', 'cron', $choices, 'disable' );
}

function sort_schedules($a, $b) {
    $interval_a = $a['interval'];
    $interval_b = $b['interval'];

    if ( $interval_a > $interval_b) {
        return 1;
    } elseif ($interval_a < $interval_b) {
        return -1;
    } else {
        return 0;
    }
}

function wp_gatsby_theme_deploy_hook_callback() {
    settings_input_string( 'wp_gatsby_theme_deploy_settings', 'hook', null, '', 80 );
}

function wp_gatsby_theme_deploy_status_image_callback() {
    settings_input_string( 'wp_gatsby_theme_deploy_settings', 'status_image', null, '', 80 );
}

function wp_gatsby_theme_deploy_status_link_callback() {
    settings_input_string( 'wp_gatsby_theme_deploy_settings', 'status_link', null, '', 80 );
}

function wp_gatsby_theme_jwt_expire_callback() {
    settings_input_string( 'wp_gatsby_theme_jwt_settings', 'expire', '7D', 'Time in seconds' );
    settings_input_help(
        'table',
        array(
            'title' => 'Time Helpers Constant',
            'value' => array(
                'M'     => 'Minute',
                'H'     => 'Hour',
                'D'     => 'Day',
                'W'     => 'Week',
                'MO'    => 'Month',
                'Y'     => 'Year'
            )
        )
    );
    settings_input_help( 'text', 'Helpers Constant must be use from largest to smallest value' );
}

/**
 * Settings Sanitize callback
 */
function page_options_validate( $options ) {
    $options['home'] = intval( $options['home'] );
    $options['about'] = intval( $options['about'] );
    
    return $options;
}

function jwt_options_validate( $options ) {
    $expire = trim( $options['expire'] );
    if( !preg_match( '/^(\d+Y)?(\d+MO)?(\d+W)?(\d+D)?(\d+H)?(\d+M)?(\d+)?$/', $expire ) ) {
        add_settings_error( 'wp_gatsby_theme_messages', 'wp_gatsby_theme_settings_error_jwt_expire', __( 'JWT Expire Time value is invalid', 'wp-gatsby-theme' ), 'error' );
        $options['expire'] = null;
    }

    return $options;
}

function deploy_options_validate( $options ) {
    $options['auto'] = intval( $options['auto'] );

    $options['hook'] = validate_url( trim( $options['hook'] ), 'Deploy Hook value is invalid' );
    $options['status_image'] = validate_url( trim( $options['status_image'] ), 'Status Image value is invalid', null, true );
    $options['status_link'] = validate_url( trim( $options['status_link'] ), 'Status Link value is invalid', null, true );

    if ( $option['cron'] !== get_deploy_settings( 'cron' ) ) {
        update_option( 'update_deploy_cron', true );
    }

    return $options;
}

function validate_url($value, $error, $default = null, $nullable = false) {

    if( $nullable ) {
        if( $value == '' ) {
            return $default;
        }
    }

    if( !filter_var( $value, FILTER_VALIDATE_URL ) ) {
        add_settings_error( 'wp_gatsby_theme_messages', 'wp_gatsby_theme_settings_error', __( $error, 'wp-gatsby-theme' ), 'error' );
        $value = $default;
    }

    return $value;
}
