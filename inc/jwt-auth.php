<?php

function update_jwt_expire( $value ) {
    $jwt_expire = get_jwt_option( 'expire' );
        
    if( $jwt_expire != null ) {
        $value = time() + parse_expire_time( $jwt_expire );
    }

    return $value;
}
add_filter( 'jwt_auth_expire', 'update_jwt_expire' );

function get_jwt_option( $option ) {
    $jwt_options = get_option( 'wp_gatsby_theme_jwt_settings' );

    if ( $jwt_options && isset( $jwt_options[$option] ) ) {
        return $jwt_options[$option];
    }
    
    return null;
}
    
function parse_expire_time( $time ) {
    $units = array(
        'Y'     => YEAR_IN_SECONDS,
        'MO'    => MONTH_IN_SECONDS,
        'W'     => WEEK_IN_SECONDS,
        'D'     => DAY_IN_SECONDS,
        'H'     => HOUR_IN_SECONDS,
        'M'     => MINUTE_IN_SECONDS 
    );
    $real_time = 0;

    foreach ( $units as $key => $value ) {
        $parse_time = explode( $key, $time, 2 );

        if ( $parse_time[0] == $time ) {
            continue;
        }
        
        $real_time += intval( $parse_time[0] ) * $value;
        $time = $parse_time[1];
    }

    return $real_time;
}