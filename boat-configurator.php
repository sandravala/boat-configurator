<?php
/**
 * Plugin Name:       Boat Configurator
 * Description:       Boat Configurator for Hendrixon
 * Requires at least: 6.2
 * Requires PHP:      7.0
 * Version:           1.1.0
 * Author:            Sandra Valavičiūtė
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       boat-configurator
 *
 * @package           create-block
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function boat_configurator_boat_configurator_block_init()
{
    register_block_type(__DIR__ . '/build');
}
add_action('init', 'boat_configurator_boat_configurator_block_init');
require_once plugin_dir_path(__FILE__) . 'constants.php';

function boat_configurator_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE; 

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		post_id varchar(255) NOT NULL,
        post_title varchar(255) NOT NULL,
		first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NULL,
        country VARCHAR(255) NOT NULL,
        city VARCHAR(255) NOT NULL,
        zip VARCHAR(20) NOT NULL,
		answers text NOT NULL,
		timestamp datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";

    // Include WordPress database upgrade functions
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Execute the SQL query
    dbDelta($sql);
}

// Hook the table creation function to plugin activation
register_activation_hook(__FILE__, 'boat_configurator_create_table');
//add_action( 'wp_loaded','boat_configurator_create_table' );

// Add top-level menu item for Boat Configurator
function boat_configurator_add_admin_menu()
{
    add_submenu_page(
        'edit.php?post_type=boat_config', // Page title
        'Nustatymai', // Menu title
        'Nustatymai', // Menu title
        'manage_options', // Capability required to access the menu
        'boat-configurator', // Menu slug
        'boat_configurator_render_admin_page' // Function to render the page content
    );

    // Add submenu for Form Entries
    add_submenu_page(
        'edit.php?post_type=boat_config', // Parent menu slug
        'Išsaugotos konfigūracijos', // Page title
        'Išsaugotos konfigūracijos', // Menu title
        'manage_options', // Capability required to access the menu
        'boat-configurator-entries', // Menu slug
        'boat_configurator_render_entries_page' // Function to render the page content
    );
}
add_action('admin_menu', 'boat_configurator_add_admin_menu');

function custom_column_for_custom_post_type($columns) {
    // Add a new column with a custom heading
    $columns['custom_column'] = 'Nuoroda';
    return $columns;
}
add_filter('manage_boat_config_posts_columns', 'custom_column_for_custom_post_type');

function populate_custom_column_for_custom_post_type($column_name, $post_id) {
    if ($column_name === 'custom_column') {
        // Output the data for the custom column
        $post_permalink = get_permalink($post_id);
        echo '<a href="' . esc_url($post_permalink) . '" class="copy-link">Kopijuoti nuorodą</a>';
    }
}
add_action('manage_boat_config_posts_custom_column', 'populate_custom_column_for_custom_post_type', 10, 2);

function enqueue_custom_script() {

    $screen = get_current_screen();
    if ($screen && 'boat_config' === $screen->post_type) {
        wp_enqueue_script('custom-script', plugin_dir_url(__FILE__) . 'src/admin/custom-bc-admin-script.js', array(), '1.0', true);
        wp_enqueue_style('custom-style', plugin_dir_url(__FILE__) . 'src/admin/custom-bc-admin-style.css', array(), '1.0', 'all');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_script');

// Include the file with the form submission handling function
require_once plugin_dir_path(__FILE__) . 'src/front-end/form-submissions.php';
require_once plugin_dir_path(__FILE__) . 'src/admin/form-entries-list.php';
require_once plugin_dir_path(__FILE__) . 'src/admin/key-encryption.php';
require_once plugin_dir_path(__FILE__) . 'src/admin/settings-page.php';
require_once plugin_dir_path(__FILE__) . 'src/includes/configurator/boat-config-pattern.php';
require_once plugin_dir_path(__FILE__) . 'src/includes/configurator/boat-config-post-type.php';
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
