<?php

//add_action( 'admin_post_nopriv_boat_configurator_submit_api_key', 'boat_configurator_submit_api_key' );
add_action('admin_post_boat_configurator_submit_settings', 'boat_configurator_submit_settings');
add_action('admin_post_boat_config_export_data', 'boat_config_export_data');
add_action('admin_post_boat_config_import_data', 'boat_config_import_data');


// Submit functionality
function boat_configurator_submit_settings(){

    // Make sure user actually has the capability to edit the options
    if (!current_user_can('edit_theme_options')) {
        wp_die("You do not have permission to view this page.");
    }

    // pass in the nonce ID from our form's nonce field - if the nonce fails this will kill script
    check_admin_referer('boat_config_api_options_verify');

    if (isset($_POST['bc_ml_api_key'])) {

        $data_encryption = new BC_Data_Encryption();
        $submitted_api_key = sanitize_text_field($_POST['bc_ml_api_key']);

        $api_key = $data_encryption->encrypt($submitted_api_key);

        $api_exists = get_option('bc_ml_api_key');
        $decrypted_api = $data_encryption->decrypt(get_option('bc_ml_api_key'));

        if (!empty($api_key) && !empty($api_exists)) {
            update_option('bc_ml_api_key', $api_key);
        } else {
            add_option('bc_ml_api_key', $api_key);
        }
    }

    if (isset($_POST['bc_ml_group_id'])) {

        $data_encryption = new BC_Data_Encryption();
        $submitted_group_id = sanitize_text_field($_POST['bc_ml_group_id']);

        $group_id = $data_encryption->encrypt($submitted_group_id);

        $group_exists = get_option('bc_ml_group_id');
        $decrypted_group = $data_encryption->decrypt(get_option('bc_ml_group_id'));

        if (!empty($group_id) && !empty($group_exists)) {
            update_option('bc_ml_group_id', $group_id);
        } else {
            add_option('bc_ml_group_id', $group_id);
        }
    }

    if (isset($_POST['bc_ntf_email'])) {

        $submitted_email = sanitize_email($_POST['bc_ntf_email']);

        $email_exists = get_option('bc_ntf_email');

        if (!empty($submitted_email) && !empty($email_exists)) {
            update_option('bc_email_ntf', $submitted_email);
        } else {
            add_option('bc_email_ntf', $submitted_email);
        }
    }

    // Redirect to same page with status=1 to show our options updated banner
    wp_redirect($_SERVER['HTTP_REFERER'] . '&ml_status=1');
}

