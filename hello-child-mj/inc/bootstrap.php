<?php
/**
 * Theme bootstrap extras: options, admin, page routing without shortcodes.
 *
 * @package HelloChildMJ
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once MJ_THEME_DIR . '/inc/defaults.php';
require_once MJ_THEME_DIR . '/inc/options.php';

/**
 * Pro features (Portfolio Settings admin panel) — only when RTL license is active.
 * Front-end helpers (defaults / mj_setting) stay loaded without a license so the demo site works.
 */
function mj_bootstrap_pro_features() {
	static $loaded = false;
	if ( $loaded ) {
		return;
	}
	$loaded = true;
	require_once MJ_THEME_DIR . '/inc/admin-settings.php';
}

/**
 * Map page slug → template file under /templates/.
 *
 * @return array<string,string>
 */
function mj_slug_template_map() {
	return array(
		'home'         => 'home.php',
		'about'        => 'about.php',
		'services'     => 'services.php',
		'work'         => 'work.php',
		'testimonials' => 'testimonials.php',
		'contact'      => 'contact.php',
	);
}

/**
 * Force portfolio page templates by slug / front page (no shortcodes needed).
 *
 * @param string $template Template path.
 * @return string
 */
function mj_template_include( $template ) {
	$map = mj_slug_template_map();

	if ( is_front_page() && ! is_home() ) {
		$custom = MJ_THEME_DIR . '/templates/home.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}

	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( $slug && isset( $map[ $slug ] ) ) {
			$custom = MJ_THEME_DIR . '/templates/' . $map[ $slug ];
			if ( file_exists( $custom ) ) {
				return $custom;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'mj_template_include', 99 );

/**
 * Register page templates for the Page Attributes dropdown.
 *
 * @param array $posts_templates Templates.
 * @return array
 */
function mj_page_templates( $posts_templates ) {
	$posts_templates['templates/home.php']         = 'MJ — Home';
	$posts_templates['templates/about.php']        = 'MJ — About';
	$posts_templates['templates/services.php']     = 'MJ — Services';
	$posts_templates['templates/work.php']         = 'MJ — Work';
	$posts_templates['templates/testimonials.php'] = 'MJ — Testimonials';
	$posts_templates['templates/contact.php']      = 'MJ — Contact';
	return $posts_templates;
}
add_filter( 'theme_page_templates', 'mj_page_templates' );

/**
 * Document title from Portfolio Settings.
 *
 * @param array $parts Title parts.
 * @return array
 */
function mj_document_title_parts( $parts ) {
	$locale = 'fa';
	if ( ! empty( $_COOKIE['modern-portfolio-locale'] ) ) {
		$locale = sanitize_key( wp_unslash( $_COOKIE['modern-portfolio-locale'] ) );
	}
	$title = ( 'en' === $locale )
		? mj_setting( 'brand.meta_title_en' )
		: mj_setting( 'brand.meta_title_fa' );
	if ( $title ) {
		$parts['title'] = $title;
		unset( $parts['site'] );
		unset( $parts['tagline'] );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'mj_document_title_parts' );
