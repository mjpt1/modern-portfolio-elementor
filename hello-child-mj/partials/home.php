<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$h    = mj_setting( 'home', array() );
$work = home_url( '/work/' );
?>
<section class="mj-page mj-home" data-mj-page="home">
	<div class="mj-home__gradient">
		<div class="mj-container mj-home__content">
			<h1 class="mj-h1 mj-fade" data-dir="down" data-delay="0.2" data-mj-above-fold="1">
				<span class="mj-block-fa"><?php echo esc_html( $h['title_line1_fa'] ); ?><br /><?php echo esc_html( $h['title_line2_fa'] ); ?> <span class="mj-accent"><?php echo esc_html( $h['title_accent_fa'] ); ?></span></span>
				<span class="mj-block-en"><?php echo esc_html( $h['title_line1_en'] ); ?><br /><?php echo esc_html( $h['title_line2_en'] ); ?> <span class="mj-accent"><?php echo esc_html( $h['title_accent_en'] ); ?></span></span>
			</h1>
			<p class="mj-home__subtitle mj-fade" data-dir="down" data-delay="0.3" data-mj-above-fold="1">
				<span class="mj-only-fa"><?php echo esc_html( $h['subtitle_fa'] ); ?></span>
				<span class="mj-only-en"><?php echo esc_html( $h['subtitle_en'] ); ?></span>
			</p>
			<div class="mj-fade" data-dir="down" data-delay="0.4" data-mj-above-fold="1">
				<a class="mj-projects-btn" href="<?php echo esc_url( $work ); ?>">
					<img src="<?php echo esc_url( mj_img_uri( 'rounded-text.png' ) ); ?>" alt="" width="141" height="148" loading="eager" decoding="async" />
					<span class="mj-projects-btn__arrow" aria-hidden="true">→</span>
					<span class="screen-reader-text">
						<span class="mj-only-fa">مشاهده نمونه‌کارها</span>
						<span class="mj-only-en">View projects</span>
					</span>
				</a>
			</div>
		</div>
	</div>

	<div class="mj-home__stage" aria-hidden="true">
		<div class="mj-home__explosion"></div>
		<div id="mj-particles"></div>
		<div class="mj-home__avatar mj-fade" data-dir="up" data-delay="0.5" data-mj-above-fold="1">
			<img
				class="mj-avatar-img"
				src="<?php echo esc_url( mj_avatar_url() ); ?>"
				alt=""
				width="737"
				height="678"
				loading="eager"
				fetchpriority="high"
				decoding="async"
			/>
		</div>
	</div>
</section>
