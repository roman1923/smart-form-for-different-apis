<?php

get_header(); 

$contact_banner = get_field('contact_banner');

$form_title = get_field('form_title');

$name_label = get_field('name_label');
$name_placeholder = get_field('name_placeholder');

$phone_label = get_field('phone_label');

$email_label = get_field('email_label');
$email_placeholder = get_field('email_placeholder');

$textarea_placeholder= get_field('textarea_placeholder');

$button_text = get_field('button_text');

$privacy_text = get_field('privacy_text');
$privacy_link = get_field('privacy_link');
?>
<section class="contact-form--section">
    <div class="container">

        <div class="contact-form--block">
            <img class="form-banner--img" src="<?php echo get_template_directory_uri(); ?>/img/s-banner.png" alt="banner-img">       
            <h1 class="form-banner--text"><?php echo wp_kses_post( $contact_banner ); ?></h1>
        </div>

        <form id="form" class="form">

            <h3 class="form-title"><?php echo wp_kses_post( $form_title ); ?></h3>

            <label for="form_name"><?php echo esc_html( $name_label ); ?></label>
            <input type="text" name="form_name" id="form_name" class="required form_name" placeholder="<?php echo esc_attr( $name_placeholder ); ?>" />

            <label for="form_tel"><?php echo esc_html( $phone_label ); ?></label>
            <input type="tel" name="form_tel" id="form_tel" class="required form_tel">
            <input type="hidden" name="form_dial_code" id="form_dial_code" value="">
            
            <label for="form_email"><?php echo esc_html( $email_label ); ?></label>
            <input type="text" name="form_email" id="form_email" class="form_email" placeholder="<?php echo esc_attr( $email_placeholder ); ?>" />

            <textarea type="text" name="form_texarea" id="form_texarea" placeholder="<?php echo esc_attr( $textarea_placeholder ); ?>"></textarea>
            <input type="hidden" name="form_utm" id="form_utm"  value="<?php echo $_SERVER['QUERY_STRING']; ?>"/>

            <div class="form-bottom">

                <button type="submit" id="form_submit" class="button form_button">
                <span class="custom-spinner"></span>
                    <?php echo esc_html( $button_text ); ?>
                </button>

            </div>
            <div class="privacy-block">
                <p class="privacy-text">
                    <?php echo wp_kses_post( $privacy_text ); ?>
                    <a href="<?php echo esc_url( $privacy_link['url'] ); ?>" target="<?php echo esc_attr( $privacy_link['target'] ); ?>">
                        <?php echo esc_html( $privacy_link['title'] ); ?>
                    </a>
                </p>
            </div>

        </form>
    </div>
</section>


<?php

get_footer();
