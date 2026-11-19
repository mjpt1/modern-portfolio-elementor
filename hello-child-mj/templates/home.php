<?php
/**
 * Template Name: MJ — Home
 * Portfolio home (content from Portfolio Settings).
 *
 * @package HelloChildMJ
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>
<main id="mj-content" class="mj-site-main site-main" role="main">
	<?php echo mj_load_partial( 'home' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</main>
<?php
get_footer();
