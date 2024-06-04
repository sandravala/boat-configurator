<?php

// Add nonce field to post edit form
function bc_add_nonce_field() {
    wp_nonce_field( 'bc_set_post_img_title', 'bc_update_post_plugin_nonce' );
}
add_action( 'edit_form_after_title', 'bc_add_nonce_field' );

// Hook into the 'save_post' action
add_action('save_post', 'update_post_title_and_thumbnail', 10, 3);

function update_post_title_and_thumbnail($post_id, $post, $update) {
    
        // Log the entire $_POST array to check its content
        
        error_log(print_r($_REQUEST, true));

    //Nonce verification
    // if ( ! isset( $_POST['bc_update_post_plugin_nonce'] ) || ! wp_verify_nonce( $_POST['bc_update_post_plugin_nonce'], 'bc_set_post_img_title' ) ) {
    //     error_log('Nonce verification failed');
    //     return;
    // }
   
    // Avoid infinite loops by checking if this is an autosave or if the function was triggered by a bulk edit.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['bulk_edit'])) return;

    // Check post type and capabilities
    //if ($post->post_type != 'boat_config') return;
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
        //$attachment_id = wp_insert_attachment( $attachment, $filename, $post_id );
        $attachment_id = attachment_url_to_postid($new_thumbnail_url);
        //set_post_thumbnail_from_url($post_id, $new_thumbnail_url);
        
        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
        } else {
            error_log('Attachment ID not found for URL: ' . $new_thumbnail_url);
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

