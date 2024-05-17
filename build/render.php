<?php

$block_wrapper_attributes = get_block_wrapper_attributes();

$data = isset($attributes) ? $attributes : array();
$policy_url = esc_url(get_privacy_policy_url());
$data['privacyPolicy'] = $policy_url;
$data['feNonce'] = wp_create_nonce( 'bc_frontend_view_nonce' );
$data['ajaxUrl'] = admin_url('admin-ajax.php');
wp_enqueue_script('jquery');
wp_add_inline_script('create-block-boat-configurator-script', 'const bcData = ' . wp_json_encode($data) . ';', 'before');

?>

 <div <?php echo $block_wrapper_attributes; ?>>

