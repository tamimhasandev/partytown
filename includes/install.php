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

    // Initialize the WP_Filesystem object
    global $wp_filesystem;
    if ( ! is_object( $wp_filesystem ) ) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }

    foreach ( $files as $file ) {
        $file_path = $dir . DIRECTORY_SEPARATOR . $file;
        if ( is_dir( $file_path ) ) {
            delete_partytown_dir( $file_path );
        } else {
            $wp_filesystem->delete( $file_path ); // Using WP_Filesystem to delete the file
        }
    }

    // Use WP_Filesystem to delete the directory
    $wp_filesystem->rmdir( $dir ); // Using WP_Filesystem to remove the directory
}

function copy_partytown_dir( $src, $dst ) {
    if ( ! is_dir( $src ) ) {
        // Log error only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

        }
        return;
    }

    // Initialize the WP_Filesystem object
    global $wp_filesystem;
    if ( ! is_object( $wp_filesystem ) ) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }

    if ( ! is_dir( $dst ) && ! $wp_filesystem->mkdir( $dst, 0755 ) ) { // Using WP_Filesystem to create the directory
        // Log error only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
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
                $wp_filesystem->copy( $src_file, $dst_file ); // Using WP_Filesystem to copy files
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

    // Initialize the WP_Filesystem object
    global $wp_filesystem;
    if ( ! is_object( $wp_filesystem ) ) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }

    if ( ! is_dir( PARTYTOWN_UPLOAD_DIR ) && ! $wp_filesystem->mkdir( PARTYTOWN_UPLOAD_DIR, 0755 ) ) { // Using WP_Filesystem to create the directory
        // Log error only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        }
        return;
    }

    // Copy files.
    $source = PARTYTOWN_PLUGIN_DIR . 'assets/partytown/';
    if ( file_exists( $source ) ) {
        copy_partytown_dir( $source, PARTYTOWN_UPLOAD_DIR );
        // Log success only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        }
    } else {
        // Log error only if WP_DEBUG is true
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        }
    }
});

// Register deactivation hook.
register_deactivation_hook( PLUGIN_FILE_URL, function() {
    if ( file_exists( PARTYTOWN_UPLOAD_DIR ) ) {
        delete_partytown_dir( PARTYTOWN_UPLOAD_DIR );
    }
});