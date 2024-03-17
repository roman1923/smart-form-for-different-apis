<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rgb
 */

?>

	<footer id="colophon" class="site-footer" >
		<div class="site-info">
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a></p>
		</div><!-- .site-info -->
		<div class="footer-nav ">
		</div>
		<div class="copyright">
			<p><?php echo wp_kses_post('&#169;'); ?> <?php esc_html_e('Copyright', 'rgb') ?></p>
		</div>
	</footer>
</main>

<?php wp_footer(); ?>


</body>
</html>
