<?php

use MailerLite\Mailerlite;
add_action('wp_ajax_nopriv_handle_form_submission', 'handle_form_submission');
add_action('wp_ajax_handle_form_submission', 'handle_form_submission');

// Function to handle form submissions
function handle_form_submission() {
    // Check if the form has been submitted

    // && isset($_POST['submit_form'])

    // && wp_verify_nonce( 'boat_configurator_nonce_' . $_POST['form_id'], 'boat_configurator_form_submit_action' )

    // $nonce_verified = wp_verify_nonce('boat_configurator_nonce_' . $_POST['form_id'], 'boat_configurator_form_submit_action');
    // error_log('Nonce verification result: ' . ($nonce_verified ? 'true' : 'false'));
   
    error_log('entered handle_form_submission');
    if( !check_ajax_referer( 'bc_frontend_view_nonce', 'security' )) {
        error_log('Nonce verification failed');
        wp_send_json_error(array('message' => 'Invalid nonce'));
        wp_die();
    }


    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        error_log('Invalid request method');
        wp_send_json_error('Invalid request method');
        return;
    }

    error_log('before parse_str');
    parse_str($_POST['form_data'], $form_data);
    error_log($form_data);

        // Extract email and other fields
        $email = isset($form_data['email']) ? sanitize_email($form_data['email']) : '';
    
        if (empty($email)) {
            error_log('Email is empty');
            wp_send_json_error('Email is required');
            return;
        }
    
        // // Save to database
        // saveBoatConfigToDB();
    
        // Send email to admin
        $admin_email = get_option('admin_email');
        $subject = 'New form submission';
        $message = 'A new form submission has been received.';
    
        if (!wp_mail($admin_email, $subject, $message)) {
            error_log('Failed to send email');
            wp_send_json_error('Failed to send email');
            return;
        }

        error_log('before wp_send_json_success');
        wp_send_json_success( array( 
            'text' => 'all great', 
        ), 200 );



    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //     $email = $_POST['input_0']; // Assuming 'email' is the name attribute of your email input field

    //     saveBoatConfigToDB();

    //     //Send email to admin
    //     $admin_email = get_option('admin_email');
    //     $subject = 'New form submission';
    //     $message = 'A new form submission has been received.';

    //     wp_mail($admin_email, $subject, $message);
        
    //     $apiKey = MAILERLITE_KEY;

    //     error_log($apiKey);
    //     $mailerLite = new MailerLite(['api_key' =>  $apiKey]);

    //     $data = [
    //         'email' => 'subscriber@example.com',
    //     ];

    //     $response = $mailerLite->subscribers->create($data);

    //     wp_redirect(add_query_arg('thank_you', '1', $_POST['_wp_http_referer']));
    //     //wp_redirect(plugin_dir_url(__FILE__) . 'thank-you.php');
    //     exit;
    //     // Sanitize and validate form data (you should implement your own sanitization/validation logic here)

    //     // Insert form data into the database (you should create a custom database table for this purpose)

    //     // Redirect or display success message to the user
    // }

    // Check if the form has been submitted

       

}

function saveBoatConfigToDB() {
    // Retrieve form data from POST variables
    $answers = isset($_POST['input_0']) ? $_POST['input_0'] : '';
    $email = isset($_POST['email_input']) ? $_POST['email_input'] : 'no email';
    // Retrieve other form data as needed

    // Sanitize and validate form data (you should implement your own sanitization/validation logic here)
    global $wpdb;
        // Insert form data into the database table
    $table_name = $wpdb->prefix . DB_TABLE; // Replace 'your_table_name' with your actual table name
    $wpdb->insert(
        $table_name,
        array(
            'answers' => $answers,
            'email' => $email,
            // Insert other form fields as needed
        ),
        array(
            '%s', // Format for 'question' column (string)
            '%s', // Format for 'email' column (string)
            // Add other formats for additional columns as needed
        )
    );
    // Handle any additional actions after data insertion, such as sending emails, etc.
}