// Export function
function boat_config_export_data() {
    // Check if the current user has the required capabilities
    if (!current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have sufficient permissions to access this page.'));
    }

    // Your export functionality here
    // Fetch data to export (e.g., from database tables or options)
    $export_data = array();

    // Export custom post type posts
    $args = array(
        'post_type' => 'boat_config',
        'posts_per_page' => -1, // Retrieve all posts
        // Add any additional query parameters as needed
    );

    $custom_posts = get_posts($args);

    $export_data['custom_posts'] = array();

    foreach ($custom_posts as $post) {
        // Get all post data
        $post_data = (array) $post;

        // Sanitize post data
        foreach ($post_data as $key => $value) {
            $post_data[$key] = sanitize_text_field($value);
        }

        // Get post meta data
        $post_meta = get_post_meta($post->ID);
        foreach ($post_meta as $meta_key => $meta_value) {
            $post_meta[$meta_key] = sanitize_text_field($meta_value[0]);
        }
        $post_data['meta'] = $post_meta;

        // Get taxonomy terms
        $taxonomy_terms = array();
        $taxonomies = get_object_taxonomies($post->post_type);
        foreach ($taxonomies as $taxonomy) {
            $terms = wp_get_post_terms($post->ID, $taxonomy);
            foreach ($terms as $term) {
                $taxonomy_terms[$taxonomy][] = sanitize_text_field($term->name);
            }
        }
        $post_data['taxonomy_terms'] = $taxonomy_terms;

        // Get featured image URL
        $featured_image_url = get_the_post_thumbnail_url($post->ID, 'full');
        $post_data['featured_image_url'] = esc_url_raw($featured_image_url);

        // Add the post data to the export data
        $export_data['custom_posts'][] = $post_data;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE;

    // phpcs:disable
    $custom_table_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name"), ARRAY_A); //db call ok; no-cache ok
    // phpcs:enable

    foreach ($custom_table_data as &$entry) {
        $entry['answers'] = wp_json_encode(maybe_unserialize($entry['answers']));
        foreach ($entry as $key => $value) {
            $entry[$key] = sanitize_text_field($value);
        }
    }
    unset($entry);

    $export_data['custom_table'] = $custom_table_data;

    // Serialize the data (e.g., to JSON)
    $export_json = wp_json_encode($export_data);

    $file_name = 'bc_' . gmdate('Y-m-d_H-i') . '.json';

    // Set headers for file download
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');

    // Output the serialized data
    echo $export_json;

    // Don't forget to exit to prevent further output
    exit;
}


// Import function
function boat_config_import_data() {
    // Check if the current user has the required capabilities
    if (!current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have sufficient permissions to access this page.'));
    }

    // Check if the form was submitted
    if (isset($_POST['action']) && $_POST['action'] === 'boat_config_import_data') {
        // Verify the nonce
        if (isset($_POST['boat_config_import_nonce']) && wp_verify_nonce($_POST['boat_config_import_nonce'], 'boat_config_import_nonce')) {
            // Check if a file was uploaded
            if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
                $file_path = $_FILES['import_file']['tmp_name'];

                // Log file path and status
                error_log('Import file uploaded successfully. Path: ' . $file_path);

                // Process the uploaded file (parse, validate, import data)
                $status = import_custom_posts_from_file($file_path);
                
                // Log the status
                error_log('Import status: ' . $status);
                
                // Display a success message
                wp_redirect($_SERVER['HTTP_REFERER'] . '&ie_status=' . $status);
                exit;
            } else {
                // Handle file upload error
                error_log('File upload error: ' . $_FILES['import_file']['error']);
                wp_redirect($_SERVER['HTTP_REFERER'] . '&ie_status=-1');
                exit;
            }
        } else {
            // Nonce verification failed
            error_log('Nonce verification failed.');
            wp_redirect($_SERVER['HTTP_REFERER'] . '&ie_status=-2');
            exit;
        }
    }
}


