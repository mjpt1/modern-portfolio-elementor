<?php
/**
 * Portfolio settings API — get / merge / sanitize.
 *
 * @package HelloChildMJ
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MJ_OPTION_KEY', 'mj_portfolio_settings' );

/**
 * Deep-merge saved options over defaults.
 *
 * @return array
 */
function mj_get_settings() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$defaults = mj_default_settings();
	$saved    = get_option( MJ_OPTION_KEY, array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$cache = mj_array_merge_recursive_distinct( $defaults, $saved );
	return $cache;
}

/**
 * Clear settings cache (after save).
 */
function mj_flush_settings_cache() {
	// Re-read on next mj_get_settings() by unsetting static via fresh request;
	// For same-request, delete option cache is enough if we re-call carefully.
	wp_cache_delete( MJ_OPTION_KEY, 'options' );
}

/**
 * Get a nested setting by dotted path, e.g. "home.subtitle_fa".
 *
 * @param string $path    Dot path.
 * @param mixed  $fallback Fallback.
 * @return mixed
 */
function mj_setting( $path, $fallback = '' ) {
	$parts  = explode( '.', $path );
	$cursor = mj_get_settings();
	foreach ( $parts as $part ) {
		if ( ! is_array( $cursor ) || ! array_key_exists( $part, $cursor ) ) {
			return $fallback;
		}
		$cursor = $cursor[ $part ];
	}
	return $cursor;
}

/**
 * Avatar image URL (media library or theme default).
 *
 * @return string
 */
function mj_avatar_url() {
	$id = absint( mj_setting( 'brand.avatar_id', 0 ) );
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	return mj_img_uri( 'avatar.png' );
}

/**
 * Resolve project/testimonial image: attachment ID, else theme file.
 *
 * @param array  $item Item with image_id / image_file.
 * @param string $fallback_file Theme img filename.
 * @return string
 */
function mj_item_image_url( $item, $fallback_file = '' ) {
	$id = isset( $item['image_id'] ) ? absint( $item['image_id'] ) : 0;
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'large' );
		if ( $url ) {
			return $url;
		}
	}
	$file = ! empty( $item['image_file'] ) ? $item['image_file'] : $fallback_file;
	if ( $file ) {
		return mj_img_uri( $file );
	}
	return '';
}

/**
 * Recursive merge — numeric arrays from saved replace defaults when non-empty.
 *
 * @param array $base Base.
 * @param array $overlay Overlay.
 * @return array
 */
function mj_array_merge_recursive_distinct( array $base, array $overlay ) {
	foreach ( $overlay as $key => $value ) {
		if ( is_array( $value ) && isset( $base[ $key ] ) && is_array( $base[ $key ] ) ) {
			// List of associative items (skills, services…) — replace if overlay has entries.
			if ( mj_is_list_array( $value ) || mj_is_list_array( $base[ $key ] ) ) {
				if ( ! empty( $value ) ) {
					$base[ $key ] = $value;
				}
			} else {
				$base[ $key ] = mj_array_merge_recursive_distinct( $base[ $key ], $value );
			}
		} else {
			$base[ $key ] = $value;
		}
	}
	return $base;
}

/**
 * @param array $arr Array.
 * @return bool
 */
function mj_is_list_array( array $arr ) {
	if ( array() === $arr ) {
		return true;
	}
	return array_keys( $arr ) === range( 0, count( $arr ) - 1 );
}

/**
 * Sanitize and save posted settings.
 *
 * @param array $raw Raw POST mj_settings.
 * @return array Sanitized settings saved.
 */
