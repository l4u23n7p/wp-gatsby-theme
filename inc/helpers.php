<?php

function wp_gatsby_theme_add_notices($new) {
    $notices = get_option( 'wp_gatsby_theme_notices' );
    $notices[] = $new;
    update_option( 'wp_gatsby_theme_notices', $notices );
}


function wp_gatsby_theme_insert_with_markers( $filename, $marker, $insertion, $delimiter = '#', $insertbefore = false ) {
	if ( ! file_exists( $filename ) ) {
		if ( ! is_writable( dirname( $filename ) ) ) {
			return false;
		}
		if ( ! touch( $filename ) ) {
			return false;
		}
	} elseif ( ! is_writeable( $filename ) ) {
		return false;
	}

	if ( ! is_array( $insertion ) ) {
		$insertion = explode( "\n", $insertion );
	}

	$start_marker = "{$delimiter} BEGIN {$marker}";
	$end_marker   = "{$delimiter} END {$marker}";

	$fp = fopen( $filename, 'r+' );
	if ( ! $fp ) {
		return false;
	}

	// Attempt to get a lock. If the filesystem supports locking, this will block until the lock is acquired.
	flock( $fp, LOCK_EX );

	$lines = array();
	while ( ! feof( $fp ) ) {
		$lines[] = rtrim( fgets( $fp ), "\r\n" );
	}

    // Split out the existing file into the preceding lines, and those that appear after the marker
    if ( pathinfo($filename, PATHINFO_EXTENSION) == 'php' ) {
        $php_marker = array_shift($lines);
    } else {
        $php_marker = "";
    }
	$pre_lines    = $post_lines = $existing_lines = array();
	$found_marker = $found_end_marker = false;
	foreach ( $lines as $line ) {
		if ( ! $found_marker && false !== strpos( $line, $start_marker ) ) {
			$found_marker = true;
			continue;
		} elseif ( ! $found_end_marker && false !== strpos( $line, $end_marker ) ) {
			$found_end_marker = true;
			continue;
		}
		if ( ! $found_marker ) {
			$pre_lines[] = $line;
		} elseif ( $found_marker && $found_end_marker ) {
			$post_lines[] = $line;
		} else {
			$existing_lines[] = $line;
		}
	}

	// Check to see if there was a change
	if ( $existing_lines === $insertion ) {
		flock( $fp, LOCK_UN );
		fclose( $fp );

		return true;
    }
    
    if ( empty( array_filter( $insertion ) ) ) {
        $new_lines = array();
    } else {
        $new_lines = array_merge(
            array( $start_marker ),
            $insertion,
            array( $end_marker )
        );
    }

    if ( $insertbefore ) {
        $new_file_data = implode(
            "\n",
            array_merge(
                array( $php_marker ),
                $new_lines,
                $pre_lines,
                $post_lines
            )
        );
    } else {
        // Generate the new file data
        $new_file_data = implode(
            "\n",
            array_merge(
                array( $php_marker ),
                $pre_lines,
                $new_lines,
                $post_lines
            )
        );
            
    }
    // Write to the start of the file, and truncate it to that length
	fseek( $fp, 0 );
	$bytes = fwrite( $fp, $new_file_data );
	if ( $bytes ) {
		ftruncate( $fp, ftell( $fp ) );
	}
	fflush( $fp );
	flock( $fp, LOCK_UN );
	fclose( $fp );

	return (bool) $bytes;
}


function wp_gatsby_theme_update_htaccess( $rules = array() ) {
    $marker = 'wp-gatsby-theme';
    $file = ABSPATH . '.htaccess';

    if ( ! is_file( $file ) ) {
		if ( ! touch( $file ) ) {
			return new WP_Error( 'htaccess-io', 'ERROR: Unable to create the file ' . $file);
		}
	}
	elseif ( ! is_writable( $file ) ) {
		return new WP_Error( 'htaccess-io', 'ERROR: Unable to get access to the file ' . $file);
    }
    
	$result = wp_gatsby_theme_insert_with_markers( $file, $marker, $rules );

	if ( $result || $result === 0 ) {
		$result = 'The ' . $file . ' file has been updated';
	}
	else {
		$result = new WP_Error( 'htaccess-io', 'ERROR: Unable to modify the file ' . $file);
	}

	return $result;
}


function wp_gatsby_theme_update_config( $rules = array() ) {
    $marker = 'wp-gatsby-theme';
    $file = ABSPATH . 'wp-config.php';

    if ( ! is_file( $file ) ) {
		if ( ! touch( $file ) ) {
			return new WP_Error( 'wp-config-io', 'ERROR: Unable to create the file ' . $file);
		}
	}
	elseif ( ! is_writable( $file ) ) {
		return new WP_Error( 'wp-config-io', 'ERROR: Unable to get access to the file ' . $file);
    }
    
	$result = wp_gatsby_theme_insert_with_markers( $file, $marker, $rules, '//', true );

	if ( $result || $result === 0 ) {
		$result = 'The ' . $file . ' file has been updated';
	}
	else {
		$result = new WP_Error( 'wp-config-io', 'ERROR: Unable to modify the file ' . $file);
	}

	return $result;
}

/**
 * Settings Helpers
 */
function option_input_help($type, $args) {
    switch ($type) {
        case 'text':
            echo "<p>$args</p>";
            break;
        
        case 'table':
            echo "<style> .input-help td { padding: 5px;}</style>";
            echo "<h4>{$args['title']}</h4>";
            echo "<table class='input-help'>";
            foreach ($args['value'] as $key => $value) {
                echo "<tr><td><code>$key</code></td><td>=></td><td>$value</td></tr>";
            }
            echo "</table>";
            break;
        
        default:
            # code...
            break;
    }
}

function option_input_string($setting, $name, $default = null, $desc = "", $size = 40) {
    $options = get_option( $setting );
    $value = isset($options[$name]) ? $options[$name] : $default;
    echo "<input id='{$setting}_{$name}' name='{$setting}[{$name}]' type='text' value='" . $value . "' size=$size /> $desc";
}

function option_input_button($setting, $name, $action, $label, $desc = "") {
    echo "<input id='{$setting}_{$name}' name='{$setting}[{$name}]' type='button' onclick='$action()' value='$label' /> $desc";
}

function option_input_checkbox($setting, $name, $default = 0, $desc = "") {
    $options = get_option( $setting );
    $value = isset($options[$name]) ? $options[$name] : $default;
    echo "<input id='{$setting}_{$name}' name='{$setting}[{$name}]' type='checkbox' class='code' value='1' " . checked( 1, $value, false ) . " /> $desc";
}
