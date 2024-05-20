<?php

$block_wrapper_attributes = get_block_wrapper_attributes();

$data = isset($attributes) ? $attributes : array();

$policy_url = esc_url(get_privacy_policy_url());
$data['privacyPolicy'] = $policy_url;
$data['feNonce'] = wp_create_nonce( 'bc_frontend_view_nonce' );
$data['ajaxUrl'] = admin_url('admin-ajax.php');
$data['homePage'] = get_home_url();
$data['boatConfigArchive'] = get_post_type_archive_link( 'boat_config' );
$data['postId'] = get_the_ID();
wp_enqueue_script('jquery');

// // Construct the JavaScript code to assign bcData
// $js_code = 'const bcData = ' . wp_json_encode($data) . ';';

// // Check if bcData is already defined
// $js_code .= 'if (typeof bcData !== "undefined") { bcData = ' . wp_json_encode($data) . '; }';

// // Add the JavaScript code to the specified script handle
// wp_add_inline_script('create-block-boat-configurator-script', $js_code, 'before');

wp_add_inline_script('create-block-boat-configurator-script', 'const bcData = ' . wp_json_encode($data) . ';', 'before');
// wp_send_json( $attributes );

?>

 <div <?php echo wp_kses_data($block_wrapper_attributes); ?>>

