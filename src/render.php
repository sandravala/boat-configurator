<?php
    $block_wrapper_attributes = get_block_wrapper_attributes();
    //wp_send_json( $block_wrapper_attributes );

    $questions = isset($attributes['questions']) ? $attributes['questions'] : array();

    $form_id = isset($attributes['model']) ? $attributes['model'] : 'boat_config_form';
    $thank_you_message = '';

    echo 'Thank you parameter value: ' . $_GET['thank_you'];

    if ( isset( $_GET['thank_you'] ) && $_GET['thank_you'] === '1' ) {
        echo 'Thank you message: ' . $thank_you_message; // Debugging output
        $thank_you_message = '<p>Thank you for your submission!</p>';
        echo $thank_you_message; 
    } else {

?>
    
    <div <?php echo $block_wrapper_attributes; ?>>
        <h2><?php echo $attributes['model']; ?></h2>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="<?php echo $form_id ?>" class="boat-config-form">
        <?php wp_nonce_field( 'boat_configurator_form_submit_action', 'boat_configurator_nonce_'. $form_id ); ?>
        <input type="hidden" name="action" value="handle_form_submission">
        <input type="hidden" name="form_id" value="<?php echo $form_id ?>">
        <!-- <input type="hidden" name="_wp_http_referer" value="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>"> -->
       
            <?php
                // Loop through answers and create input fields
                foreach ($questions as $index => $question) {
                    // Generate unique input name and ID
                    $input_name = 'input_' . $index;
                    $input_id = 'input_' . $index;
            ?>
                <div>
                    <label for="<?php echo $input_id; ?>"><?php echo $question; ?>:</label>
                    <input type="text" id="<?php echo $input_id; ?>" name="<?php echo $input_name; ?>" value="">
                </div>

                <!-- <div>
									<label>
										<input
											type="radio"
											name='test' // Use a unique name for each group of radio buttons
											value="small"
											id='radio1'
										/>
										<img src="https://via.placeholder.com/40x60/0bf/fff&text=A" alt="Option 1" />
									</label>
                </div> -->

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

<?php
    } // End of if statement checking 'thank_you' parameter



// cia vietoj radio card
// <div class="container">
//     <label>
//         <input
//             type="radio"
//             name={option.optionText}
//             value={option.optionText}
//             id={optionIndex}
//         />
//         <div class="card">
//             <span class="dashicons dashicons-no delete-option" onClick={() => deleteOption(questionIndex, optionIndex)}></span>

//             <div class="top-text">
//             </div>

//             <div class="img">


//                         <img
//                             src={props.attributes.imageURL || 'https://via.placeholder.com/100x100/e8e8e8/ffffff&text=add image'}
//                             alt="Option 2"
//                             style={{ cursor: 'pointer' }}
//                             onClick={open}
//                         />


//             </div>

//         </div>
//     </label>


