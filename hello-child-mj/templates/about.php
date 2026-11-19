<?php
/**
 * Template Name: MJ — About
 *
 * @package HelloChildMJ
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>
<main id="mj-content" class="mj-site-main site-main" role="main">
	<?php echo mj_load_partial( 'about' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</main>
<?php
get_footer();
