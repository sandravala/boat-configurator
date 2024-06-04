<?php

use Mailerlite;
add_action('wp_ajax_nopriv_handle_form_submission', 'handle_form_submission');
add_action('wp_ajax_handle_form_submission', 'handle_form_submission');

function handle_form_submission()
{

    if (!check_ajax_referer('bc_frontend_view_nonce', 'security')) {
        wp_send_json_error(array('message' => 'Invalid nonce'));
        wp_die();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        wp_send_json_error('Invalid request method');
        wp_die();
    }


    $form_data = $_POST['form_data'];

    if (isset($form_data['questionAnswers'])) {
        $sanitizedQuestionAnswers = array();

        // Loop through each question answer
        foreach ($form_data['questionAnswers'] as $questionText => $answer) {
            // Sanitize the text, imgUrl, and color values if they exist
            $sanitizedAnswer = array(
                'text' => isset($answer['optionText']) ? sanitize_text_field($answer['optionText']) : '',
                'imgUrl' => isset($answer['imgUrl']) ? esc_url_raw($answer['imgUrl']) : '',
                'color' => isset($answer['color']) ? sanitize_hex_color($answer['color']) : '',
            );

            $sanitizedQuestion = sanitize_text_field($questionText);

            // Add the sanitized answer to the sanitized array
            $sanitizedQuestionAnswers[$sanitizedQuestion] = $sanitizedAnswer;
        }
    }

    if (isset($form_data['contactInfo'])) {
        $contactFormFields = $form_data['contactInfo'];
    
        // Initialize an empty array for sanitized data
        $sanitizedContactInfo = array();
    
        // Loop through each field in the received data
        foreach ($contactFormFields as $fieldId => $fieldData) {
            $fieldValue = $fieldData[0];
            $fieldType = $fieldData[1];
            $sanitizedValue = '';
    
            // Sanitize based on field type
            switch ($fieldType) {
                case 'text':
                case 'select': // Assuming 'select' values are strings and should be sanitized as text
                    $sanitizedValue = sanitize_text_field($fieldValue);
                    break;
                case 'email':
                    $sanitizedValue = sanitize_email($fieldValue);
                    break;
                case 'number':
                    $sanitizedValue = intval($fieldValue); // Sanitize as integer
                    break;
                // Add more cases if there are other types
                default:
                    $sanitizedValue = sanitize_text_field($fieldValue); // Default sanitization
                    break;
            }
    
            // Add the sanitized value to the sanitized contact info array
            $sanitizedContactInfo[$fieldId] = $sanitizedValue;
        }
    }

    $sanitizedPostId = absint( $form_data['postId'] );
    $sanitizedPostTitle = sanitize_title( get_the_title($sanitizedPostId) );
    $sanitizedSubscribe = (bool) ($form_data['subscribe']);

    // Extract email and other fields
    $email = isset($sanitizedContactInfo['email']) ? $sanitizedContactInfo['email'] : '';

    if (empty($email)) {
        wp_send_json_error('Email is required');
        return;
    }

    if ($sanitizedSubscribe) {
        subscribeToMailerlite ( $sanitizedContactInfo );
    }

    // Save to database
    saveBoatConfigToDB( $sanitizedQuestionAnswers, $sanitizedContactInfo, $sanitizedPostId, $sanitizedPostTitle );
    sendEmailToAdmin ( $sanitizedQuestionAnswers, $sanitizedContactInfo, $sanitizedPostTitle );
    sendEmailToUser ( $sanitizedQuestionAnswers, $sanitizedContactInfo, $sanitizedPostTitle, $email );

    wp_send_json_success(array(
        'text' => 'all great',
    ), 200);

}

function saveBoatConfigToDB( $sanitizedQuestionAnswers, $sanitizedContactInfo, $sanitizedPostId, $sanitizedPostTitle ) {

    global $wpdb;
    // Insert form data into the database table
    $table_name = $wpdb->prefix . DB_TABLE; // Replace 'your_table_name' with your actual table name
    // phpcs:disable
    $wpdb->insert(
        $table_name,
        array(
            'post_id' => $sanitizedPostId,
            'post_title' => $sanitizedPostTitle,
            'answers' =>maybe_serialize($sanitizedQuestionAnswers),
            'first_name' => $sanitizedContactInfo['firstName'],
            'last_name' => $sanitizedContactInfo['lastName'],
            'email' => $sanitizedContactInfo['email'],
            'phone' => $sanitizedContactInfo['phone'],
            'country' => $sanitizedContactInfo['country'],
            'city' => $sanitizedContactInfo['city'],
            'zip' => $sanitizedContactInfo['zip'],
            // Insert other form fields as needed
        ),
        array(
            '%d',
            '%s',
            '%s', 
            '%s', 
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
        )
    ); 
    // phpcs:enable
}

