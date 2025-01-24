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
        // Remove the directory and its contents.
        delete_directory( $upload_dir );
    }
}

// Function to recursively delete the directory and its contents.
function delete_directory( $dir ) {
    // Get all files and directories inside.
    $files = array_diff( scandir( $dir ), ['.', '..'] );

    foreach ( $files as $file ) {
        $file_path = $dir . DIRECTORY_SEPARATOR . $file;

        if ( is_dir( $file_path ) ) {
            // Recursively delete subdirectories.
            delete_directory( $file_path );
        } else {
            // Delete the file.
            unlink( $file_path );
        }
    }

    // Finally, remove the empty directory itself.
    rmdir( $dir );
}

// Run the uninstall cleanup function.
partytown_uninstall();