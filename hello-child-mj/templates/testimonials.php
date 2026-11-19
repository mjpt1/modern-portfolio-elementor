<?php
/**
 * Template Name: MJ — Testimonials
 *
 * @package HelloChildMJ
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>
<main id="mj-content" class="mj-site-main site-main" role="main">
	<?php echo mj_load_partial( 'testimonials' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</main>
<?php
get_footer();
