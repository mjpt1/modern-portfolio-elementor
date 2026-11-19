<?php
/**
 * Hello Child MJ Portfolio — Hello Elementor child theme.
 *
 * @package HelloChildMJ
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MJ_THEME_VERSION', '1.1.1' );
define( 'MJ_THEME_DIR', get_stylesheet_directory() );
define( 'MJ_THEME_URI', get_stylesheet_directory_uri() );

require_once MJ_THEME_DIR . '/inc/bootstrap.php';

// --------------------------------------------------------------------------------------------------- Start RTL License
$rtlLicenseClassName = 'RTL_License_34993e08830e4d32';
$rtlLicenseFilePath  = __DIR__ . DIRECTORY_SEPARATOR . $rtlLicenseClassName . '.php';
$rtlLicenseFileHash  = @sha1_file( $rtlLicenseFilePath );

if ( $rtlLicenseFileHash === '8d0148b7dbaa15f621989d47bf73b49d42ce648b' && file_exists( $rtlLicenseFilePath ) ) {
	require_once $rtlLicenseFilePath;

	if ( class_exists( $rtlLicenseClassName ) && method_exists( $rtlLicenseClassName, 'isActive' ) ) {
		$rtlLicenseClass = new $rtlLicenseClassName();

		if ( $rtlLicenseClass->{'isActive'}() === true ) {
			// Product is Active Now, Enable Pro Features
			if ( ! defined( 'MJ_LICENSE_ACTIVE' ) ) {
				define( 'MJ_LICENSE_ACTIVE', true );
			}
			mj_bootstrap_pro_features();
		}
	}
}
if ( ! defined( 'MJ_LICENSE_ACTIVE' ) ) {
	define( 'MJ_LICENSE_ACTIVE', false );
}
// ----------------------------------------------------------------------------------------------------- End RTL License

/**
 * Theme-relative asset URL (robust under child theme / symlinks).
 *
 * @param string $relative Path under the child theme, e.g. 'assets/img/avatar.png'.
 * @return string
 */
function mj_theme_file_uri( $relative ) {
	$relative = ltrim( str_replace( '\\', '/', $relative ), '/' );
	if ( function_exists( 'get_theme_file_uri' ) ) {
		return get_theme_file_uri( $relative );
	}
	return trailingslashit( MJ_THEME_URI ) . $relative;
}

/**
 * Cache-bust version from filemtime, falling back to theme version.
 *
 * @param string $relative Path under the child theme.
 * @return string
 */
function mj_theme_file_ver( $relative ) {
	$relative = ltrim( str_replace( '\\', '/', $relative ), '/' );
	$path     = trailingslashit( MJ_THEME_DIR ) . $relative;
	if ( file_exists( $path ) ) {
		return (string) filemtime( $path );
	}
	return MJ_THEME_VERSION;
}

/**
 * Image URL with ?ver=filemtime (or theme version) for LiteSpeed / browser cache busting.
 *
 * @param string $filename File under assets/img/, e.g. 'avatar.png'.
 * @return string
 */
function mj_img_uri( $filename ) {
	$relative = 'assets/img/' . ltrim( $filename, '/' );
	$uri      = mj_theme_file_uri( $relative );
	return add_query_arg( 'ver', mj_theme_file_ver( $relative ), $uri );
}

/**
 * Theme setup.
 */
function mj_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'mj_theme_setup' );

/**
 * Enqueue fonts, CSS, JS (Swiper + tsparticles via CDN).
 * IMPORTANT: do NOT use handle "swiper" — Elementor registers it and steals our enqueue.
 */
