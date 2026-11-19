<?php
/**
 * Admin: Portfolio Settings panel (تنظیمات پورتفولیو).
 *
 * @package HelloChildMJ
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register menu.
 */
function mj_register_settings_menu() {
	add_menu_page(
		__( 'تنظیمات پورتفولیو', 'hello-child-mj' ),
		__( 'تنظیمات پورتفولیو', 'hello-child-mj' ),
		'manage_options',
		'mj-portfolio-settings',
		'mj_render_settings_page',
		'dashicons-art',
		59
	);
}
add_action( 'admin_menu', 'mj_register_settings_menu' );

/**
 * Enqueue admin assets.
 *
 * @param string $hook Hook.
 */
function mj_admin_assets( $hook ) {
	if ( 'toplevel_page_mj-portfolio-settings' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_style(
		'mj-admin-settings',
		mj_theme_file_uri( 'assets/css/admin-settings.css' ),
		array(),
		mj_theme_file_ver( 'assets/css/admin-settings.css' )
	);
	wp_enqueue_script(
		'mj-admin-settings',
		mj_theme_file_uri( 'assets/js/admin-settings.js' ),
		array( 'jquery' ),
		mj_theme_file_ver( 'assets/js/admin-settings.js' ),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'mj_admin_assets' );

/**
 * Save settings: merge posted section into existing option, then sanitize.
 */
function mj_handle_settings_save() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Forbidden', 'hello-child-mj' ) );
	}
	check_admin_referer( 'mj_portfolio_settings_save', 'mj_settings_nonce' );

	$raw     = isset( $_POST['mj'] ) ? wp_unslash( $_POST['mj'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$current = get_option( MJ_OPTION_KEY, array() );
	if ( ! is_array( $current ) ) {
		$current = array();
	}
	$merged = array_replace_recursive( mj_default_settings(), $current, is_array( $raw ) ? $raw : array() );
	$clean  = mj_sanitize_settings( $merged );
	update_option( MJ_OPTION_KEY, $clean, false );

	$tab = isset( $_POST['mj_active_tab'] ) ? sanitize_key( wp_unslash( $_POST['mj_active_tab'] ) ) : 'brand';
	wp_safe_redirect(
		add_query_arg(
			array(
				'page'    => 'mj-portfolio-settings',
				'tab'     => $tab,
				'updated' => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_mj_save_portfolio_settings', 'mj_handle_settings_save' );

/**
 * Reset to defaults.
 */
function mj_handle_settings_reset() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Forbidden', 'hello-child-mj' ) );
	}
	check_admin_referer( 'mj_portfolio_settings_reset', 'mj_reset_nonce' );
	delete_option( MJ_OPTION_KEY );
	mj_flush_settings_cache();
	wp_safe_redirect(
		add_query_arg(
			array(
				'page'   => 'mj-portfolio-settings',
				'reset'  => '1',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_mj_reset_portfolio_settings', 'mj_handle_settings_reset' );

/**
 * Field helpers.
 */
function mj_admin_text( $name, $value, $label, $wide = false ) {
	$id = 'mj_' . preg_replace( '/[^a-z0-9_]/i', '_', $name );
	printf(
		'<p class="mj-field%s"><label for="%s">%s</label><input type="text" class="regular-text%s" id="%s" name="%s" value="%s" /></p>',
		$wide ? ' mj-field--wide' : '',
		esc_attr( $id ),
		esc_html( $label ),
		$wide ? ' large-text' : '',
		esc_attr( $id ),
		esc_attr( $name ),
		esc_attr( $value )
	);
}

function mj_admin_textarea( $name, $value, $label, $rows = 3 ) {
	$id = 'mj_' . preg_replace( '/[^a-z0-9_]/i', '_', $name );
	printf(
		'<p class="mj-field mj-field--wide"><label for="%s">%s</label><textarea class="large-text" rows="%d" id="%s" name="%s">%s</textarea></p>',
		esc_attr( $id ),
		esc_html( $label ),
		(int) $rows,
		esc_attr( $id ),
		esc_attr( $name ),
		esc_textarea( $value )
	);
}

function mj_admin_number( $name, $value, $label ) {
	$id = 'mj_' . preg_replace( '/[^a-z0-9_]/i', '_', $name );
	printf(
		'<p class="mj-field"><label for="%s">%s</label><input type="number" min="0" class="small-text" id="%s" name="%s" value="%s" /></p>',
		esc_attr( $id ),
		esc_html( $label ),
		esc_attr( $id ),
		esc_attr( $name ),
		esc_attr( (string) $value )
	);
}

function mj_admin_url( $name, $value, $label ) {
	$id = 'mj_' . preg_replace( '/[^a-z0-9_]/i', '_', $name );
	printf(
		'<p class="mj-field mj-field--wide"><label for="%s">%s</label><input type="url" class="regular-text large-text" id="%s" name="%s" value="%s" dir="ltr" /></p>',
		esc_attr( $id ),
		esc_html( $label ),
		esc_attr( $id ),
		esc_attr( $name ),
		esc_attr( $value )
	);
}

/**
 * Media picker field.
 *
 * @param string $name Input name for attachment ID.
 * @param int    $id   Attachment ID.
 * @param string $label Label.
 * @param string $preview_fallback Optional preview URL when no attachment.
 */
function mj_admin_media( $name, $id, $label, $preview_fallback = '' ) {
	$id      = absint( $id );
	$preview = $id ? wp_get_attachment_image_url( $id, 'medium' ) : $preview_fallback;
	?>
	<div class="mj-media-field">
		<label><?php echo esc_html( $label ); ?></label>
		<div class="mj-media-field__preview">
			<?php if ( $preview ) : ?>
				<img src="<?php echo esc_url( $preview ); ?>" alt="" />
			<?php else : ?>
				<span class="mj-media-field__empty">—</span>
			<?php endif; ?>
		</div>
		<input type="hidden" class="mj-media-id" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( (string) $id ); ?>" />
		<button type="button" class="button mj-media-select"><?php esc_html_e( 'انتخاب تصویر', 'hello-child-mj' ); ?></button>
		<button type="button" class="button mj-media-clear"><?php esc_html_e( 'حذف', 'hello-child-mj' ); ?></button>
	</div>
	<?php
}

/**
 * Render settings page.
 */
function mj_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$s   = mj_get_settings();
	$tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'brand'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$tabs = array(
		'brand'        => 'عمومی / برند',
		'home'         => 'خانه',
		'about'        => 'درباره من',
		'services'     => 'خدمات',
		'work'         => 'نمونه‌کارها',
		'testimonials' => 'نظرات',
		'contact'      => 'تماس',
		'socials'      => 'شبکه‌های اجتماعی',
		'nav'          => 'منو',
	);
	if ( ! isset( $tabs[ $tab ] ) ) {
		$tab = 'brand';
	}
	?>
	<div class="wrap mj-settings-wrap" dir="rtl">
		<h1><?php esc_html_e( 'تنظیمات پورتفولیو', 'hello-child-mj' ); ?> <span class="mj-ver">v<?php echo esc_html( MJ_THEME_VERSION ); ?></span></h1>
		<p class="description"><?php esc_html_e( 'متن‌ها، تصاویر و لینک‌های سایت را از اینجا ویرایش کنید. انیمیشن‌ها و شِل پورتفولیو در خودِ پوسته باقی می‌مانند.', 'hello-child-mj' ); ?></p>

		<?php if ( isset( $_GET['updated'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'تنظیمات ذخیره شد. در صورت استفاده از کش (LiteSpeed / Cloudflare) آن را پاک کنید.', 'hello-child-mj' ); ?></p></div>
		<?php endif; ?>
		<?php if ( isset( $_GET['reset'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'تنظیمات به پیش‌فرض دمو بازگشت.', 'hello-child-mj' ); ?></p></div>
		<?php endif; ?>

		<nav class="mj-tabs nav-tab-wrapper">
			<?php foreach ( $tabs as $key => $label ) : ?>
				<a class="nav-tab <?php echo $tab === $key ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=mj-portfolio-settings&tab=' . $key ) ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</nav>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="mj-settings-form">
			<input type="hidden" name="action" value="mj_save_portfolio_settings" />
			<input type="hidden" name="mj_active_tab" value="<?php echo esc_attr( $tab ); ?>" />
			<?php wp_nonce_field( 'mj_portfolio_settings_save', 'mj_settings_nonce' ); ?>

			<?php
			// Keep all sections in DOM so unused tabs still submit previous values? 
			// Better: only render active tab fields, but merge on save with existing.
			// We'll merge: sanitize only posted section + keep others from current settings.
			?>
			<div class="mj-tab-panel" data-tab="<?php echo esc_attr( $tab ); ?>">
				<?php
				switch ( $tab ) {
					case 'brand':
						mj_admin_panel_brand( $s );
						break;
					case 'home':
						mj_admin_panel_home( $s );
						break;
					case 'about':
						mj_admin_panel_about( $s );
						break;
					case 'services':
						mj_admin_panel_services( $s );
						break;
					case 'work':
						mj_admin_panel_work( $s );
						break;
					case 'testimonials':
						mj_admin_panel_testimonials( $s );
						break;
					case 'contact':
						mj_admin_panel_contact( $s );
						break;
					case 'socials':
						mj_admin_panel_socials( $s );
						break;
					case 'nav':
						mj_admin_panel_nav( $s );
						break;
				}
				?>
			</div>

			<?php
			// Hidden marker so save handler knows which section to patch.
			printf( '<input type="hidden" name="mj_section" value="%s" />', esc_attr( $tab ) );
			?>

			<p class="submit">
				<button type="submit" class="button button-primary button-hero"><?php esc_html_e( 'ذخیره تغییرات', 'hello-child-mj' ); ?></button>
			</p>
		</form>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="mj-reset-form" onsubmit="return confirm('بازگشت به متن‌های دمو؟ تنظیمات فعلی پاک می‌شود.');">
			<input type="hidden" name="action" value="mj_reset_portfolio_settings" />
			<?php wp_nonce_field( 'mj_portfolio_settings_reset', 'mj_reset_nonce' ); ?>
			<button type="submit" class="button button-link-delete"><?php esc_html_e( 'بازنشانی به پیش‌فرض دمو', 'hello-child-mj' ); ?></button>
		</form>
	</div>
	<?php
}

/* ---------- Panels ---------- */

function mj_admin_panel_brand( $s ) {
	$b = $s['brand'];
	echo '<div class="mj-grid">';
	mj_admin_text( 'mj[brand][owner_name_fa]', $b['owner_name_fa'], 'نام مالک (فارسی)' );
	mj_admin_text( 'mj[brand][owner_name_en]', $b['owner_name_en'], 'Owner name (English)' );
	mj_admin_text( 'mj[brand][meta_title_fa]', $b['meta_title_fa'], 'عنوان صفحه / Meta title FA' );
	mj_admin_text( 'mj[brand][meta_title_en]', $b['meta_title_en'], 'Meta title EN' );
	mj_admin_textarea( 'mj[brand][meta_desc_fa]', $b['meta_desc_fa'], 'توضیح متا FA' );
	mj_admin_textarea( 'mj[brand][meta_desc_en]', $b['meta_desc_en'], 'Meta description EN' );
	echo '</div>';
	echo '<p class="mj-field"><label for="mj_default_locale">زبان پیش‌فرض</label>';
	echo '<select id="mj_default_locale" name="mj[brand][default_locale]">';
	printf( '<option value="fa"%s>فارسی</option>', selected( $b['default_locale'], 'fa', false ) );
	printf( '<option value="en"%s>English</option>', selected( $b['default_locale'], 'en', false ) );
	echo '</select></p>';
	mj_admin_media( 'mj[brand][avatar_id]', (int) $b['avatar_id'], 'آواتار اصلی (خانه / درباره)', mj_img_uri( 'avatar.png' ) );
}

function mj_admin_panel_home( $s ) {
	$h = $s['home'];
	echo '<div class="mj-grid">';
	mj_admin_text( 'mj[home][title_line1_fa]', $h['title_line1_fa'], 'سطر ۱ عنوان FA' );
	mj_admin_text( 'mj[home][title_line1_en]', $h['title_line1_en'], 'Title line 1 EN' );
	mj_admin_text( 'mj[home][title_line2_fa]', $h['title_line2_fa'], 'سطر ۲ قبل از اکسنت FA' );
	mj_admin_text( 'mj[home][title_line2_en]', $h['title_line2_en'], 'Title line 2 EN' );
	mj_admin_text( 'mj[home][title_accent_fa]', $h['title_accent_fa'], 'کلمه اکسنت FA' );
	mj_admin_text( 'mj[home][title_accent_en]', $h['title_accent_en'], 'Accent EN' );
	mj_admin_textarea( 'mj[home][subtitle_fa]', $h['subtitle_fa'], 'زیرعنوان FA', 4 );
	mj_admin_textarea( 'mj[home][subtitle_en]', $h['subtitle_en'], 'Subtitle EN', 4 );
	echo '</div>';
}

function mj_admin_panel_about( $s ) {
	$a = $s['about'];
	echo '<h2>سرتیتر</h2><div class="mj-grid">';
	mj_admin_text( 'mj[about][heading_fa]', $a['heading_fa'], 'heading FA' );
	mj_admin_text( 'mj[about][heading_en]', $a['heading_en'], 'heading EN' );
	mj_admin_text( 'mj[about][heading_accent_fa]', $a['heading_accent_fa'], 'accent FA' );
	mj_admin_text( 'mj[about][heading_accent_en]', $a['heading_accent_en'], 'accent EN' );
	mj_admin_text( 'mj[about][heading_suffix_fa]', $a['heading_suffix_fa'], 'suffix FA' );
	mj_admin_text( 'mj[about][heading_suffix_en]', $a['heading_suffix_en'], 'suffix EN' );
	mj_admin_textarea( 'mj[about][subtitle_fa]', $a['subtitle_fa'], 'متن معرفی FA', 4 );
	mj_admin_textarea( 'mj[about][subtitle_en]', $a['subtitle_en'], 'Intro EN', 4 );
	echo '</div><h2>شمارنده‌ها</h2><div class="mj-grid mj-grid--4">';
	mj_admin_number( 'mj[about][counter_exp]', $a['counter_exp'], 'عدد تجربه' );
	mj_admin_text( 'mj[about][counter_exp_label_fa]', $a['counter_exp_label_fa'], 'برچسب FA' );
	mj_admin_text( 'mj[about][counter_exp_label_en]', $a['counter_exp_label_en'], 'Label EN' );
	echo '<span></span>';
	mj_admin_number( 'mj[about][counter_clients]', $a['counter_clients'], 'عدد مشتریان' );
	mj_admin_text( 'mj[about][counter_cli_label_fa]', $a['counter_cli_label_fa'], 'برچسب FA' );
	mj_admin_text( 'mj[about][counter_cli_label_en]', $a['counter_cli_label_en'], 'Label EN' );
	echo '<span></span>';
	mj_admin_number( 'mj[about][counter_projects]', $a['counter_projects'], 'عدد پروژه‌ها' );
	mj_admin_text( 'mj[about][counter_prj_label_fa]', $a['counter_prj_label_fa'], 'برچسب FA' );
	mj_admin_text( 'mj[about][counter_prj_label_en]', $a['counter_prj_label_en'], 'Label EN' );
	echo '<span></span>';
	mj_admin_number( 'mj[about][counter_awards]', $a['counter_awards'], 'عدد جوایز' );
	mj_admin_text( 'mj[about][counter_awd_label_fa]', $a['counter_awd_label_fa'], 'برچسب FA' );
	mj_admin_text( 'mj[about][counter_awd_label_en]', $a['counter_awd_label_en'], 'Label EN' );
	echo '</div><h2>برچسب تب‌ها</h2><div class="mj-grid">';
	foreach ( array( 'skills', 'awards', 'experience', 'credentials' ) as $t ) {
		mj_admin_text( "mj[about][tab_{$t}_fa]", $a[ "tab_{$t}_fa" ], "تب {$t} FA" );
		mj_admin_text( "mj[about][tab_{$t}_en]", $a[ "tab_{$t}_en" ], "Tab {$t} EN" );
	}
	echo '</div>';

	echo '<h2>مهارت‌ها (آیکون‌ها با ویرگول جدا شوند)</h2>';
	$skills = array_values( $a['skills'] );
	while ( count( $skills ) < 4 ) {
		$skills[] = array( 'title_fa' => '', 'title_en' => '', 'icons' => '' );
	}
	foreach ( $skills as $i => $row ) {
		echo '<div class="mj-repeater-row">';
		printf( '<strong>#%d</strong>', $i + 1 );
		mj_admin_text( "mj[about][skills][{$i}][title_fa]", $row['title_fa'], 'عنوان FA' );
		mj_admin_text( "mj[about][skills][{$i}][title_en]", $row['title_en'], 'Title EN' );
		mj_admin_text( "mj[about][skills][{$i}][icons]", $row['icons'], 'Icons (HTML,CSS,...)', true );
		echo '</div>';
	}

	foreach ( array( 'awards' => 'جوایز', 'experience' => 'سوابق', 'credentials' => 'مدارک' ) as $key => $label ) {
		echo '<h2>' . esc_html( $label ) . '</h2>';
		$rows = array_values( $a[ $key ] );
		while ( count( $rows ) < 4 ) {
			$rows[] = array( 'title_fa' => '', 'title_en' => '', 'stage_fa' => '', 'stage_en' => '' );
		}
		foreach ( $rows as $i => $row ) {
			echo '<div class="mj-repeater-row">';
			printf( '<strong>#%d</strong>', $i + 1 );
			mj_admin_text( "mj[about][{$key}][{$i}][title_fa]", $row['title_fa'], 'عنوان FA' );
			mj_admin_text( "mj[about][{$key}][{$i}][title_en]", $row['title_en'], 'Title EN' );
			mj_admin_text( "mj[about][{$key}][{$i}][stage_fa]", $row['stage_fa'], 'بازه FA' );
			mj_admin_text( "mj[about][{$key}][{$i}][stage_en]", $row['stage_en'], 'Stage EN' );
			echo '</div>';
		}
	}
}

function mj_admin_panel_services( $s ) {
	$sec = $s['services'];
	echo '<div class="mj-grid">';
	mj_admin_text( 'mj[services][heading_fa]', $sec['heading_fa'], 'عنوان FA' );
	mj_admin_text( 'mj[services][heading_en]', $sec['heading_en'], 'Heading EN' );
	mj_admin_textarea( 'mj[services][subtitle_fa]', $sec['subtitle_fa'], 'زیرعنوان FA' );
	mj_admin_textarea( 'mj[services][subtitle_en]', $sec['subtitle_en'], 'Subtitle EN' );
	echo '</div><h2>آیتم‌های خدمات (حداکثر ۶)</h2>';
	$items = array_values( $sec['items'] );
	while ( count( $items ) < 6 ) {
		$items[] = array( 'icon' => '', 'title_fa' => '', 'title_en' => '', 'desc_fa' => '', 'desc_en' => '' );
	}
	foreach ( $items as $i => $row ) {
		echo '<div class="mj-repeater-row">';
		printf( '<strong>خدمت #%d</strong>', $i + 1 );
		mj_admin_text( "mj[services][items][{$i}][icon]", $row['icon'], 'آیکون/ایموجی' );
		mj_admin_text( "mj[services][items][{$i}][title_fa]", $row['title_fa'], 'عنوان FA' );
		mj_admin_text( "mj[services][items][{$i}][title_en]", $row['title_en'], 'Title EN' );
		mj_admin_textarea( "mj[services][items][{$i}][desc_fa]", $row['desc_fa'], 'توضیح FA' );
		mj_admin_textarea( "mj[services][items][{$i}][desc_en]", $row['desc_en'], 'Desc EN' );
		echo '</div>';
	}
}

function mj_admin_panel_work( $s ) {
	$w = $s['work'];
	echo '<div class="mj-grid">';
	mj_admin_text( 'mj[work][heading_fa]', $w['heading_fa'], 'عنوان FA' );
	mj_admin_text( 'mj[work][heading_en]', $w['heading_en'], 'Heading EN' );
	mj_admin_textarea( 'mj[work][subtitle_fa]', $w['subtitle_fa'], 'زیرعنوان FA' );
	mj_admin_textarea( 'mj[work][subtitle_en]', $w['subtitle_en'], 'Subtitle EN' );
	mj_admin_text( 'mj[work][live_label_fa]', $w['live_label_fa'], 'برچسب LIVE FA' );
	mj_admin_text( 'mj[work][live_label_en]', $w['live_label_en'], 'LIVE EN' );
	mj_admin_text( 'mj[work][proj_label_fa]', $w['proj_label_fa'], 'برچسب پروژه FA' );
	mj_admin_text( 'mj[work][proj_label_en]', $w['proj_label_en'], 'Project EN' );
	echo '</div><h2>پروژه‌ها (۸ اسلات — در اسلایدر ۴تایی نمایش داده می‌شوند)</h2>';
	$projects = array_values( $w['projects'] );
	while ( count( $projects ) < 8 ) {
		$projects[] = array( 'image_id' => 0, 'image_file' => '', 'url' => '', 'title_fa' => '', 'title_en' => '' );
	}
	foreach ( $projects as $i => $row ) {
		$fb = ! empty( $row['image_file'] ) ? mj_img_uri( $row['image_file'] ) : '';
		echo '<div class="mj-repeater-row">';
		printf( '<strong>پروژه #%d</strong>', $i + 1 );
		mj_admin_media( "mj[work][projects][{$i}][image_id]", (int) $row['image_id'], 'تصویر', $fb );
		printf( '<input type="hidden" name="mj[work][projects][%d][image_file]" value="%s" />', $i, esc_attr( $row['image_file'] ) );
		mj_admin_url( "mj[work][projects][{$i}][url]", $row['url'], 'لینک پروژه' );
		mj_admin_text( "mj[work][projects][{$i}][title_fa]", $row['title_fa'], 'عنوان FA' );
		mj_admin_text( "mj[work][projects][{$i}][title_en]", $row['title_en'], 'Title EN' );
		echo '</div>';
	}
}

function mj_admin_panel_testimonials( $s ) {
	$t = $s['testimonials'];
	echo '<div class="mj-grid">';
	mj_admin_text( 'mj[testimonials][heading_fa]', $t['heading_fa'], 'عنوان FA' );
	mj_admin_text( 'mj[testimonials][heading_en]', $t['heading_en'], 'Heading EN' );
	mj_admin_text( 'mj[testimonials][heading_accent_fa]', $t['heading_accent_fa'], 'اکسنت FA' );
	mj_admin_text( 'mj[testimonials][heading_accent_en]', $t['heading_accent_en'], 'Accent EN' );
	mj_admin_text( 'mj[testimonials][role_fa]', $t['role_fa'], 'نقش FA' );
	mj_admin_text( 'mj[testimonials][role_en]', $t['role_en'], 'Role EN' );
	echo '</div><h2>نظرات (حداکثر ۵)</h2>';
	$items = array_values( $t['items'] );
	while ( count( $items ) < 5 ) {
		$items[] = array( 'image_id' => 0, 'image_file' => '', 'name_fa' => '', 'name_en' => '', 'msg_fa' => '', 'msg_en' => '' );
	}
	foreach ( $items as $i => $row ) {
		$fb = ! empty( $row['image_file'] ) ? mj_img_uri( $row['image_file'] ) : '';
		echo '<div class="mj-repeater-row">';
		printf( '<strong>نظر #%d</strong>', $i + 1 );
		mj_admin_media( "mj[testimonials][items][{$i}][image_id]", (int) $row['image_id'], 'آواتار', $fb );
		printf( '<input type="hidden" name="mj[testimonials][items][%d][image_file]" value="%s" />', $i, esc_attr( $row['image_file'] ) );
		mj_admin_text( "mj[testimonials][items][{$i}][name_fa]", $row['name_fa'], 'نام FA' );
		mj_admin_text( "mj[testimonials][items][{$i}][name_en]", $row['name_en'], 'Name EN' );
		mj_admin_textarea( "mj[testimonials][items][{$i}][msg_fa]", $row['msg_fa'], 'متن FA' );
		mj_admin_textarea( "mj[testimonials][items][{$i}][msg_en]", $row['msg_en'], 'Message EN' );
		echo '</div>';
	}
}

function mj_admin_panel_contact( $s ) {
	$c = $s['contact'];
	echo '<div class="mj-grid">';
	foreach ( $c as $k => $v ) {
		$label = $k;
		if ( false !== strpos( $k, 'note' ) ) {
			mj_admin_textarea( "mj[contact][{$k}]", $v, $label );
		} else {
			mj_admin_text( "mj[contact][{$k}]", $v, $label );
		}
	}
	echo '</div>';
}

function mj_admin_panel_socials( $s ) {
	echo '<div class="mj-grid">';
	foreach ( $s['socials'] as $net => $url ) {
		mj_admin_url( "mj[socials][{$net}]", $url, ucfirst( $net ) );
	}
	echo '</div>';
}

function mj_admin_panel_nav( $s ) {
	echo '<div class="mj-grid">';
	foreach ( $s['nav'] as $k => $v ) {
		mj_admin_text( "mj[nav][{$k}]", $v, $k );
	}
	echo '</div>';
}
