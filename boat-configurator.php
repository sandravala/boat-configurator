<?php
/**
 * Plugin Name:       Boat Configurator
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       boat-configurator
 *
 * @package           create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function boat_configurator_boat_configurator_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'boat_configurator_boat_configurator_block_init' );
require_once plugin_dir_path( __FILE__ ) . 'constants.php';


function boat_configurator_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE; // Replace 'your_table_name' with your actual table name

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		form_id varchar(255) NOT NULL,
		email varchar(255) NOT NULL,
		answers text NOT NULL,
		timestamp datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";

    // Include WordPress database upgrade functions
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // Execute the SQL query
    dbDelta( $sql );
}


// Hook the table creation function to plugin activation
register_activation_hook( __FILE__, 'boat_configurator_create_table' );
//add_action( 'wp_loaded','boat_configurator_create_table' );

// Add top-level menu item for Boat Configurator
function boat_configurator_add_admin_menu() {
    add_menu_page(
        'Laivo konfig',  // Page title
        'Laivo konfig',  // Menu title
        'manage_options',     // Capability required to access the menu
        'boat-configurator',  // Menu slug
        'boat_configurator_render_admin_page', // Function to render the page content
        CONFIG_ICON, // Icon for the menu item (optional)
        59                       // Position in the menu
    );

    // Add submenu for Blocks Used
    add_submenu_page(
        'boat-configurator',           // Parent menu slug
        'Blocks Used',                 // Page title
        'Blocks Used',                 // Menu title
        'manage_options',              // Capability required to access the menu
        'boat-configurator-blocks',    // Menu slug
        'boat_configurator_blocks_list_page' // Function to render the page content
    );

    // Add submenu for Form Entries
    add_submenu_page(
        'boat-configurator',           // Parent menu slug
        'Form Entries',                // Page title
        'Form Entries',                // Menu title
        'manage_options',              // Capability required to access the menu
        'boat-configurator-entries',   // Menu slug
        'boat_configurator_render_entries_page' // Function to render the page content
    );
}
add_action('admin_menu', 'boat_configurator_add_admin_menu');

// Function to render the Boat Configurator admin page
function boat_configurator_render_admin_page() {
    // Render the content of the admin page here
    echo '<div class="wrap"><h1>Boat Configurator</h1><p>Welcome to the Boat Configurator plugin!</p></div>';
}

// Function to render the Blocks Used admin page
function boat_configurator_render_blocks_page() {
    // Render the content of the Blocks Used admin page here
    echo '<div class="wrap"><h1>Blocks Used</h1><p>This is where you can see the blocks used.</p></div>';
}

// Function to render the Form Entries admin page
// function boat_configurator_render_entries_page() {
//     // Render the content of the Form Entries admin page here
//     echo '<div class="wrap"><h1>Form Entries</h1><p>This is where you can see the form entries.</p></div>';
// }


// Include the file with the form submission handling function
require_once plugin_dir_path( __FILE__ ) . 'form-submissions.php';

require_once plugin_dir_path( __FILE__ ) . 'blocks-list.php';
require_once plugin_dir_path( __FILE__ ) . 'form-entries-list.php';
require_once plugin_dir_path( __FILE__ ) . 'boat-config-pattern.php';
require_once plugin_dir_path( __FILE__ ) . 'boat-config-post-type.php';
