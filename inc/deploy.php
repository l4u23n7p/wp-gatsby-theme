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

/**
 * CRON deploy
 */

function custom_cron_recurrence( $schedules ) {
    if ( !isset( $schedules['twicehourly'] ) ) {
        $schedules['twicehourly'] = array(
            'interval' => 30 * MINUTE_IN_SECONDS,
            'display' => __( 'Twice Hourly' )
        );
    }
    if ( !isset( $schedules['weekly'] ) ) {
        $schedules['weekly'] = array(
            'interval' => WEEK_IN_SECONDS,
            'display' => __( 'Once Weekly' )
        );
    }

    return $schedules;
}
add_filter( 'cron_schedules', 'custom_cron_recurrence' );

// add cron hook
add_action( 'wp_gatsby_theme_cron_deploy', 'trigger_deploy' );

function register_cron_deploy() {
   
    $interval = get_deploy_settings( 'cron' );
    
    if ( is_null( $interval ) || $interval == 'disable' ) {
        return;
    }
    
    if ( ! wp_next_scheduled( 'wp_gatsby_theme_cron_deploy' ) ) {
        wp_schedule_event( time(), $interval, 'wp_gatsby_theme_cron_deploy' );
    }
}

function unregister_cron_deploy() {

    $timestamp = wp_next_scheduled( 'wp_gatsby_theme_cron_deploy' );

    if ( $timestamp ) {
        wp_unschedule_event( $timestamp, 'wp_gatsby_theme_cron_deploy' );
    }
 }

function update_cron_deploy() {
    if ( get_option( 'update_deploy_cron', false ) ) {
        unregister_cron_deploy();
        register_cron_deploy();
        update_option( 'update_deploy_cron', false );
    }
}
add_action( 'update_option_wp_gatsby_theme_deploy_settings', 'update_cron_deploy' );
