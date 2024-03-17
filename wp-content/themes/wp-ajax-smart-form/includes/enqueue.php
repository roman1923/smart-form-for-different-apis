<?php
/**
 * Enqueue scripts and styles.
 */
function rgb_scripts()
{
    wp_enqueue_style('google-fonts-preconnect', 'https://fonts.googleapis.com', array(), null);
    wp_enqueue_style('google-fonts-gstatic-preconnect', 'https://fonts.gstatic.com', array(), null);
    
    // Enqueue the Google Fonts stylesheet
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Inter:wght@100..900&display=swap', array(), null);
    wp_enqueue_style('intlTelInput', 'https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/css/intlTelInput.css', array(), null);
    // Enqueue styles
    wp_enqueue_style('rgb-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_enqueue_style('rgb-main', get_template_directory_uri() . '/dist/main.min.css', array(), _S_VERSION);

    // Enqueue scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-form');

    wp_enqueue_script('intlTelInput', 'https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/intlTelInput.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('rgb-script', get_template_directory_uri() . '/js/script.js', array('jquery', 'intlTelInput'), _S_VERSION, true);

    // Localize script
    wp_localize_script('rgb-script', 'ajax_form_object', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-form-nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'rgb_scripts');

?>