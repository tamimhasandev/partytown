<?php
/**
 * Plugin Name: PartyTown
 * Plugin URI: https://www.tamimhasan.com/partytown
 * Description: A plugin to optimize third-party scripts using Partytown.
 * Version: 1.0.0
 * Author: Md Tamim Hasan
 * Author URI: https://www.tamimhasan.com
 * License: GPL2
 * Text Domain: partytown
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants.
define( 'PARTYTOWN_VERSION', '0.11.0' );
define( 'PARTYTOWN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PARTYTOWN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PARTYTOWN_UPLOAD_DIR', rtrim( ABSPATH, '/' ) . '/~partytown/' );
define( 'PLUGIN_FILE_URL', __FILE__ );

// Include plugin files.
require_once PARTYTOWN_PLUGIN_DIR . 'includes/install.php';
require_once PARTYTOWN_PLUGIN_DIR . 'includes/settings-page.php';  // Include settings page logic

// Add the partytown configuration script before the library.
add_action( 'wp_head', function() {
    $options = get_option( 'partytown_options' );

    // Only output this if PartyTown is enabled.
    if ( isset( $options['enable_partytown'] ) && $options['enable_partytown'] === '1' ) {
        ?>
<script>
partytown = {
    forward: ['dataLayer.push'],
};
</script>
<?php
    }
}, 1 ); // Priority 1 ensures it's before the main script.

// Check if PartyTown is enabled before loading the script.
add_action( 'wp_enqueue_scripts', function() {
    $options = get_option( 'partytown_options' );

    if ( ! isset( $options['enable_partytown'] ) || $options['enable_partytown'] !== '1' ) {
        return; // Do not load the script if not enabled.
    }

    $partytown_url = site_url( '/~partytown/partytown.js' );

    // Enqueue the Partytown library with a proper version parameter.
    wp_enqueue_script(
        'partytown',
        $partytown_url,
        [],
        PARTYTOWN_VERSION, // Set the version parameter from the defined constant.
        false // Load in the <head>.
    );
} );