<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 *
 * @package rgb
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/css/intlTelInput.css">
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<main>
	<section style="z-index: 2" id="success-modal" class="modal-section">
		<div class="success-block">
			<div class="modal-top">
				<div class="cross-block">
					<span><?php the_field('button_close_name', 'option'); ?></span>
					<img class="cross" src="<?php echo get_template_directory_uri(); ?>/img/cross.svg " alt="close-modal">
				</div>
			</div>
			<div class="modal-content">
				<img src="<?php echo get_template_directory_uri(); ?>/img/rocket.png" class="modal-content--img" alt="rocket" />
				<p class="modal-content--subtitle"><?php the_field('modal_subtitle', 'option'); ?></p>
				<h2 class="modal-content--title"><?php the_field('modal_title', 'option'); ?></h2>
			</div>
		</div>
	</section>
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<p class="site-description"></p>
		</div>
	</header>
