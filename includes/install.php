<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define helper functions.
function delete_partytown_dir( $dir ) {
    if ( ! is_dir( $dir ) ) {
        return;
    }

    $files = array_diff( scandir( $dir ), array( '.', '..' ) );

    foreach ( $files as $file ) {
        $file_path = $dir . DIRECTORY_SEPARATOR . $file;
        if ( is_dir( $file_path ) ) {
            delete_partytown_dir( $file_path );
        } else {
            unlink( $file_path );
        }
    }

    rmdir( $dir );
}

function copy_partytown_dir( $src, $dst ) {
    if ( ! is_dir( $src ) ) {
        // Log error only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'Source directory does not exist: ' . $src );
        }
        return;
    }

    if ( ! is_dir( $dst ) && ! mkdir( $dst, 0755, true ) ) {
        // Log error only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'Failed to create directory: ' . $dst );
        }
        return;
    }

    $dir = opendir( $src );
    while ( false !== ( $file = readdir( $dir ) ) ) {
        if ( ( $file != '.' ) && ( $file != '..' ) ) {
            $src_file = $src . '/' . $file;
            $dst_file = $dst . '/' . $file;
            if ( is_dir( $src_file ) ) {
                copy_partytown_dir( $src_file, $dst_file );
            } else {
                copy( $src_file, $dst_file );
            }
        }
    }
    closedir( $dir );
}

// Register activation hook.
register_activation_hook( PLUGIN_FILE_URL, function() {
    // Delete and recreate directory.
    if ( file_exists( PARTYTOWN_UPLOAD_DIR ) ) {
        delete_partytown_dir( PARTYTOWN_UPLOAD_DIR );
    }

    if ( ! mkdir( PARTYTOWN_UPLOAD_DIR, 0755, true ) && ! is_dir( PARTYTOWN_UPLOAD_DIR ) ) {
        // Log error only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'Failed to create directory: ' . PARTYTOWN_UPLOAD_DIR );
        }
        return;
    }

    // Copy files.
    $source = PARTYTOWN_PLUGIN_DIR . 'assets/partytown/';
    if ( file_exists( $source ) ) {
        copy_partytown_dir( $source, PARTYTOWN_UPLOAD_DIR );
        // Log success only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'Successfully copied files to: ' . PARTYTOWN_UPLOAD_DIR );
        }
    } else {
        // Log error only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'Source directory does not exist: ' . $source );
        }
    }
});

// Register deactivation hook.
register_deactivation_hook( PLUGIN_FILE_URL, function() {
    if ( file_exists( PARTYTOWN_UPLOAD_DIR ) ) {
        delete_partytown_dir( PARTYTOWN_UPLOAD_DIR );
    }
});