function mj_sanitize_settings( $raw ) {
	if ( ! is_array( $raw ) ) {
		$raw = array();
	}
	$d   = mj_default_settings();
	$out = array();

	$out['brand'] = array(
		'owner_name_fa'  => sanitize_text_field( $raw['brand']['owner_name_fa'] ?? $d['brand']['owner_name_fa'] ),
		'owner_name_en'  => sanitize_text_field( $raw['brand']['owner_name_en'] ?? $d['brand']['owner_name_en'] ),
		'meta_title_fa'  => sanitize_text_field( $raw['brand']['meta_title_fa'] ?? $d['brand']['meta_title_fa'] ),
		'meta_title_en'  => sanitize_text_field( $raw['brand']['meta_title_en'] ?? $d['brand']['meta_title_en'] ),
		'meta_desc_fa'   => sanitize_textarea_field( $raw['brand']['meta_desc_fa'] ?? $d['brand']['meta_desc_fa'] ),
		'meta_desc_en'   => sanitize_textarea_field( $raw['brand']['meta_desc_en'] ?? $d['brand']['meta_desc_en'] ),
		'default_locale' => in_array( ( $raw['brand']['default_locale'] ?? 'fa' ), array( 'fa', 'en' ), true ) ? $raw['brand']['default_locale'] : 'fa',
		'avatar_id'      => absint( $raw['brand']['avatar_id'] ?? 0 ),
	);

	$out['socials'] = array();
	foreach ( array( 'youtube', 'instagram', 'facebook', 'dribbble', 'pinterest', 'github' ) as $net ) {
		$out['socials'][ $net ] = esc_url_raw( $raw['socials'][ $net ] ?? '' );
	}

	$out['nav'] = array();
	foreach ( $d['nav'] as $k => $v ) {
		$out['nav'][ $k ] = sanitize_text_field( $raw['nav'][ $k ] ?? $v );
	}

	$home_keys = array( 'title_line1_fa', 'title_line1_en', 'title_line2_fa', 'title_line2_en', 'title_accent_fa', 'title_accent_en', 'subtitle_fa', 'subtitle_en' );
	$out['home'] = array();
	foreach ( $home_keys as $k ) {
		$fn = ( false !== strpos( $k, 'subtitle' ) ) ? 'sanitize_textarea_field' : 'sanitize_text_field';
		$out['home'][ $k ] = $fn( $raw['home'][ $k ] ?? $d['home'][ $k ] );
	}

	$about_text = array(
		'heading_fa', 'heading_en', 'heading_accent_fa', 'heading_accent_en', 'heading_suffix_fa', 'heading_suffix_en',
		'subtitle_fa', 'subtitle_en',
		'counter_exp_label_fa', 'counter_exp_label_en', 'counter_cli_label_fa', 'counter_cli_label_en',
		'counter_prj_label_fa', 'counter_prj_label_en', 'counter_awd_label_fa', 'counter_awd_label_en',
		'tab_skills_fa', 'tab_skills_en', 'tab_awards_fa', 'tab_awards_en',
		'tab_experience_fa', 'tab_experience_en', 'tab_credentials_fa', 'tab_credentials_en',
	);
	$out['about'] = array();
	foreach ( $about_text as $k ) {
		$fn = ( false !== strpos( $k, 'subtitle' ) ) ? 'sanitize_textarea_field' : 'sanitize_text_field';
		$out['about'][ $k ] = $fn( $raw['about'][ $k ] ?? $d['about'][ $k ] );
	}
	$out['about']['counter_exp']      = absint( $raw['about']['counter_exp'] ?? $d['about']['counter_exp'] );
	$out['about']['counter_clients']  = absint( $raw['about']['counter_clients'] ?? $d['about']['counter_clients'] );
	$out['about']['counter_projects'] = absint( $raw['about']['counter_projects'] ?? $d['about']['counter_projects'] );
	$out['about']['counter_awards']   = absint( $raw['about']['counter_awards'] ?? $d['about']['counter_awards'] );

	$out['about']['skills'] = mj_sanitize_skill_rows( $raw['about']['skills'] ?? $d['about']['skills'] );
	foreach ( array( 'awards', 'experience', 'credentials' ) as $list ) {
		$out['about'][ $list ] = mj_sanitize_stage_rows( $raw['about'][ $list ] ?? $d['about'][ $list ] );
	}

	$out['services'] = array(
		'heading_fa'  => sanitize_text_field( $raw['services']['heading_fa'] ?? $d['services']['heading_fa'] ),
		'heading_en'  => sanitize_text_field( $raw['services']['heading_en'] ?? $d['services']['heading_en'] ),
		'subtitle_fa' => sanitize_textarea_field( $raw['services']['subtitle_fa'] ?? $d['services']['subtitle_fa'] ),
		'subtitle_en' => sanitize_textarea_field( $raw['services']['subtitle_en'] ?? $d['services']['subtitle_en'] ),
		'items'       => mj_sanitize_service_rows( $raw['services']['items'] ?? $d['services']['items'] ),
	);

	$out['work'] = array(
		'heading_fa'    => sanitize_text_field( $raw['work']['heading_fa'] ?? $d['work']['heading_fa'] ),
		'heading_en'    => sanitize_text_field( $raw['work']['heading_en'] ?? $d['work']['heading_en'] ),
		'subtitle_fa'   => sanitize_textarea_field( $raw['work']['subtitle_fa'] ?? $d['work']['subtitle_fa'] ),
		'subtitle_en'   => sanitize_textarea_field( $raw['work']['subtitle_en'] ?? $d['work']['subtitle_en'] ),
		'live_label_fa' => sanitize_text_field( $raw['work']['live_label_fa'] ?? $d['work']['live_label_fa'] ),
		'live_label_en' => sanitize_text_field( $raw['work']['live_label_en'] ?? $d['work']['live_label_en'] ),
		'proj_label_fa' => sanitize_text_field( $raw['work']['proj_label_fa'] ?? $d['work']['proj_label_fa'] ),
		'proj_label_en' => sanitize_text_field( $raw['work']['proj_label_en'] ?? $d['work']['proj_label_en'] ),
		'projects'      => mj_sanitize_project_rows( $raw['work']['projects'] ?? $d['work']['projects'] ),
	);

	$out['testimonials'] = array(
		'heading_fa'        => sanitize_text_field( $raw['testimonials']['heading_fa'] ?? $d['testimonials']['heading_fa'] ),
		'heading_en'        => sanitize_text_field( $raw['testimonials']['heading_en'] ?? $d['testimonials']['heading_en'] ),
		'heading_accent_fa' => sanitize_text_field( $raw['testimonials']['heading_accent_fa'] ?? $d['testimonials']['heading_accent_fa'] ),
		'heading_accent_en' => sanitize_text_field( $raw['testimonials']['heading_accent_en'] ?? $d['testimonials']['heading_accent_en'] ),
		'role_fa'           => sanitize_text_field( $raw['testimonials']['role_fa'] ?? $d['testimonials']['role_fa'] ),
		'role_en'           => sanitize_text_field( $raw['testimonials']['role_en'] ?? $d['testimonials']['role_en'] ),
		'items'             => mj_sanitize_testimonial_rows( $raw['testimonials']['items'] ?? $d['testimonials']['items'] ),
	);

	$contact_keys = array_keys( $d['contact'] );
	$out['contact'] = array();
	foreach ( $contact_keys as $k ) {
		$fn = ( false !== strpos( $k, 'note' ) ) ? 'sanitize_textarea_field' : 'sanitize_text_field';
		$out['contact'][ $k ] = $fn( $raw['contact'][ $k ] ?? $d['contact'][ $k ] );
	}

	return $out;
}

