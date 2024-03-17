<?php

class Form_Submissions_Page {
    public function render() {
        // Get form submissions
        $args = array(
            'post_type' => 'form_submissions',
            'posts_per_page' => -1, // Get all form submissions
        );
        $submissions = new WP_Query($args);

        // Render the admin page
        echo '<div class="wrap"><h1>Form Submissions</h1>';
        echo '<p>This is place where you can view form submissions.</p>';

        // Check if there are any submissions
        if ($submissions->have_posts()) {
            // Loop through each submission
            while ($submissions->have_posts()) {
                $submissions->the_post();
                $submission_id = get_the_ID();
                $form_name = get_the_title();
                $form_textarea = get_the_content();
                $form_email = get_post_meta($submission_id, '_form_email', true);
                $form_tel = get_post_meta($submission_id, '_form_tel', true);
                $dispatch_date = get_post_meta($submission_id, '_dispatch_date', true);
                $utm = get_post_meta($submission_id, '_utm', true);
                $sender_ip = get_post_meta($submission_id, '_sender_ip', true);

                // Render form submission data in input fields
                $this->render_submission_fields($submission_id, $form_name, $form_textarea, $form_email, $form_tel, $dispatch_date, $utm, $sender_ip);
            }
        } else {
            echo '<p>No form submissions found.</p>';
        }

        // Restore original post data
        wp_reset_postdata();

        echo '</div>';
    }

    private function render_submission_fields($submission_id, $form_name, $form_textarea, $form_email, $form_tel, $dispatch_date, $utm, $sender_ip) {
        echo '<h2>Form Submission ID: ' . $submission_id . '</h2>';
        echo '<div class="form-admin--info" style="display: flex; flex-direction: column; gap: 3px;">';
        echo '<label>Name:</label> <input type="text" value="' . esc_attr($form_name) . '" readonly><br>';
        echo '<label>Phone:</label> <input type="text" value="' . esc_attr($form_tel) . '" readonly><br>';
        echo '<label>Email:</label> <input type="text" value="' . esc_attr($form_email) . '" readonly><br>';
        echo '<label>Message:</label> <input type="text" value="' . esc_attr($form_textarea) . '" readonly><br>';
        echo '<label>Dispatch Date:</label> <input type="text" value="' . esc_attr($dispatch_date) . '" readonly><br>';
        echo '<label>UTM:</label> <input type="text" value="' . esc_attr($utm) . '" readonly><br>';
        echo '<label>Sender IP:</label> <input type="text" value="' . esc_attr($sender_ip) . '" readonly><br>';
        echo '</div>';
        echo '<hr>';
    }
}

function custom_form_submissions_admin_page() {
    add_menu_page(
        'Form Submissions',
        'Form Submissions',
        'manage_options',
        'form-submissions',
        array(new Form_Submissions_Page(), 'render'),
        'dashicons-feedback',
        20
    );
}
add_action('admin_menu', 'custom_form_submissions_admin_page');
