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

wp_add_inline_script('create-block-boat-configurator-view-script', 'const bcData = ' . wp_json_encode($data) . ';', 'before');

?>

 <div <?php echo wp_kses_data($block_wrapper_attributes); ?>>