/**
 * @param array $rows Rows.
 * @return array
 */
function mj_sanitize_skill_rows( $rows ) {
	$out = array();
	if ( ! is_array( $rows ) ) {
		return $out;
	}
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$title_fa = sanitize_text_field( $row['title_fa'] ?? '' );
		$title_en = sanitize_text_field( $row['title_en'] ?? '' );
		$icons    = sanitize_text_field( $row['icons'] ?? '' );
		if ( '' === $title_fa && '' === $title_en && '' === $icons ) {
			continue;
		}
		$out[] = compact( 'title_fa', 'title_en', 'icons' );
	}
	return $out;
}

/**
 * @param array $rows Rows.
 * @return array
 */
function mj_sanitize_stage_rows( $rows ) {
	$out = array();
	if ( ! is_array( $rows ) ) {
		return $out;
	}
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$title_fa = sanitize_text_field( $row['title_fa'] ?? '' );
		$title_en = sanitize_text_field( $row['title_en'] ?? '' );
		$stage_fa = sanitize_text_field( $row['stage_fa'] ?? '' );
		$stage_en = sanitize_text_field( $row['stage_en'] ?? '' );
		if ( '' === $title_fa && '' === $title_en ) {
			continue;
		}
		$out[] = compact( 'title_fa', 'title_en', 'stage_fa', 'stage_en' );
	}
	return $out;
}

/**
 * @param array $rows Rows.
 * @return array
 */
function mj_sanitize_service_rows( $rows ) {
	$out = array();
	if ( ! is_array( $rows ) ) {
		return $out;
	}
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$item = array(
			'icon'     => sanitize_text_field( $row['icon'] ?? '' ),
			'title_fa' => sanitize_text_field( $row['title_fa'] ?? '' ),
			'title_en' => sanitize_text_field( $row['title_en'] ?? '' ),
			'desc_fa'  => sanitize_textarea_field( $row['desc_fa'] ?? '' ),
			'desc_en'  => sanitize_textarea_field( $row['desc_en'] ?? '' ),
		);
		if ( '' === $item['title_fa'] && '' === $item['title_en'] ) {
			continue;
		}
		$out[] = $item;
	}
	return $out;
}

/**
 * @param array $rows Rows.
 * @return array
 */
function mj_sanitize_project_rows( $rows ) {
	$out = array();
	if ( ! is_array( $rows ) ) {
		return $out;
	}
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$item = array(
			'image_id'   => absint( $row['image_id'] ?? 0 ),
			'image_file' => sanitize_file_name( $row['image_file'] ?? '' ),
			'url'        => esc_url_raw( $row['url'] ?? '' ),
			'title_fa'   => sanitize_text_field( $row['title_fa'] ?? '' ),
			'title_en'   => sanitize_text_field( $row['title_en'] ?? '' ),
		);
		if ( ! $item['image_id'] && '' === $item['image_file'] && '' === $item['title_fa'] && '' === $item['title_en'] ) {
			continue;
		}
		$out[] = $item;
	}
	return $out;
}

/**
 * @param array $rows Rows.
 * @return array
 */
function mj_sanitize_testimonial_rows( $rows ) {
	$out = array();
	if ( ! is_array( $rows ) ) {
		return $out;
	}
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$item = array(
			'image_id'   => absint( $row['image_id'] ?? 0 ),
			'image_file' => sanitize_file_name( $row['image_file'] ?? '' ),
			'name_fa'    => sanitize_text_field( $row['name_fa'] ?? '' ),
			'name_en'    => sanitize_text_field( $row['name_en'] ?? '' ),
			'msg_fa'     => sanitize_textarea_field( $row['msg_fa'] ?? '' ),
			'msg_en'     => sanitize_textarea_field( $row['msg_en'] ?? '' ),
		);
		if ( '' === $item['name_fa'] && '' === $item['name_en'] && '' === $item['msg_fa'] && '' === $item['msg_en'] ) {
			continue;
		}
		$out[] = $item;
	}
	return $out;
}
