<?php
/**
 * wp-gatsby-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-gatsby-theme
 */

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5' ,
    array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    )
);

function post_published_notification( $ID, $post ) {
    $option = get_option( 'wp_gatsby_theme_deploy_settings' );
    
    if ( $option && isset( $option['hook'] ) && $option['hook'] != null && isset( $option['auto'] ) && $option['auto'] == 1 ) {
        wp_remote_post( $option['hook'] );
    }
}
add_action( 'publish_post', 'post_published_notification', 10, 2 );
add_action( 'publish_project', 'post_published_notification', 10, 2 );

// Fonction pour modifier l'adresse email de l'expéditeur
function wpm_email_from( $original_email_address ) {
    $domain_name = substr( strrchr( $original_email_address, "@" ), 1 );
    return 'no-reply@' . $domain_name;
}
add_filter( 'wp_mail_from', 'wpm_email_from' );

// Fonction pour changer le nom de l'expéditeur de l'email
function wpm_expediteur( $original_email_from ) {
    return 'API Portfolio';
}
add_filter( 'wp_mail_from_name', 'wpm_expediteur' );

function activate_wp_gatsby_theme() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if( is_plugin_active( 'jwt-authentication-for-wp-rest-api/jwt-auth.php' ) ) {
        activate_jwt_auth();
    }
}
add_action( 'after_switch_theme', 'activate_wp_gatsby_theme' );

function deactivate_wp_gatsby_theme() {
    delete_option( 'wp_gatsby_theme_deploy_settings' );
    delete_option( 'wp_gatsby_theme_jwt_settings' );

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if( is_plugin_active( 'jwt-authentication-for-wp-rest-api/jwt-auth.php' ) ) {
        deactivate_jwt_auth();
    }
}
add_action( 'switch_theme', 'deactivate_wp_gatsby_theme' );

function activate_jwt_auth() {
    $htaccess = array(
        '<IfModule mod_rewrite.c>',
        'RewriteEngine on',
        'RewriteCond %{HTTP:Authorization} ^(.*)',
        'RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]',
        '</IfModule>'
    );

    $htaccess_status = wp_gatsby_theme_update_htaccess($htaccess);

    $secret_key = bin2hex( random_bytes( 32 ) );
    $wp_config = array(
        "/* JWT Auth settings for wp-gatsby-theme. */ ",
        "define( 'JWT_AUTH_SECRET_KEY', '$secret_key' );",
        "define( 'JWT_AUTH_CORS_ENABLE', false );"
    );

    $wp_config_status = wp_gatsby_theme_update_config($wp_config);
    
    if( is_wp_error( $wp_config_status )) {
        $wp_config_type = 'error';
    } else {
        $wp_config_type = 'success';
    }

    wp_gatsby_theme_add_notices( 
        array(
        'type' => $wp_config_type,
        'msg' => $wp_config_status
        ) 
    );
    
    if( is_wp_error( $htaccess_status )) {
        $htaccess_type = 'error';
    } else {
        $htaccess_type = 'success';
    }
    
    wp_gatsby_theme_add_notices( 
        array(
        'type' => $htaccess_type,
        'msg' => $htaccess_status
        ) 
    );
}
register_activation_hook( 'jwt-authentication-for-wp-rest-api/jwt-auth.php', 'activate_jwt_auth' );

function deactivate_jwt_auth() {
    $htaccess_status = wp_gatsby_theme_update_htaccess();
    $wp_config_status = wp_gatsby_theme_update_config();

    if( is_wp_error( $wp_config_status )) {
        $wp_config_type = 'error';
    } else {
        $wp_config_type = 'success';
    }

    wp_gatsby_theme_add_notices( 
        array(
        'type' => $wp_config_type,
        'msg' => $wp_config_status
        ) 
    );
    
    if( is_wp_error( $htaccess_status )) {
        $htaccess_type = 'error';
    } else {
        $htaccess_type = 'success';
    }
    
    wp_gatsby_theme_add_notices( 
        array(
        'type' => $htaccess_type,
        'msg' => $htaccess_status
        ) 
    );
}
register_deactivation_hook( 'jwt-authentication-for-wp-rest-api/jwt-auth.php', 'deactivate_jwt_auth' );

function wp_gatsby_theme_admin_notices() {
    if ( $notices= get_option( 'wp_gatsby_theme_notices' ) ) {
        foreach ( $notices as $notice ) {
            $class = "notice notice-{$notice['type']} is-dismissible";
            $message = __( $notice['msg'], 'wp-gatsby-theme' );
            
            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
        }
        delete_option( 'wp_gatsby_theme_notices' );
    }
}
add_action( 'admin_notices', 'wp_gatsby_theme_admin_notices' );

// Load custom post types
require get_template_directory() . '/post-types/project.php';

// Load custom taxonomies
require get_template_directory() . '/taxonomies/filter.php';

// Load custom fields
require get_template_directory() . '/custom-fields/project.php';
require get_template_directory() . '/custom-fields/taxonomies.php';

// Load Rest API changes
require get_template_directory() . '/inc/api-changes.php';

// Laod Options page
require get_template_directory() . '/inc/options.php';

// Load JWT Auth configuration
require get_template_directory() . '/inc/jwt-auth.php';

// Load helpers function
require get_template_directory() . '/inc/helpers.php';