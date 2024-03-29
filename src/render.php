<?php
    $block_wrapper_attributes = get_block_wrapper_attributes();
    //wp_send_json( $block_wrapper_attributes );

    $answers = isset($attributes['answers']) ? $attributes['answers'] : array();

    $form_id = isset($attributes['question']) ? $attributes['question'] : 'boat_config_form';

?>
    
    <div <?php echo $block_wrapper_attributes; ?>>
        <h2>Custom Form Block</h2>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="<?php echo $form_id ?>" class="boat-config-form">
        <?php wp_nonce_field( 'boat_configurator_form_submit_action', 'boat_configurator_nonce_'. $form_id ); ?>
        <input type="hidden" name="action" value="handle_form_submission">
        <input type="hidden" name="form_id" value="<?php echo $form_id ?>">
        <!-- <input type="hidden" name="_wp_http_referer" value="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>"> -->
       
            <?php
                // Loop through answers and create input fields
                foreach ($answers as $index => $answer) {
                    // Generate unique input name and ID
                    $input_name = 'input_' . $index;
                    $input_id = 'input_' . $index;
            ?>
                <div>
                    <label for="<?php echo $input_id; ?>"><?php echo $answer; ?>:</label>
                    <input type="text" id="<?php echo $input_id; ?>" name="<?php echo $input_name; ?>" value="">
                </div>
            <?php
                }
            ?>
            <div>
                    <label for="email_input" style="display: block">your email:</label>
                    <input type="email" id="email-input" name="email_input" value="" style="display: block">
                </div>
            <!-- Add more form fields as needed -->
            <button type="submit" name="submit_form" id="submit_form">Submit</button>
        </form>
    </div>