<?php
// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Cleanup function to delete the ~partytown directory on plugin uninstall.
function partytown_uninstall() {
    $upload_dir = ABSPATH . '~partytown';

    // Check if the directory exists and delete it.
    if ( file_exists( $upload_dir ) ) {
        // Remove the directory and its contents using WP_Filesystem.
        delete_directory_with_wp_filesystem( $upload_dir );
    }
}

// Function to recursively delete the directory and its contents using WP_Filesystem.
function delete_directory_with_wp_filesystem( $dir ) {
    // Initialize the WP_Filesystem object.
    global $wp_filesystem;
    if ( ! is_object( $wp_filesystem ) ) {
        require_once ABSPATH . '/wp-admin/includes/file.php';
        WP_Filesystem();
    }

    // Get all files and directories inside.
    $files = array_diff( scandir( $dir ), [ '.', '..' ] );

    foreach ( $files as $file ) {
        $file_path = $dir . DIRECTORY_SEPARATOR . $file;

        if ( is_dir( $file_path ) ) {
            // Recursively delete subdirectories.
            delete_directory_with_wp_filesystem( $file_path );
        } else {
            // Delete the file using WP_Filesystem.
            $wp_filesystem->delete( $file_path );
        }
    }

    // Finally, remove the empty directory itself using WP_Filesystem.
    $wp_filesystem->rmdir( $dir );
}

// Run the uninstall cleanup function.
partytown_uninstall();