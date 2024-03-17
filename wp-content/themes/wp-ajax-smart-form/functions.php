<?php
/**
 * rgb functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rgb
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

require get_template_directory() . '/includes/setup.php';

require get_template_directory() . '/includes/enqueue.php';

require __DIR__ . '/vendor/autoload.php';

class AjaxFormHandler {
    public $errors = [];
    public $form_name;
    public $form_email;
    public $form_tel;
    public $form_textarea;
    public $dispatch_date;
    public $utm;
    public $sender_ip;

    public function __construct() {
        add_action('wp_ajax_ajax_form_action', array($this, 'handle_ajax'));
        add_action('wp_ajax_nopriv_ajax_form_action', array($this, 'handle_ajax'));
    }

    public function handle_ajax() {
        $this->validate_nonce();
        $this->validate_form_data();
        
        if (!empty($this->errors)) {
            wp_send_json_error($this->errors);
        } else {
            $this->save_to_google_sheets();
            $this->send_email();
            $this->save_to_database();
            $this->send_to_telegram();
            $this->send_response();
        }
    }

    public function validate_nonce() {
        $this->errors = [];
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax-form-nonce')) {
            $this->errors[] = 'Invalid request';
        }
    }

    public function validate_form_data() {
        if ($_POST['form_anticheck'] === false || !empty($_POST['form_submitted'])) {
            $this->errors[] = 'Invalid request';
        }

        // Validate name
        if (empty($_POST['form_name'])) {
            $this->errors['name'] = 'Вкажіть Ваше ім’я';
        } else {
            $form_name = sanitize_text_field($_POST['form_name']);
            if (!preg_match('/^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/', $form_name)) {
                $this->errors['name'] = 'Вкажіть Ваше ім’я правильно';
            } else {
                $this->form_name = $form_name; // Store sanitized name
            }
        }

        // Validate phone number
        if (empty($_POST['form_tel'])) {
            $this->errors['tel'] = 'Вкажіть номеру Вашого телефону';
        } else {
            if (!preg_match("/^[0-9+\-\(\) ]+$/", $_POST['form_tel'])) {
                $this->errors['tel'] = 'Вкажіть вірний номеру Вашого телефону';
            } else {
                $this->form_tel = sanitize_text_field($_POST['form_dial_code']) . sanitize_text_field($_POST['form_tel']);
            }
        } 

        // Validate email
        if (!empty($_POST['form_email'])) {
            $this->form_email = sanitize_email($_POST['form_email']);
            if (!filter_var($this->form_email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = 'Вкажіть вірну електронну адресу';
            }
        } else {
            $this->form_email = '';
        }

        // Validate textarea
        if (!empty($_POST['form_texarea'])) {
            $this->form_textarea = sanitize_text_field($_POST['form_texarea']);
        } else {
            $this->form_textarea = '';
        }

        // Prepare common data
        date_default_timezone_set('Europe/Warsaw');
        $this->dispatch_date = date('Y-m-d H:i:s');
        $this->utm = isset($_POST['form_utm']) ? $_POST['form_utm'] : '';
        $this->sender_ip = $_SERVER['REMOTE_ADDR'];
    }

    public function save_to_google_sheets() {
        $client = new Google_Client();
        $client->setApplicationName(get_field('sheet_name', 'option'));
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(__DIR__ . '/credentials.json');
        $service = new Google_Service_Sheets($client);

        // Define spreadsheet ID and range
        $spreadsheetId = get_field('sheet_id', 'option');;
        $range = get_field('range', 'option');; // Adjust the range as needed

        // Prepare data to be inserted into Google Sheets
        $values = [
            [$this->form_name, $this->form_tel, $this->form_email, $this->form_textarea, $this->dispatch_date, $this->utm, $this->sender_ip],
        ];

        // Create Google Sheets value range object
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        // Define additional parameters
        $params = [
            'valueInputOption' => 'RAW' // Format data as entered by the user
        ];

        // Append data to Google Sheets
        $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    }

    public function send_email() {
        $home_url = wp_parse_url(home_url());
        $subject = 'Message from website ' . $home_url['host'];
        $message = "Name: $this->form_name\n";
        $message .= "Email: $this->form_email\n";
        $message .= "Phone: $this->form_tel\n";
        $message .= "Message: $this->form_textarea\n";
        $message .= "Date: $this->dispatch_date\n";
        $message .= "UTM: $this->utm\n";
        $message .= "IP: $this->sender_ip\n";

        $email_to = get_field('emails', 'option');
        $email_from = $this->form_email;

        $headers = "From: {$home_url['host']} <$email_from>\r\n";

        wp_mail($email_to, $subject, $message, $headers);
    }

    public function save_to_database() {
        // Prepare post data
        $post_args = array(
            'post_title' => $this->form_name,
            'post_content' => $this->form_textarea,
            'post_type' => 'form_submissions', // Custom post type name
            'post_status' => 'publish', // Set to 'publish' to make it visible immediately
        );
    
        // Insert post into WordPress database
        $post_id = wp_insert_post($post_args);
    
        // Update custom fields with additional data
        if ($post_id) {
            update_post_meta($post_id, '_form_email', $this->form_email);
            update_post_meta($post_id, '_form_tel', $this->form_tel);
            update_post_meta($post_id, '_dispatch_date', $this->dispatch_date);
            update_post_meta($post_id, '_utm', $this->utm);
            update_post_meta($post_id, '_sender_ip', $this->sender_ip);
        }
    }

    public function send_to_telegram() {
        // Send data to Telegram bot
        $bot_token = get_field('token', 'option');
        $chat_id = get_field('chat_id', 'option');
        $telegram_message = "Smart form submission\n\n";
        $telegram_message .= "Name: $this->form_name\n";
        $telegram_message .= "Phone: $this->form_tel\n";
        $telegram_message .= "Email: $this->form_email\n";
        $telegram_message .= "Message: $this->form_textarea\n";
        $telegram_message .= "Date: $this->dispatch_date\n";
        $telegram_message .= "UTM: $this->utm\n";
        $telegram_message .= "IP: $this->sender_ip\n";

        $telegram_api_url = "https://api.telegram.org/bot$bot_token/sendMessage";
        $telegram_data = array(
            'chat_id' => $chat_id,
            'text' => $telegram_message
        );

        $ch = curl_init($telegram_api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($telegram_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $telegram_result = curl_exec($ch);
        curl_close($ch);

        // Send response
        if ($telegram_result) {
            wp_send_json_success('Message sent successfully and saved as post ID: ' . $post_id . '. Telegram message also sent.');
        } else {
            wp_send_json_success('Message sent successfully and saved as post ID: ' . $post_id . '. Telegram message could not be sent.');
        }
    }

    public function send_response() {
        if (!empty($this->errors)) {
            wp_send_json_error($this->errors);
        } else {
            wp_send_json_success('Message sent successfully.');
        }
    }
}

new AjaxFormHandler();

require get_template_directory() . '/includes/class-form-submission.php';

?>