function subscribeToMailerlite ( $sanitizedContactInfo ) {

    $data_encryption = new BC_Data_Encryption();
    $api_key = get_option('bc_ml_api_key');
    $group_id = get_option('bc_ml_group_id');

    if ($api_key) {
        $api_key = $data_encryption->decrypt(get_option('bc_ml_api_key'));
    }

    if ($group_id) {
        $group_id = $data_encryption->decrypt(get_option('bc_ml_group_id'));
    }

    $group_id = 123; //error pagaudymui
   
    $mailerLite = new MailerLite(['api_key' => $api_key]);
    
    $data = [
        'email' => $sanitizedContactInfo['email'],
        "fields" => [
            "name" => isset($sanitizedContactInfo['firstName']) ? $sanitizedContactInfo['firstName'] : null,
            "last_name" => isset($sanitizedContactInfo['lastName']) ? $sanitizedContactInfo['lastName'] : null,
            "city" => isset($sanitizedContactInfo['city']) ? $sanitizedContactInfo['city'] : null,
            "country" => isset($sanitizedContactInfo['country']) ? $sanitizedContactInfo['country'] : null,
            "phone" => isset($sanitizedContactInfo['phone']) ? $sanitizedContactInfo['phone'] : null,
            "state" => isset($sanitizedContactInfo['state']) ? $sanitizedContactInfo['state'] : null,
            "z_i_p" => isset($sanitizedContactInfo['zip']) ? $sanitizedContactInfo['zip'] : null
        ]
    ];

    if (is_numeric($group_id) && $group_id > 0) {
        $data['groups'] = [$group_id];
    }

    try {
        $response = $mailerLite->subscribers->create($data);
    } catch (Exception $e) {
       // Send email to admin
        sendSubscriptionErrorEmailToAdmin($sanitizedContactInfo, $e->getMessage());
        return false;
    }
      return true;
}

function sendSubscriptionErrorEmailToAdmin ( $sanitizedContactInfo, $errorMessage )
{
    $admin_email = get_option('admin_email');
    $subject = 'Failed MailerLite Subscription Attempt';

    // Construct the message including all contact fields
    $message = 'A user attempted to subscribe with the following details but encountered an error: ' . PHP_EOL;
    foreach ($sanitizedContactInfo as $field => $value) {
        $message .= ucfirst($field) . ': ' . $value . PHP_EOL;
    }
    $message .= 'Error Message: ' . $errorMessage;

    // Send email to admin
    wp_mail($admin_email, $subject, $message);
}

function sendEmailToAdmin ( $sanitizedQuestionAnswers, $sanitizedContactInfo, $sanitizedPostTitle ) {

    $email_to_notify = sanitize_email(get_option('bc_email_ntf'));
    $admin_email = $email_to_notify ? $email_to_notify : sanitize_email(get_option('admin_email'));
    $subject = 'New ' . esc_html($sanitizedPostTitle) . ' Configuration received';

    // HTML email content for Admin
    $admin_message = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Email</title>
            <style> @import url("https://fonts.googleapis.com/css2?family=Hind:wght@400&family=Montserrat:wght@400;700&display=swap"); </style>
        </head>
        <body style="font-family: \'Hind\'; font-weight: normal; font-size: 18pt; padding: 1em; text-align: justify;">
            <h1 style="font-family: \'Montserrat\';font-weight: bold;font-size: 24pt;">Hendrixon Boat Configurator: ' . esc_html($sanitizedPostTitle) . '</h1>
            <div style="background-color: #cc7c54; width: 60px; height: 18px;"></div>
            <h2 style="font-family: \'Montserrat\';font-weight: normal;font-size: 20pt;">A new form submission has been received.</h2>

            <h2 style="font-family: \'Montserrat\';font-weight: normal;font-size: 20pt;">Contact Information</h2>
            <ul style="padding-left: 0;">';
            foreach ($sanitizedContactInfo as $field => $value) {
                $admin_message .= '<li style="position: relative;left: 0;list-style: none;border-left: 10px solid #05b3bc;padding-left: 1em;">
                    <span style="font-family: \'Montserrat\';font-weight: bold;font-size: 18pt;">' . ucfirst(esc_html($field)) . ':</span> ' . esc_html($value) . '</li>';
            }
            $admin_message .= '</ul>
            
            <h2 style="font-family: \'Montserrat\';font-weight: normal;font-size: 20pt;">Boat Configuration</h2>

            <ul style="padding-left: 0;">';
            foreach ($sanitizedQuestionAnswers as $question => $answer) {
                $admin_message .= '<li style="position: relative;left: 0;list-style: none;border-left: 10px solid #05b3bc;padding-left: 1em;margin-bottom: 2em;">
                        <span style="font-family: \'Montserrat\';font-weight: bold;font-size: 18pt;">' . esc_html($question) . '</span><br>' . 
                        esc_html($answer['text']) . 
                        (!empty($answer['color']) ? ' (' . esc_html($answer['color']) : ')') . '<br>';
                if (!empty($answer['imgUrl'])) {
                    $admin_message .= '<img src="' . esc_url($answer['imgUrl']) . '" alt="' . $answer['text'] . '" style="max-width: 200px;"><br>';
                }
                if (!empty($answer['color'])) {
                    $admin_message .= '<div style="width: 100px; height: 100px; background-color: ' . esc_attr($answer['color']) . '; border-radius: .2em;"></div>';
                }
                $admin_message .= '</li>';
            }
            $admin_message .= '</ul>

            
        </body>
    </html>';
    
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if (!wp_mail($admin_email, $subject, $admin_message, $headers)) {
        wp_send_json_error('Failed to send email');
        return;
    }

}

