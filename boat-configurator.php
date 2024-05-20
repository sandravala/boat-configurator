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
    // add_menu_page(
    //     'Laivo konfig', // Page title
    //     'Laivo konfig', // Menu title
    //     'manage_options', // Capability required to access the menu
    //     'boat-configurator', // Menu slug
    //     false,
    //     CONFIG_ICON, // Icon for the menu item (optional)
    //     59// Position in the menu
    // );

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
        // wp_enqueue_script( 'boat-config-view-form-script', lugin_dir_url( __FILE__ ) . '/src/front-end/multistep-form.js', array(), '1.0', true, array('strategy'  => 'defer', ) );
        //wp_enqueue_script( 'boat-config-view-form-script', plugin_dir_url( __FILE__ ) . '/front-end/multistep-form.js', array(), '1.0', true, array('strategy'  => 'defer', )  );
    }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_script');

// add_action('wp_ajax_fetch_bc_questions', 'fetch_bc_question_data');
// add_action('wp_ajax_nopriv_fetch_bc_questions', 'fetch_bc_question_data');

// function fetch_bc_question_data()
// {

//     if (!check_ajax_referer('bc_frontend_view_nonce', 'security')) {
//         wp_send_json_error(array('message' => 'Security check failed'));
//         return;
//     }

//     // Ensure the post ID is present
//     $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
//     if (!$post_id) {
//         wp_send_json_error(array('message' => 'Invalid post ID'));
//         return;
//     }

//     // Retrieve the post and parse its content
//     $post = get_post($post_id);
//     if (!$post) {
//         wp_send_json_error(array('message' => 'Post not found'));
//         return;
//     }

//     $blocks = parse_blocks($post->post_content);
//     $boat_configurator_block = null;

//     $boat_configurator_block = find_nested_block($blocks, 'create-block/boat-configurator');

//     if ($boat_configurator_block) {
//         $model = $boat_configurator_block['attrs']['model'] ?? 'No model provided';
//         $questions = $boat_configurator_block['attrs']['questions'] ?? [];
//         $response_data = [
//             'model' => $model,
//             'questions' => $questions,
//         ];
//         wp_send_json_success($response_data);
//     } else {
//         wp_send_json_error(['message' => 'No configurator block found']);
//     }

// }

// function find_nested_block(array $blocks, $target_block_name)
// {
//     foreach ($blocks as $block) {
//         // Check if the current block is the one we're looking for
//         if ($block['blockName'] === $target_block_name) {
//             return $block; // Return the block if it matches the target
//         }

//         // If the block has inner blocks, recursively search through them
//         if (isset($block['innerBlocks']) && !empty($block['innerBlocks'])) {
//             $found_block = find_nested_block($block['innerBlocks'], $target_block_name);
//             if ($found_block) {
//                 return $found_block; // Return the block if found in inner blocks
//             }
//         }
//     }

//     return null; // Return null if no matching block is found
// }

// Hook into the 'save_post' action
add_action('save_post', 'update_post_title_and_thumbnail', 10, 3);


function update_post_title_and_thumbnail($post_id, $post, $update) {
    // Avoid infinite loops by checking if this is an autosave or if the function was triggered by a bulk edit.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['bulk_edit'])) return;

    // Check post type and capabilities
    if ($post->post_type != 'boat_config') return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Get the post content
    $post_content = $post->post_content;

    // Extract the <h2 class="bc-title"> tag
    preg_match('/<h2[^>]*class="[^"]*bc-title[^"]*"[^>]*>(.*?)<\/h2>/', $post_content, $matches);
    if (isset($matches[1])) {
        $new_title = $matches[1];
    } else {
        // Count the number of existing boat_config posts
        $boat_config_count = wp_count_posts('boat_config')->publish;
        // Default title if no <h2> found
        $new_title = 'Model ' . ($boat_config_count + 1);
    }

    // Extract the <figure class="bc-thumbnail"> tag containing an <img> tag
    preg_match('/<figure[^>]*class="[^"]*bc-thumbnail[^"]*"[^>]*>.*?<img[^>]+src="([^">]+)".*?<\/figure>/', $post_content, $img_matches);
    if (isset($img_matches[1])) {
        $new_thumbnail_url = $img_matches[1];
    } else {
        // Default thumbnail if no <figure> found
        $new_thumbnail_url = '';
    }

    // Update the post title
    remove_action('save_post', 'update_post_title_and_thumbnail'); // Prevent infinite loop
    wp_update_post(array(
        'ID' => $post_id,
        'post_title' => $new_title,
        'post_name' => sanitize_title($new_title),
    ));
    add_action('save_post', 'update_post_title_and_thumbnail');

    // Update the post thumbnail
    if ($new_thumbnail_url) {
        // Get the attachment ID by URL
        $attachment_id = attachment_url_to_postid($new_thumbnail_url);
        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
}



function set_post_thumbnail_from_url($post_id, $image_url) {
    // Download image to media library
    $image_id = media_sideload_image($image_url, $post_id, null, 'id');
    if (!is_wp_error($image_id)) {
        // Temporarily remove the save_post action to avoid infinite loop
        remove_action('save_post', 'update_post_title_and_thumbnail', 10);

        // Set the post thumbnail
        set_post_thumbnail($post_id, $image_id);

        // Re-add the save_post action
        add_action('save_post', 'update_post_title_and_thumbnail', 10);
    }
}

// Include the file with the form submission handling function
require_once plugin_dir_path(__FILE__) . 'src/front-end/form-submissions.php';
require_once plugin_dir_path(__FILE__) . 'src/admin/blocks-list.php';
require_once plugin_dir_path(__FILE__) . 'src/admin/form-entries-list.php';
require_once plugin_dir_path(__FILE__) . 'src/admin/key-encryption.php';
require_once plugin_dir_path(__FILE__) . 'src/admin/settings-page.php';
require_once plugin_dir_path(__FILE__) . 'src/includes/configurator/boat-config-pattern.php';
require_once plugin_dir_path(__FILE__) . 'src/includes/configurator/boat-config-post-type.php';
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
