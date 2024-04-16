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
        false,
        CONFIG_ICON, // Icon for the menu item (optional)
        59                       // Position in the menu
    );

    add_submenu_page(
        'boat-configurator',  // Page title
        'Settings',  // Menu title
        'Settings',  // Menu title
        'manage_options',     // Capability required to access the menu
        'boat-configurator',  // Menu slug
        'boat_configurator_render_admin_page' // Function to render the page content
    );
    
    add_submenu_page(
        'boat-configurator',
        'Boat Configurator',
        'Boat Configurator',
        'manage_options',
        'edit.php?post_type=boat_config'
    );

    // Add submenu for Blocks Used
    // add_submenu_page(
    //     'boat-configurator',           // Parent menu slug
    //     'Blocks Used',                 // Page title
    //     'Blocks Used',                 // Menu title
    //     'manage_options',              // Capability required to access the menu
    //     'boat-configurator-blocks',    // Menu slug
    //     'boat_configurator_blocks_list_page' // Function to render the page content
    // );

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

function custom_column_for_custom_post_type( $columns ) {
    // Add a new column with a custom heading
    $columns['custom_column'] = 'Nuoroda';
    return $columns;
}
add_filter( 'manage_boat_config_posts_columns', 'custom_column_for_custom_post_type' );


function populate_custom_column_for_custom_post_type( $column_name, $post_id ) {
    if ( $column_name === 'custom_column' ) {
        // Output the data for the custom column
        $post_permalink = get_permalink($post_id);
        echo '<a href="' . esc_url($post_permalink) . '" class="copy-link">Kopijuoti nuorodą</a>';
    }
}
add_action( 'manage_boat_config_posts_custom_column', 'populate_custom_column_for_custom_post_type', 10, 2 );

function enqueue_custom_script() {

    $screen = get_current_screen();
    if ( $screen && 'boat_config' === $screen->post_type ) {
    wp_enqueue_script( 'custom-script', plugin_dir_url( __FILE__ ) . 'src/admin/custom-bc-admin-script.js', array(), '1.0', true );
    }
}
add_action( 'admin_enqueue_scripts', 'enqueue_custom_script' );


// Include the file with the form submission handling function
require_once plugin_dir_path( __FILE__ ) . 'src/front-end/form-submissions.php';
require_once plugin_dir_path( __FILE__ ) . 'src/admin/blocks-list.php';
require_once plugin_dir_path( __FILE__ ) . 'src/admin/form-entries-list.php';
require_once plugin_dir_path( __FILE__ ) . 'src/admin/key-encryption.php';
require_once plugin_dir_path( __FILE__ ) . 'src/admin/settings-page.php';
require_once plugin_dir_path( __FILE__ ) . 'src/includes/configurator/boat-config-pattern.php';
require_once plugin_dir_path( __FILE__ ) . 'src/includes/configurator/boat-config-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
