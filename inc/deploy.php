<?php

/**
 * Common functions
 */

function get_deploy_settings( $option = null ) {
    return wp_gatsby_theme_get_settings('wp_gatsby_theme_deploy_settings', $option );
}

function trigger_deploy( $success_msg = 'Deployment triggered !' ) {
    $hook = get_deploy_settings( 'hook' );
    
    if ( ! is_null( $hook ) ) {
        $res = wp_remote_post( $hook );
        
        if ( is_wp_error( $res ) ) {
            echo $res->get_error_message();
            $notice = array(
                'type'  =>   'error',
                'msg'   =>    $res->get_error_message()
            );
            wp_gatsby_theme_add_notices( $notice );
        } else {        
            $notice = array(
                'type'  =>   'success',
                'msg'   =>    __( $success_msg, 'wp-gatsby-theme' )
            );
            wp_gatsby_theme_add_notices( $notice );
        }
    } else {
        $notice = array(
            'type'  =>   'error',
            'msg'   =>    __( 'No deploy hook', 'wp-gatsby-theme' )
        );
        wp_gatsby_theme_add_notices( $notice );
    }
    wp_die();
}

/**
 * Auto deploy
 */

function wp_gatsby_theme_auto_deploy( $new_status, $old_status, $post ) {
    $auto = get_deploy_settings( 'auto' );
    
    if ( $auto ) {
        if( $new_status == 'publish' ) {
            trigger_deploy( 'Auto deployment triggered !');
        }
    }
}
add_action( 'transition_post_status', 'wp_gatsby_theme_auto_deploy', 10, 3 );

/**
 * Manual deploy
 */

function run_manual_deploy() {
    check_ajax_referer( 'manual-deploy', '_nonce' );
    
    trigger_deploy( 'Manual deployment triggered !' );
}
add_action( 'wp_ajax_deploy-theme', 'run_manual_deploy' );
