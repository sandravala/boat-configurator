<?php
add_action('admin_post_nopriv_handle_form_submission', 'handle_form_submission');
add_action('admin_post_handle_form_submission', 'handle_form_submission');

// Function to handle form submissions
function handle_form_submission() {
    // Check if the form has been submitted

    // && isset($_POST['submit_form'])

    // && wp_verify_nonce( 'boat_configurator_nonce_' . $_POST['form_id'], 'boat_configurator_form_submit_action' )


    $nonce_verified = wp_verify_nonce( 'boat_configurator_nonce_' . $_POST['form_id'], 'boat_configurator_form_submit_action' );
error_log('Nonce verification result: ' . ($nonce_verified ? 'true' : 'false'));

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        error_log('veikia su nonce');


        $email = $_POST['input_0']; // Assuming 'email' is the name attribute of your email input field

        // Validate email format
        if (!is_email($email)) {
            // Get the URL of the form page dynamically
            
        }

                //Send email to admin
        $admin_email = get_option('admin_email');
        $subject = 'New form submission';
        $message = 'A new form submission has been received.';

        wp_mail($admin_email, $subject, $message);

        wp_redirect(add_query_arg('regenerate_form', '1', $_POST['_wp_http_referer']));
exit;
        exit;
        // Sanitize and validate form data (you should implement your own sanitization/validation logic here)

        // Insert form data into the database (you should create a custom database table for this purpose)

        // Redirect or display success message to the user
    }
}
