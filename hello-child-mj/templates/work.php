<?php
/**
 * Template Name: MJ — Work
 *
 * @package HelloChildMJ
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>
<main id="mj-content" class="mj-site-main site-main" role="main">
	<?php echo mj_load_partial( 'work' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</main>
<?php
get_footer();
