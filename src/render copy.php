<?php


$bc_fe_nonce = wp_create_nonce( 'bc_frontend_view_nonce' );
wp_localize_script(
	'create-block-boat-configurator-view-script',
	'bc_fe_ajax_data',
	array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'security'    => $bc_fe_nonce,
        'post_id' => get_the_ID()
	)
);

//wp_send_json( $bc_fe_nonce );







// $block_wrapper_attributes = get_block_wrapper_attributes();
// //wp_send_json( $block_wrapper_attributes );

// $questions = isset($attributes['questions']) ? $attributes['questions'] : array();
//     // Localize the script with the questions data
    

//    //wp_enqueue_script( 'boat-config-view-form-script', plugins_url( '/front-end/multistep-form.js', __FILE__ ), array(), '1.0', true, array('strategy'  => 'defer', ) );

// //    function get_enqueued_scripts () {
// //     $scripts = wp_scripts();
// //     var_dump( array_keys( $scripts->groups ) );
// // }

// // add_action( 'wp_head', 'get_enqueued_scripts' );

// //    $handle = 'create-block-boat-configurator-script';

// //    if (wp_script_is($handle, 'registered')) {
// //        echo "The script with handle '$handle' is registered.";
// //    } else {
// //        echo "The script with handle '$handle' is not registered.";
// //    }


// // function bc_inline_script() {
// //     $data = isset($attributes['questions']) ? $attributes['questions'] : array();
// //     wp_add_inline_script('create-block-boat-configurator-script', 'const questionsData = ' . wp_json_encode($data) . ';', 'after');
// // }
// // add_action('wp_enqueue_scripts', 'bc_inline_script');

$data = isset($attributes['questions']) ? $attributes['questions'] : array();
wp_add_inline_script('create-block-boat-configurator-script', 'const questionsData = ' . wp_json_encode($data) . ';', 'before');

//    //wp_localize_script('create-block-boat-configurator-script', 'questionsData', $questions);


// $form_id = isset($attributes['model']) ? $attributes['model'] : 'boat_config_form';
// $thank_you_message = '';

// if (isset($_GET['thank_you']) && $_GET['thank_you'] === '1') {
//     echo 'Thank you message: ' . $_GET['thank_you']; // Debugging output
//     $thank_you_message = '<p>Thank you for your submission!</p>';
//     echo $thank_you_message;
// } else {

//     echo isset($_GET['question']) ? $_GET['question'] : 'jokio kl';

// ?>

    // <button type="button" id="testing-render">Click Me!</button>
    // <div class="update-me"></div>
    // <div <?php echo $block_wrapper_attributes; ?>>
    //     <h2><?php echo $attributes['model']; ?></h2>
    //     <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="<?php echo $form_id ?>" class="boat-config-form">
    //     <?php wp_nonce_field('boat_configurator_form_submit_action', 'boat_configurator_nonce_' . $form_id);?>
    //     <input type="hidden" name="action" value="handle_form_submission">
    //     <input type="hidden" name="form_id" value="<?php echo $form_id ?>">
    //     <!-- <input type="hidden" name="_wp_http_referer" value="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"> -->

    //        <?php
// // Loop through answers and create input fields
//     foreach ($questions as $index => $question) {
//         // Generate unique input name and ID
//         $input_name = 'input_' . $index;
//         $input_id = 'input_' . $index;
//         ?>

//                 <div>
//                     <label for="<?php echo $input_id; ?>"><?php echo $question; ?>:</label>
//                     <input type="text" id="<?php echo $input_id; ?>" name="<?php echo $input_name; ?>" value="">
//                 </div>

//                 <!-- <div>
// 									<label>
// 										<input
// 											type="radio"
// 											name='test' // Use a unique name for each group of radio buttons
// 											value="small"
// 											id='radio1'
// 										/>
// 										<img src="https://via.placeholder.com/40x60/0bf/fff&text=A" alt="Option 1" />
// 									</label>
//                 </div> -->

//             <?php
//     }
//     ?>

// <!-- 
//             <div class="container">
//                 <label>
//                     <input
//                         type="radio"
//                         name={option.optionText}
//                         value={option.optionText}
//                         id={optionIndex}
//                     />
//                     <div class="card">
//                         <div class="top-text">
//                         </div>
//                         <div class="img">
//                             <img
//                                 src={props.attributes.imageURL || 'https://via.placeholder.com/100x100/e8e8e8/ffffff&text=add image'}
//                                 alt="Option 2"
//                                 style={{ cursor: 'pointer' }}
//                                 onClick={open}
//                             />
//                         </div>
//                     </div>
//                 </label>
//             </div> -->

//             <div>
//                     <label for="email_input" style="display: block">your email:</label>
//                     <input type="email" id="email-input" name="email_input" value="" style="display: block">
//                 </div>
//             <!-- Add more form fields as needed -->
//             <button type="submit" name="submit_form" id="submit_form">Submit</button>
//         </form>
//     </div>

// <?php
// } // End of if statement checking 'thank_you' parameter

// // cia vietoj radio card
// // <div class="container">
// //     <label>
// //         <input
// //             type="radio"
// //             name={option.optionText}
// //             value={option.optionText}
// //             id={optionIndex}
// //         />
// //         <div class="card">
// //             <span class="dashicons dashicons-no delete-option" onClick={() => deleteOption(questionIndex, optionIndex)}></span>

// //             <div class="top-text">
// //             </div>

// //             <div class="img">

// //                         <img
// //                             src={props.attributes.imageURL || 'https://via.placeholder.com/100x100/e8e8e8/ffffff&text=add image'}
// //                             alt="Option 2"
// //                             style={{ cursor: 'pointer' }}
// //                             onClick={open}
// //                         />

// //             </div>

// //         </div>
// //     </label>
