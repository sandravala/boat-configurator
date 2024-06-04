<?php

// exit if uninstall constant is not defined
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

// delete plugin options
delete_option('bc_ml_api_key');
delete_option('bc_ml_group_id');


// delete database table
global $wpdb;
$table_name = $wpdb->prefix . DB_TABLE;
$wpdb->prepare("DROP TABLE IF EXISTS %i", $table_name);

// delete custom post type posts
$myplugin_cpt_args = array('post_type' => 'boat_config', 'posts_per_page' => -1);
$myplugin_cpt_posts = get_posts($myplugin_cpt_args);
foreach ($myplugin_cpt_posts as $post) {
	wp_delete_post($post->ID, false);
}


// delete post meta
$myplugin_post_args = array('post_type' => 'boat_config', 'posts_per_page' => -1);
$myplugin_posts = get_posts($myplugin_post_args);
foreach ($myplugin_posts as $post) {
    // Retrieve all metadata for the current post
    $all_meta = get_post_meta($post->ID);

    // Loop through each metadata key and delete it
    foreach ($all_meta as $meta_key => $meta_values) {
        delete_post_meta($post->ID, $meta_key);
    }
}