function import_custom_posts_from_file($file_path) {
    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE;

    // Attempt to read the file contents
    $file_contents = file_get_contents($file_path);
    if ($file_contents === false) {
        error_log('Failed to read file contents.');
        return 1;
    }

    // Decode the JSON data
    $export_data = json_decode($file_contents, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('JSON decode error: ' . json_last_error_msg());
        return 1;
    }

    if (!$export_data) {
        // Invalid or empty export data
        error_log('Invalid or empty export data');
        return 1;
    }

    // Log the data structure for debugging
    error_log('Export data: ' . print_r($export_data, true));

    // Import custom posts
    if (isset($export_data['custom_posts'])) {
        foreach ($export_data['custom_posts'] as $post_data) {
            $post_id = $post_data['ID'];

            // Check if post with the same ID already exists
            if (get_post($post_id)) {
                // Post already exists, skip to next post
                error_log("Post with ID $post_id already exists, skipping");
                continue;
            }

            $new_post_data = array(
                'post_author' => $post_data['post_author'],
                'post_content' => $post_data['post_content'],
                'post_content_filtered' => $post_data['post_content_filtered'],
                'post_title' => $post_data['post_title'],
                'post_excerpt' => $post_data['post_excerpt'],
                'post_status' => $post_data['post_status'],
                'post_type' => $post_data['post_type'],
                'comment_status' => $post_data['comment_status'],
                'ping_status' => $post_data['ping_status'],
                'post_password' => $post_data['post_password'],
                'to_ping' => $post_data['to_ping'],
                'pinged' => $post_data['pinged'],
                'post_parent' => $post_data['post_parent'],
                'menu_order' => $post_data['menu_order'],
                'guid' => $post_data['guid'],
                'import_id' => $post_data['import_id'],
                'context' => $post_data['context'],
                'post_date' => $post_data['post_date'],
                'post_date_gmt' => $post_data['post_date_gmt'],
                'featured_image_url' => $post_data['featured_image_url']
            );

            $new_post_id = wp_insert_post($new_post_data);

            // Check if post creation was successful
            if (is_wp_error($new_post_id)) {
                error_log('Failed to insert new post: ' . $new_post_id->get_error_message());
                continue; // Skip to next post
            }

            // Assign taxonomy terms
            if (isset($post_data['taxonomy_terms']) && is_array($post_data['taxonomy_terms'])) {
                foreach ($post_data['taxonomy_terms'] as $taxonomy => $terms) {
                    wp_set_post_terms($new_post_id, wp_list_pluck($terms, 'name'), $taxonomy);
                }
            }

            // Set featured image
            if (isset($post_data['featured_image_url'])) {
                $image_url = $post_data['featured_image_url'];
                $image_id = media_sideload_image($image_url, $new_post_id, '', 'id');
                if (!is_wp_error($image_id)) {
                    set_post_thumbnail($new_post_id, $image_id);
                } else {
                    error_log('Failed to set featured image: ' . $image_id->get_error_message());
                }
            }
        }
    }

    // Import custom table data
    if (isset($export_data['custom_table'])) {
        // Check if table exists and create if not
        if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) != $table_name) {
            error_log('No custom_table found');
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
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }

        foreach ($export_data['custom_table'] as $entry) {
            // Sanitize each entry before insertion
            $sanitized_entry = array(
                'id' => intval($entry['id']),
                'post_id' => intval($entry['post_id']),
                'post_title' => sanitize_text_field($entry['post_title']),
                'answers' => maybe_serialize(json_decode($entry['answers'], true)),
                'first_name' => sanitize_text_field($entry['first_name']),
                'last_name' => sanitize_text_field($entry['last_name']),
                'email' => sanitize_email($entry['email']),
                'phone' => sanitize_text_field($entry['phone']),
                'country' => sanitize_text_field($entry['country']),
                'city' => sanitize_text_field($entry['city']),
                'zip' => sanitize_text_field($entry['zip'])
            );

            // Check if entry with the same ID exists
            $existing_entry = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $sanitized_entry['id']));

            if ($existing_entry) {
                // Entry with the same ID already exists, skip insertion
                error_log('Entry with the same ID already exists, skipping insertion');
                continue;
            }

            $format = array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            );

            $wpdb->insert($table_name, $sanitized_entry, $format);

            if (isset($entry['timestamp'])) {
                // Retrieve the ID of the inserted row
                $inserted_id = $wpdb->insert_id;

                // Convert timestamp to Unix timestamp
                $unix_timestamp = strtotime($entry['timestamp']);

                // Format Unix timestamp into MySQL-compatible datetime format
                $mysql_datetime = gmdate('Y-m-d H:i:s', $unix_timestamp);

                // Update the timestamp of the inserted row
                $wpdb->update(
                    $table_name,
                    array('timestamp' => $mysql_datetime),
                    array('id' => $inserted_id),
                    array('%s'), // Format for datetime
                    array('%d') // Format for ID
                );
            }
        }
    }

    return 0;
}