function mj_enqueue_assets() {
	$parent_deps = array();
	if ( wp_get_theme()->parent() ) {
		wp_enqueue_style(
			'hello-elementor-parent',
			get_template_directory_uri() . '/style.css',
			array(),
			wp_get_theme( 'hello-elementor' )->get( 'Version' )
		);
		$parent_deps[] = 'hello-elementor-parent';
	}

	wp_enqueue_style(
		'hello-child-mj',
		get_stylesheet_uri(),
		$parent_deps,
		mj_theme_file_ver( 'style.css' )
	);

	wp_enqueue_style(
		'mj-fonts',
		'https://fonts.googleapis.com/css2?family=Sora:wght@100;200;300;400;500;600;700;800&family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'mj-portfolio',
		mj_theme_file_uri( 'assets/css/portfolio.css' ),
		array( 'mj-fonts', 'hello-child-mj' ),
		mj_theme_file_ver( 'assets/css/portfolio.css' )
	);

	wp_enqueue_style(
		'mj-rtl',
		mj_theme_file_uri( 'assets/css/rtl.css' ),
		array( 'mj-portfolio' ),
		mj_theme_file_ver( 'assets/css/rtl.css' )
	);

	wp_enqueue_style(
		'mj-swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
		array(),
		'11.0.0'
	);

	wp_enqueue_script(
		'mj-swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
		array(),
		'11.0.0',
		true
	);

	wp_enqueue_script(
		'mj-tsparticles',
		'https://cdn.jsdelivr.net/npm/tsparticles@2.12.0/tsparticles.bundle.min.js',
		array(),
		'2.12.0',
		true
	);

	wp_enqueue_script(
		'mj-locale',
		mj_theme_file_uri( 'assets/js/locale.js' ),
		array(),
		mj_theme_file_ver( 'assets/js/locale.js' ),
		true
	);

	wp_enqueue_script(
		'mj-page-transition',
		mj_theme_file_uri( 'assets/js/page-transition.js' ),
		array(),
		mj_theme_file_ver( 'assets/js/page-transition.js' ),
		true
	);

	wp_enqueue_script(
		'mj-fade-in',
		mj_theme_file_uri( 'assets/js/fade-in.js' ),
		array(),
		mj_theme_file_ver( 'assets/js/fade-in.js' ),
		true
	);

	wp_enqueue_script(
		'mj-particles',
		mj_theme_file_uri( 'assets/js/particles.js' ),
		array( 'mj-tsparticles' ),
		mj_theme_file_ver( 'assets/js/particles.js' ),
		true
	);

	wp_enqueue_script(
		'mj-countup',
		mj_theme_file_uri( 'assets/js/countup.js' ),
		array(),
		mj_theme_file_ver( 'assets/js/countup.js' ),
		true
	);

	wp_enqueue_script(
		'mj-tabs',
		mj_theme_file_uri( 'assets/js/tabs.js' ),
		array(),
		mj_theme_file_ver( 'assets/js/tabs.js' ),
		true
	);

	wp_enqueue_script(
		'mj-swiper-init',
		mj_theme_file_uri( 'assets/js/swiper-init.js' ),
		array( 'mj-swiper' ),
		mj_theme_file_ver( 'assets/js/swiper-init.js' ),
		true
	);

	$default_locale = mj_setting( 'brand.default_locale', 'fa' );
	if ( ! in_array( $default_locale, array( 'fa', 'en' ), true ) ) {
		$default_locale = 'fa';
	}

	wp_localize_script(
		'mj-locale',
		'MJPortfolio',
		array(
			'imgBase'       => trailingslashit( mj_theme_file_uri( 'assets/img' ) ),
			'homeUrl'       => home_url( '/' ),
			'storageKey'    => 'modern-portfolio-locale',
			'defaultLocale' => $default_locale,
			'themeVer'      => MJ_THEME_VERSION,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'mj_enqueue_assets', 20 );

/**
 * Body classes for locale + portfolio shell.
 */
function mj_body_classes( $classes ) {
	$classes[] = 'mj-portfolio';
	$classes[] = 'mj-locale-fa'; // JS flips to mj-locale-en
	return $classes;
}
add_filter( 'body_class', 'mj_body_classes' );

/**
 * Prefer RTL dir early (default locale is FA) so first paint matches portfolio.
 */
function mj_html_dir_attr( $output ) {
	if ( false === strpos( $output, 'dir=' ) ) {
		$output .= ' dir="rtl"';
	}
	return $output;
}
add_filter( 'language_attributes', 'mj_html_dir_attr' );

/**
 * Inject page wipe layers + top-left decoration early in body.
 */
function mj_body_open_shell() {
	?>
	<div id="mj-page-wipe" class="mj-page-wipe" aria-hidden="true">
		<span class="mj-wipe mj-wipe-1"></span>
		<span class="mj-wipe mj-wipe-2"></span>
		<span class="mj-wipe mj-wipe-3"></span>
	</div>
	<div class="mj-top-left-img" aria-hidden="true">
		<img src="<?php echo esc_url( mj_img_uri( 'top-left-img.png' ) ); ?>" alt="" width="400" height="400" loading="eager" decoding="async" />
	</div>
	<?php
}
add_action( 'wp_body_open', 'mj_body_open_shell', 5 );

/**
 * Fixed icon nav + site header shell (outside Elementor canvas).
 */
function mj_render_site_shell() {
	$pages   = mj_get_nav_map();
	$socials = mj_setting( 'socials', array() );
	$name_fa = mj_setting( 'brand.owner_name_fa', 'محسن جباره اصل' );
	$name_en = mj_setting( 'brand.owner_name_en', 'Mohsen Jabbarehasl' );
	?>
	<header class="mj-header" role="banner">
		<div class="mj-header__inner">
			<a class="mj-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="mj-only-fa"><?php echo esc_html( $name_fa ); ?></span>
				<span class="mj-only-en"><?php echo esc_html( $name_en ); ?></span><span class="mj-accent" aria-hidden="true">.</span>
			</a>
			<div class="mj-header__actions">
				<div class="mj-locale" role="group" aria-label="Language / زبان">
					<button type="button" class="mj-locale__btn" data-locale="fa" aria-pressed="true">فارسی</button>
					<button type="button" class="mj-locale__btn" data-locale="en" aria-pressed="false">English</button>
				</div>
				<nav class="mj-socials" aria-label="Social">
					<?php
					$icons = array(
						'youtube'   => '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path fill="currentColor" d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.6 31.6 0 0 0 0 12a31.6 31.6 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.6 31.6 0 0 0 24 12a31.6 31.6 0 0 0-.5-5.8zM9.75 15.5v-7l6.5 3.5-6.5 3.5z"/></svg>',
						'instagram' => '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path fill="currentColor" d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.9a1.1 1.1 0 1 0 0 2.2 1.1 1.1 0 0 0 0-2.2zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/></svg>',
						'facebook'  => '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path fill="currentColor" d="M14 8h3V5h-3c-2.2 0-4 1.8-4 4v2H7v3h3v7h3v-7h3l1-3h-4V9c0-.6.4-1 1-1z"/></svg>',
						'dribbble'  => '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path fill="currentColor" d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm6.6 4.7a8 8 0 0 1 1.3 4.1c-.2 0-2.3-.1-4.4-.5-.2-.4-.3-.8-.5-1.2 2.4-1 3.4-2.3 3.6-2.4zM12 4c1.7 0 3.3.6 4.6 1.5-.2.2-1.4 1.7-3.8 2.7A23 23 0 0 0 9.2 4.4 8 8 0 0 1 12 4zM7.7 5.2c.8.1 2.8.6 4.5 2.1A34 34 0 0 0 8.6 12c-2-.4-3.9-.4-4.3-.4A8 8 0 0 1 7.7 5.2zM4 12.1c.5 0 2.7 0 5 .5-.2.5-.4 1-.6 1.5C5.7 15 4.4 17 4.2 17.3A8 8 0 0 1 4 12.1zm8 7.9a8 8 0 0 1-4.8-1.6c.1-.3 1.2-2.2 3.8-3.4.1 0 .2-.1.3-.1 1 2.6 1.4 4.8 1.5 5.4A8 8 0 0 1 12 20zm2.7-1c-.1-.5-.5-2.5-1.4-5 .1 0 .2-.1.3-.1 2.4.4 4.6.5 4.9.5a8 8 0 0 1-3.8 4.6z"/></svg>',
						'pinterest' => '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path fill="currentColor" d="M12 2C6.5 2 2 6.5 2 12c0 4.2 2.6 7.8 6.3 9.2-.1-.8-.2-2 0-2.9.2-.8 1.3-5.4 1.3-5.4s-.3-.7-.3-1.7c0-1.6.9-2.8 2.1-2.8 1 0 1.5.7 1.5 1.6 0 1-.6 2.4-.9 3.8-.3 1.1.5 2 1.6 2 1.9 0 3.2-2.4 3.2-5.3 0-2.2-1.5-3.8-4.2-3.8-3.1 0-5 2.3-5 4.8 0 .9.3 1.8.7 2.3.1.1.1.2.1.3l-.3 1.1c0 .2-.1.2-.3.1-1.3-.5-2-2-2-3.6 0-2.7 2.3-5.9 6.7-5.9 3.6 0 6 2.6 6 5.4 0 3.7-2.1 6.5-5.1 6.5-1 0-2-.6-2.3-1.2l-.6 2.4c-.2.9-.8 1.9-1.2 2.6A10 10 0 0 0 12 22c5.5 0 10-4.5 10-10S17.5 2 12 2z"/></svg>',
						'github'    => '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M12 2C6.5 2 2 6.6 2 12.2c0 4.5 2.9 8.3 6.9 9.6.5.1.7-.2.7-.5v-1.8c-2.8.6-3.4-1.4-3.4-1.4-.4-1.1-1.1-1.4-1.1-1.4-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.6 2.4 1.1 3 .9.1-.7.4-1.1.6-1.4-2.2-.3-4.6-1.2-4.6-5.1 0-1.1.4-2 1-2.7-.1-.3-.4-1.3.1-2.7 0 0 .8-.3 2.8 1a9.3 9.3 0 0 1 5 0c2-.1 2.8-1 2.8-1 .5 1.4.2 2.4.1 2.7.6.7 1 1.6 1 2.7 0 4-2.3 4.8-4.6 5.1.4.3.7 1 .7 2v3c0 .3.2.6.7.5A10.2 10.2 0 0 0 22 12.2C22 6.6 17.5 2 12 2z"/></svg>',
					);
					foreach ( $icons as $net => $svg ) :
						$url = ! empty( $socials[ $net ] ) ? $socials[ $net ] : '';
						if ( ! $url ) {
							continue;
						}
						$cls = ( 'github' === $net ) ? ' class="mj-socials__github"' : '';
						?>
					<a<?php echo $cls; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( ucfirst( $net ) ); ?>"><?php echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text"><?php echo esc_html( ucfirst( $net ) ); ?></span></a>
					<?php endforeach; ?>
				</nav>
			</div>
		</div>
	</header>

	<nav class="mj-nav" aria-label="Primary">
		<div class="mj-nav__bar">
			<?php foreach ( $pages as $key => $item ) : ?>
				<a class="mj-nav__link<?php echo mj_is_nav_active( $item['slug'] ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( $item['url'] ); ?>" data-nav="<?php echo esc_attr( $key ); ?>">
					<span class="mj-nav__tooltip">
						<span class="mj-only-fa"><?php echo esc_html( $item['label_fa'] ); ?></span>
						<span class="mj-only-en"><?php echo esc_html( $item['label_en'] ); ?></span>
					</span>
					<span class="mj-nav__icon" aria-hidden="true"><?php echo $item['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span class="screen-reader-text">
						<span class="mj-only-fa"><?php echo esc_html( $item['label_fa'] ); ?></span>
						<span class="mj-only-en"><?php echo esc_html( $item['label_en'] ); ?></span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</nav>
	<?php
}
add_action( 'wp_body_open', 'mj_render_site_shell', 10 );

/**
 * Nav map (pages created on theme switch).
 */
function mj_get_nav_map() {
	$nav = mj_setting( 'nav', array() );
	$slugs = array(
		'home'         => array( 'slug' => 'home', 'label_fa' => $nav['home_fa'] ?? 'خانه', 'label_en' => $nav['home_en'] ?? 'home', 'icon' => mj_icon_home() ),
		'about'        => array( 'slug' => 'about', 'label_fa' => $nav['about_fa'] ?? 'درباره من', 'label_en' => $nav['about_en'] ?? 'about', 'icon' => mj_icon_user() ),
		'services'     => array( 'slug' => 'services', 'label_fa' => $nav['services_fa'] ?? 'خدمات', 'label_en' => $nav['services_en'] ?? 'services', 'icon' => mj_icon_grid() ),
		'work'         => array( 'slug' => 'work', 'label_fa' => $nav['work_fa'] ?? 'نمونه‌کارها', 'label_en' => $nav['work_en'] ?? 'work', 'icon' => mj_icon_cols() ),
		'testimonials' => array( 'slug' => 'testimonials', 'label_fa' => $nav['testimonials_fa'] ?? 'نظرات', 'label_en' => $nav['testimonials_en'] ?? 'testimonials', 'icon' => mj_icon_chat() ),
		'contact'      => array( 'slug' => 'contact', 'label_fa' => $nav['contact_fa'] ?? 'تماس', 'label_en' => $nav['contact_en'] ?? 'contact', 'icon' => mj_icon_mail() ),
	);

	foreach ( $slugs as $key => &$item ) {
		if ( 'home' === $item['slug'] ) {
			$item['url'] = home_url( '/' );
		} else {
			$page = get_page_by_path( $item['slug'] );
			$item['url'] = $page ? get_permalink( $page ) : home_url( '/' . $item['slug'] . '/' );
		}
	}
	unset( $item );

	return $slugs;
}

function mj_is_nav_active( $slug ) {
	if ( 'home' === $slug ) {
		return is_front_page();
	}
	return is_page( $slug );
}

/** Inline SVG icons (Heroicons-style). */
function mj_icon_home() {
	return '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M11.47 3.84a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 1-1.06 1.06l-.72-.72V20.25A1.75 1.75 0 0 1 17.69 22H6.31A1.75 1.75 0 0 1 4.56 20.25v-7.38l-.72.72a.75.75 0 0 1-1.06-1.06l8.69-8.69z"/></svg>';
}
function mj_icon_user() {
	return '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M12 12a4.5 4.5 0 1 0-4.5-4.5A4.5 4.5 0 0 0 12 12zm0 1.5c-4.1 0-7.5 2.1-7.5 4.75V19.5A.75.75 0 0 0 5.25 20.25h13.5A.75.75 0 0 0 19.5 19.5v-1.25C19.5 15.6 16.1 13.5 12 13.5z"/></svg>';
}
function mj_icon_grid() {
	return '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h3A2.25 2.25 0 0 1 11.25 6v3A2.25 2.25 0 0 1 9 11.25H6A2.25 2.25 0 0 1 3.75 9V6zm9 0A2.25 2.25 0 0 1 15 3.75h3A2.25 2.25 0 0 1 20.25 6v3A2.25 2.25 0 0 1 18 11.25h-3A2.25 2.25 0 0 1 12.75 9V6zm-9 9A2.25 2.25 0 0 1 6 12.75h3A2.25 2.25 0 0 1 11.25 15v3A2.25 2.25 0 0 1 9 20.25H6A2.25 2.25 0 0 1 3.75 18v-3zm9 0A2.25 2.25 0 0 1 15 12.75h3A2.25 2.25 0 0 1 20.25 15v3A2.25 2.25 0 0 1 18 20.25h-3A2.25 2.25 0 0 1 12.75 18v-3z"/></svg>';
}
function mj_icon_cols() {
	return '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M9 4.5a.75.75 0 0 0-.75.75v13.5c0 .41.34.75.75.75h6a.75.75 0 0 0 .75-.75V5.25A.75.75 0 0 0 15 4.5H9zM4.5 6.75A.75.75 0 0 1 5.25 6h1.5a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V6.75zM17.25 6a.75.75 0 0 0-.75.75v10.5c0 .41.34.75.75.75h1.5a.75.75 0 0 0 .75-.75V6.75A.75.75 0 0 0 18.75 6h-1.5z"/></svg>';
}
function mj_icon_chat() {
	return '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M4.913 2.658A2.25 2.25 0 0 1 6.956 2.25h10.088a2.25 2.25 0 0 1 2.043 1.408l2.18 5.993a1.5 1.5 0 0 1-.145 1.352l-6.76 9.72a1.5 1.5 0 0 1-2.424 0l-6.76-9.72a1.5 1.5 0 0 1-.145-1.352l2.18-5.993zM7.5 7.5a.75.75 0 0 0 0 1.5h9a.75.75 0 0 0 0-1.5h-9z"/></svg>';
}
function mj_icon_mail() {
	return '<svg viewBox="0 0 24 24" width="1em" height="1em" fill="currentColor"><path d="M1.5 8.67v8.58A2.25 2.25 0 0 0 3.75 19.5h16.5a2.25 2.25 0 0 0 2.25-2.25V8.67l-8.69 5.43a3 3 0 0 1-3.12 0L1.5 8.67zM22.5 6.908V6.75A2.25 2.25 0 0 0 20.25 4.5H3.75A2.25 2.25 0 0 0 1.5 6.75v.158l9.69 6.056a1.5 1.5 0 0 0 1.62 0L22.5 6.908z"/></svg>';
}

/**
 * Shortcodes for Elementor Shortcode / HTML widgets.
 */
function mj_load_partial( $name ) {
	$file = MJ_THEME_DIR . '/partials/' . $name . '.php';
	if ( ! file_exists( $file ) ) {
		return '<!-- mj partial missing: ' . esc_html( $name ) . ' -->';
	}
	ob_start();
	include $file;
	return ob_get_clean();
}

function mj_shortcode_home() {
	return mj_load_partial( 'home' );
}
function mj_shortcode_about() {
	return mj_load_partial( 'about' );
}
function mj_shortcode_services() {
	return mj_load_partial( 'services' );
}
function mj_shortcode_work() {
	return mj_load_partial( 'work' );
}
function mj_shortcode_testimonials() {
	return mj_load_partial( 'testimonials' );
}
function mj_shortcode_contact() {
	return mj_load_partial( 'contact' );
}

add_shortcode( 'mj_home', 'mj_shortcode_home' );
add_shortcode( 'mj_about', 'mj_shortcode_about' );
add_shortcode( 'mj_services', 'mj_shortcode_services' );
add_shortcode( 'mj_work', 'mj_shortcode_work' );
add_shortcode( 'mj_testimonials', 'mj_shortcode_testimonials' );
add_shortcode( 'mj_contact', 'mj_shortcode_contact' );

/**
 * Create demo pages on theme activation — no shortcodes; templates render via slug.
 */
function mj_activate_demo_pages() {
	$pages = array(
		'home'         => array( 'title' => 'Home / خانه', 'template' => 'templates/home.php', 'is_front' => true ),
		'about'        => array( 'title' => 'About / درباره من', 'template' => 'templates/about.php' ),
		'services'     => array( 'title' => 'Services / خدمات', 'template' => 'templates/services.php' ),
		'work'         => array( 'title' => 'Work / نمونه‌کارها', 'template' => 'templates/work.php' ),
		'testimonials' => array( 'title' => 'Testimonials / نظرات', 'template' => 'templates/testimonials.php' ),
		'contact'      => array( 'title' => 'Contact / تماس', 'template' => 'templates/contact.php' ),
	);

	$front_id = 0;

	foreach ( $pages as $slug => $cfg ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			// Clear legacy shortcodes from content; routing uses template_include.
			$content = (string) $existing->post_content;
			if ( false !== strpos( $content, '[mj_' ) ) {
				wp_update_post(
					array(
						'ID'           => $existing->ID,
						'post_content' => '',
					)
				);
			}
			if ( ! empty( $cfg['template'] ) ) {
				update_post_meta( $existing->ID, '_wp_page_template', $cfg['template'] );
			}
			if ( ! empty( $cfg['is_front'] ) ) {
				$front_id = $existing->ID;
			}
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_title'   => $cfg['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);

		if ( ! is_wp_error( $id ) ) {
			if ( ! empty( $cfg['template'] ) ) {
				update_post_meta( $id, '_wp_page_template', $cfg['template'] );
			}
			if ( ! empty( $cfg['is_front'] ) ) {
				$front_id = $id;
			}
		}
	}

	if ( $front_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_id );
	}
}
add_action( 'after_switch_theme', 'mj_activate_demo_pages' );

/**
 * One-time upgrade: strip shortcodes + assign templates for existing installs.
 */
function mj_maybe_upgrade_110() {
	if ( get_option( 'mj_upgraded_110' ) ) {
		return;
	}
	mj_activate_demo_pages();
	update_option( 'mj_upgraded_110', MJ_THEME_VERSION, false );
}
add_action( 'init', 'mj_maybe_upgrade_110', 5 );

/**
 * Hide Hello Elementor default header/footer chrome when Elementor Hello theme header is unused.
 * Our shell replaces it.
 */
function mj_dequeue_hello_header_footer() {
	wp_dequeue_style( 'hello-elementor-header-footer' );
}
add_action( 'wp_enqueue_scripts', 'mj_dequeue_hello_header_footer', 30 );

/**
 * Soften Elementor / Hello layout CSS that fights the full-bleed portfolio shell.
 */
function mj_print_conflict_overrides() {
	if ( is_admin() ) {
		return;
	}
	?>
	<style id="mj-conflict-overrides">
		body.mj-portfolio .site-header,
		body.mj-portfolio .site-footer,
		body.mj-portfolio header.site-header,
		body.mj-portfolio footer.site-footer,
		body.mj-portfolio .ehf-header,
		body.mj-portfolio .ehf-footer,
		body.mj-portfolio #site-header,
		body.mj-portfolio #site-footer,
		body.mj-portfolio .page-header,
		body.mj-portfolio .entry-title,
		body.mj-portfolio .hello-elementor-page-title,
		body.mj-portfolio .elementor-location-header,
		body.mj-portfolio .elementor-location-footer {
			display: none !important;
			height: 0 !important;
			min-height: 0 !important;
			overflow: hidden !important;
			margin: 0 !important;
			padding: 0 !important;
		}
		body.mj-portfolio .elementor-section.elementor-section-boxed > .elementor-container,
		body.mj-portfolio .e-con {
			max-width: none !important;
		}
		body.mj-portfolio img.mj-avatar-img {
			background: transparent !important;
			box-shadow: none !important;
			border: 0 !important;
		}
		/* 1.0.4 stacking guards — bg/particles never cover copy */
		body.mj-portfolio .mj-top-left-img {
			z-index: 0 !important;
			pointer-events: none !important;
		}
		body.mj-portfolio .mj-site-main {
			position: relative !important;
			z-index: 10 !important;
		}
		body.mj-portfolio .mj-header {
			z-index: 40 !important;
		}
		body.mj-portfolio .mj-nav {
			z-index: 50 !important;
		}
		body.mj-portfolio .mj-home__stage,
		body.mj-portfolio .mj-home__explosion,
		body.mj-portfolio #mj-particles,
		body.mj-portfolio #mj-particles canvas {
			z-index: 0 !important;
			pointer-events: none !important;
		}
		body.mj-portfolio .mj-home__gradient,
		body.mj-portfolio .mj-home__content {
			position: relative !important;
			z-index: 20 !important;
		}
		body.mj-portfolio .mj-home__avatar {
			z-index: 5 !important;
			pointer-events: none !important;
		}
		body.mj-portfolio .mj-circles,
		body.mj-portfolio .mj-bulb {
			z-index: 0 !important;
			pointer-events: none !important;
		}
		body.mj-portfolio .mj-about__grid {
			position: relative !important;
			z-index: 10 !important;
		}
		body.mj-portfolio .mj-about__avatar,
		body.mj-portfolio .mj-about .mj-circles {
			z-index: 0 !important;
			pointer-events: none !important;
		}
		body.mj-portfolio .mj-about__left,
		body.mj-portfolio .mj-about__tabs {
			position: relative !important;
			z-index: 11 !important;
		}
		body.mj-portfolio .mj-tabs__panel {
			display: none !important;
		}
		body.mj-portfolio .mj-tabs__panel.is-active {
			display: flex !important;
		}
		body.mj-portfolio .mj-tabs__panel[hidden] {
			display: none !important;
		}
		/* 1.1.0 — full-viewport shell; kill Hello rem shrink + page scrollbars */
		html {
			font-size: 100% !important;
			font-size: 16px !important;
			overflow: hidden !important;
			height: 100% !important;
			height: 100dvh !important;
		}
		body.mj-portfolio {
			font-size: 16px !important;
			overflow: hidden !important;
			height: 100dvh !important;
			max-height: 100dvh !important;
		}
		body.mj-portfolio #page,
		body.mj-portfolio .site,
		body.mj-portfolio .site-content,
		body.mj-portfolio #content,
		body.mj-portfolio #mj-content,
		body.mj-portfolio .mj-site-main,
		body.mj-portfolio .elementor,
		body.mj-portfolio .page-content,
		body.mj-portfolio .entry-content {
			overflow: hidden !important;
			max-height: 100dvh !important;
			height: 100% !important;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'mj_print_conflict_overrides', 100 );

/**
 * Demo contact form stub (replace with CF7 / Elementor Form in production).
 */
function mj_contact_stub_handler() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/contact/' );
	wp_safe_redirect( add_query_arg( 'mj_sent', '1', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_mj_contact_stub', 'mj_contact_stub_handler' );
add_action( 'admin_post_mj_contact_stub', 'mj_contact_stub_handler' );

/**
 * Admin notice: license / Portfolio Settings reminders.
 */
function mj_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( ! MJ_LICENSE_ACTIVE ) {
		echo '<div class="notice notice-warning"><p><strong>Hello Child MJ:</strong> لایسنس فعال نیست. برای دسترسی به پنل <em>تنظیمات پورتفولیو</em>، لایسنس راست‌چین را از منوی فعال‌سازی RTL فعال کنید. تا قبل از فعال‌سازی، سایت با محتوای دمو کار می‌کند.</p></div>';
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'themes' !== $screen->id ) {
		return;
	}
	echo '<div class="notice notice-info"><p><strong>Hello Child MJ 1.1.1:</strong> محتوا را از منوی <em>تنظیمات پورتفولیو</em> ویرایش کنید (بدون شورت‌کد). پس از آپلود، کش LiteSpeed / Cloudflare را پاک کنید.</p></div>';
}
add_action( 'admin_notices', 'mj_admin_notice' );
