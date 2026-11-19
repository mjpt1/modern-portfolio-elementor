<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$sec   = mj_setting( 'services', array() );
$items = isset( $sec['items'] ) && is_array( $sec['items'] ) ? $sec['items'] : array();
?>
<section class="mj-page mj-page--soft mj-split" data-mj-page="services">
	<div class="mj-circles" aria-hidden="true"><img src="<?php echo esc_url( mj_img_uri( 'circles.png' ) ); ?>" alt="" loading="lazy" decoding="async" /></div>
	<div class="mj-bulb" aria-hidden="true"><img src="<?php echo esc_url( mj_img_uri( 'bulb.png' ) ); ?>" alt="" loading="lazy" decoding="async" /></div>

	<div class="mj-container">
		<div class="mj-split__row">
			<div class="mj-split__copy">
				<h2 class="mj-h2 mj-fade" data-dir="up" data-delay="0.2">
					<span class="mj-only-fa"><?php echo esc_html( $sec['heading_fa'] ); ?></span>
					<span class="mj-only-en"><?php echo esc_html( $sec['heading_en'] ); ?></span>
					<span class="mj-accent">.</span>
				</h2>
				<p class="mj-lead mj-fade" data-dir="up" data-delay="0.4">
					<span class="mj-only-fa"><?php echo esc_html( $sec['subtitle_fa'] ); ?></span>
					<span class="mj-only-en"><?php echo esc_html( $sec['subtitle_en'] ); ?></span>
				</p>
			</div>

			<div class="mj-split__slider mj-fade" data-dir="down" data-delay="0.6">
				<div class="swiper mj-swiper-services">
					<div class="swiper-wrapper">
						<?php foreach ( $items as $s ) : ?>
							<div class="swiper-slide">
								<div class="mj-service-card">
									<div class="mj-service-card__icon" aria-hidden="true"><?php echo esc_html( $s['icon'] ); ?></div>
									<div class="mj-service-card__title">
										<span class="mj-only-fa"><?php echo esc_html( $s['title_fa'] ); ?></span>
										<span class="mj-only-en"><?php echo esc_html( $s['title_en'] ); ?></span>
									</div>
									<p class="mj-service-card__desc">
										<span class="mj-only-fa"><?php echo esc_html( $s['desc_fa'] ); ?></span>
										<span class="mj-only-en"><?php echo esc_html( $s['desc_en'] ); ?></span>
									</p>
									<span class="mj-service-card__arrow" aria-hidden="true">↗</span>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</div>
	</div>
</section>