// Function to render the Boat Configurator admin page
function boat_configurator_render_admin_page() {

    // Make sure user actually has the capability to edit the options
    if (!current_user_can('edit_theme_options')) {
        wp_die("You do not have permission to view this page.");
    }

    $file_status = isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK ? 1 : null;

    // Determine the button state based on the ie_status
    $button_disabled = 'disabled';
    if ($file_status === 1) { // Assuming '1' is the success status code
        $button_disabled = '';
    }


    $data_encryption = new BC_Data_Encryption();
    $api_key = get_option('bc_ml_api_key');
    $group_id = get_option('bc_ml_group_id');
    $email_notifications = get_option('bc_email_ntf');

    if ($api_key) {
        $api_key = $data_encryption->decrypt(get_option('bc_ml_api_key'));
    }

    if ($group_id) {
        $group_id = $data_encryption->decrypt(get_option('bc_ml_group_id'));
    }

    ?>

  <div class="wrap"></div>
    <h2>Mailerlite nustatymai</h2>
        <?php


            if (!current_user_can('edit_theme_options')) {
                wp_die("You do not have permission to view this page.");
            }

        // Check if status is 1 which means a successful options save just happened

        //phpcs:disable
        if (isset($_GET['ml_status']) && $_GET['ml_status'] == 1): 
        
        //phpcs:enable
        ?>

            <div class="notice notice-success inline">
                <p>Nustatymai išsaugoti!</p>
            </div>

            <?php endif;

        ?>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">

            <!-- The nonce field is a security feature to avoid submissions from outside WP admin -->
            <?php wp_nonce_field('boat_config_api_options_verify');?>

            <div class="bc-settings-ml-form">
                <label for="bc_ml_api_key">Mailerlite API Key</label>
                <input type="password" id="bc_ml_api_key" name="bc_ml_api_key" placeholder="Įveskite Mailerlite API key" value="<?php echo $api_key ? esc_attr($api_key) : ''; ?>">
            </div>

            <div class="bc-settings-ml-form">
                <label for="bc_ml_group_id">Mailerlite Group ID</label>
                <input type="text" id="bc_ml_group_id" name="bc_ml_group_id" placeholder="Įveskite Mailerlite Group ID" value="<?php echo $group_id ? esc_attr($group_id) : ''; ?>">
            </div>


            <h2>Pranešimų nustatymai</h2>

            <div class="bc-settings-ml-form">
                    <label for="bc_ntf_email">Email</label>
                    <input type="email" id="bc_ntf_email" name="bc_ntf_email" placeholder="Įveskite el. paštą, kuriuo norite gauti pranešimus" value="<?php echo $email_notifications ? esc_attr($email_notifications) : ''; ?>">
            </div>

            <input type="hidden" name="action" value="boat_configurator_submit_settings">
            <button type="submit" name="submit_form" id="submit_form">Išsaugoti</button>
        </form>


    <h2>Importuoti / Eksportuoti duomenis</h2>
        <?php

            // Check if status is 1 which means a successful options save just happened
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            if (isset($_GET['ie_status']) && $_GET['ie_status'] == 1): ?>

                <div class="notice notice-error inline">
                    <p>Klaida importuojant duomenis. Netinkamas failo formatas arba nėra duomenų</p>
                </div>

            <?php endif;
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            if (isset($_GET['ie_status']) && $_GET['ie_status'] == -1): ?>

                <div class="notice notice-error inline">
                    <p>Klaida: įkelkite tinkamą failą!</p>
                </div>

            <?php endif;
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            if (isset($_GET['ie_status']) && $_GET['ie_status'] == -2): ?>

                <div class="notice notice-error inline">
                    <p>Jums nepriskirta teisė atlikti keitimus</p>
                </div>

            <?php endif;
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            if (isset($_GET['ie_status']) && $_GET['ie_status'] == 0): ?>

                <div class="notice notice-success inline">
                    <p>Duomenys importuoti!</p>
                </div>

            <?php endif;
            
            ?>

            <div class="bc-import-export">

                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('boat_config_export_nonce', 'boat_config_export_nonce'); ?>
                    <input type="hidden" name="action" value="boat_config_export_data">
                    <button type="submit" class="button">Eksportuoti</button>
                </form>

                <div class="bc-import-export-separator"></div>

                <form enctype="multipart/form-data" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="bc-import-form">
                    <?php wp_nonce_field('boat_config_import_nonce', 'boat_config_import_nonce'); ?>
                    <input type="hidden" name="action" value="boat_config_import_data">
                    <button type="submit" class="button" <?php echo esc_attr($button_disabled); ?> id="btn_bc_import" style="width: max-content;">
                    Importuoti
                    </button>
                    <input type="file" name="import_file" id="file_upload_bc_import">
                </form>

            </div>


    
  <?php

}