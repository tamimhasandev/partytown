<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add settings page to WordPress admin.
add_action( 'admin_menu', function() {
    add_options_page(
        'PartyTown Settings', // Page title
        'PartyTown',          // Menu title
        'manage_options',     // Capability required
        'partytown',          // Menu slug
        'partytown_settings_page' // Function to display the settings page
    );
} );

// Display the settings page content.
function partytown_settings_page() {
    ?>
<div class="wrap">
    <h1><?php esc_html_e( 'PartyTown Settings', 'partytown' ); ?></h1>

    <form method="post" action="options.php">
        <?php
                settings_fields( 'partytown_options_group' );
                do_settings_sections( 'partytown' );
                submit_button();
            ?>
    </form>

    <!-- "How to Use" Link -->
    <p><a href="https://www.tamimhasan.com/partytown-guide"
            target="_blank"><?php esc_html_e( 'How to Use PartyTown Plugin', 'partytown' ); ?></a></p>
</div>
<?php
}

// Register settings fields.
add_action( 'admin_init', function() {
    // Register setting for storing configuration options.
    register_setting( 'partytown_options_group', 'partytown_options' );

    // Add settings section.
    add_settings_section(
        'partytown_general_section',
        __( 'General Settings', 'partytown' ),
        null,
        'partytown'
    );

    // Enable Partytown toggle.
    add_settings_field(
        'enable_partytown',
        __( 'Enable PartyTown Library', 'partytown' ),
        'enable_partytown_field_callback',
        'partytown',
        'partytown_general_section'
    );

    // Add more settings as needed, e.g., custom script configuration
});

// Callback function to render the checkbox field.
function enable_partytown_field_callback() {
    // Get current option value.
    $options = get_option( 'partytown_options' );
    ?>
<input type="checkbox" name="partytown_options[enable_partytown]" value="1"
    <?php checked( 1, isset( $options['enable_partytown'] ) ? $options['enable_partytown'] : 0 ); ?> />
<label
    for="enable_partytown"><?php esc_html_e( 'Check to enable the Partytown library for offloading scripts.', 'partytown' ); ?></label>
<?php
}