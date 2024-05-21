<?php

use MailerLite\Mailerlite;
add_action('wp_ajax_nopriv_handle_form_submission', 'handle_form_submission');
add_action('wp_ajax_handle_form_submission', 'handle_form_submission');

function handle_form_submission()
{

    error_log('entered handle_form_submission');
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
        // error_log(print_r($sanitizedQuestionAnswers, true));
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

        // error_log(print_r($sanitizedContactInfo, true));
    }

    $sanitizedPostId = absint( $form_data['postId'] );
    $sanitizedPostTitle = sanitize_title( get_the_title($sanitizedPostId) );
    $sanitizedSubscribe = (bool) ($form_data['subscribe']);

    // Extract email and other fields
    $email = isset($sanitizedContactInfo['email']) ? $sanitizedContactInfo['email'] : '';

    if (empty($email)) {
        error_log('Email is empty');
        wp_send_json_error('Email is required');
        return;
    }

    if ($sanitizedSubscribe) {
        subscribeToMailerlite ( $sanitizedContactInfo );
    }

    // Save to database
    saveBoatConfigToDB( $sanitizedQuestionAnswers, $sanitizedContactInfo, $sanitizedPostId, $sanitizedPostTitle );

    // Send email to admin
    $admin_email = get_option('admin_email');
    $subject = 'New form submission';
    $message = 'A new form submission has been received.';

    if (!wp_mail($admin_email, $subject, $message)) {
        error_log('Failed to send email');
        wp_send_json_error('Failed to send email');
        return;
    }


    wp_send_json_success(array(
        'text' => 'all great',
    ), 200);

}

function saveBoatConfigToDB( $sanitizedQuestionAnswers, $sanitizedContactInfo, $sanitizedPostId, $sanitizedPostTitle ) {

    global $wpdb;
    // Insert form data into the database table
    $table_name = $wpdb->prefix . DB_TABLE; // Replace 'your_table_name' with your actual table name
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
    // Handle any additional actions after data insertion, such as sending emails, etc.
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
        ],
        "groups"=> [
            $group_id ? $group_id : null,
        ]
    ];

   
    $response = $mailerLite->subscribers->create($data);
    error_log(print_r($response, true));

}