function sendEmailToUser ( $sanitizedQuestionAnswers, $sanitizedContactInfo, $sanitizedPostTitle, $email ) {

    
    $user_subject = 'Thank you for your ' . esc_html($sanitizedPostTitle) . ' configuration';

    $user_message = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Boat Configuration</title>
            <style> @import url("https://fonts.googleapis.com/css2?family=Hind:wght@400&family=Montserrat:wght@400;700&display=swap"); </style>
        </head>
            <body style="font-family: \'Hind\'; font-weight: normal; font-size: 18pt; padding: 1em; text-align: justify;">
                <h1 style="font-family: \'Montserrat\';font-weight: bold;font-size: 24pt;">Hendrixon Boat Configurator: ' . esc_html($sanitizedPostTitle) . '</h1>
                <div style="background-color: #cc7c54; width: 60px; height: 18px;"></div>
                <h2 style="font-family: \'Montserrat\';font-weight: normal;font-size: 20pt;">Thank you for using Hendrixon Boat Configurator. We\'ll get in touch soon! Here is a copy of your configuration:</h2>
                
                <ul style="padding-left: 0;">';
                foreach ($sanitizedQuestionAnswers as $question => $answer) {
                    $user_message .= '<li style="position: relative;left: 0;list-style: none;border-left: 10px solid #05b3bc;padding-left: 1em;margin-bottom: 2em;">
                            <span style="font-family: \'Montserrat\';font-weight: bold;font-size: 18pt;">' . esc_html($question) . '</span><br>' . 
                            esc_html($answer['text']) . 
                        (!empty($answer['color']) ? ' (' . esc_html($answer['color']) : ')') . '<br>';
                    if (!empty($answer['imgUrl'])) {
                        $user_message .= '<img src="' . esc_url($answer['imgUrl']) . '" alt="Image" style="max-width: 200px;"><br>';
                    }
                    if (!empty($answer['color'])) {
                        $user_message .= '<div style="width: 100px; height: 100px; background-color: ' . esc_attr($answer['color']) . '; border-radius: .2em;"></div>';
                    }
                    $user_message .= '</li>';
                }
                $user_message .= '</ul>

                <h2 style="font-family: \'Montserrat\';font-weight: normal;font-size: 20pt;">Contact Information</h2>
                <ul style="padding-left: 0;">';
                foreach ($sanitizedContactInfo as $field => $value) {
                    $user_message .= '<li style="position: relative;left: 0;list-style: none;border-left: 10px solid #05b3bc;padding-left: 1em;">
                        <span style="font-family: \'Montserrat\';font-weight: bold;font-size: 18pt;">' . ucfirst(esc_html($field)) . ':</span> ' . esc_html($value) . '</li>';
                }
                $user_message .= '</ul>
            </body>
        </html>';

    // Set content type to HTML
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if (!wp_mail($email, $user_subject, $user_message, $headers)) {
        wp_send_json_error('Failed to send email');
        return;
    }

}