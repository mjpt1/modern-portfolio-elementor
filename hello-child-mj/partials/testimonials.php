<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$t     = mj_setting( 'testimonials', array() );
$items = isset( $t['items'] ) && is_array( $t['items'] ) ? $t['items'] : array();
?>
<section class="mj-page mj-page--soft mj-testimonials" data-mj-page="testimonials">
	<div class="mj-container">
		<h2 class="mj-h2 mj-fade" data-dir="up" data-delay="0.2" style="margin-bottom:2rem;">
			<span class="mj-block-fa"><?php echo esc_html( $t['heading_fa'] ); ?> <span class="mj-accent"><?php echo esc_html( $t['heading_accent_fa'] ); ?></span></span>
			<span class="mj-block-en"><?php echo esc_html( $t['heading_en'] ); ?> <span class="mj-accent"><?php echo esc_html( $t['heading_accent_en'] ); ?></span></span>
		</h2>

		<div class="mj-fade" data-dir="up" data-delay="0.4">
			<div class="swiper mj-swiper-testimonials">
				<div class="swiper-wrapper">
					<?php foreach ( $items as $item ) : ?>
						<div class="swiper-slide">
							<div class="mj-testimonial">
								<div class="mj-testimonial__person">
									<img class="mj-testimonial__avatar" src="<?php echo esc_url( mj_item_image_url( $item, 't-avt-1.png' ) ); ?>" alt="" width="100" height="100" loading="lazy" decoding="async" />
									<div class="mj-testimonial__name">
										<span class="mj-only-fa"><?php echo esc_html( $item['name_fa'] ); ?></span>
										<span class="mj-only-en"><?php echo esc_html( $item['name_en'] ); ?></span>
									</div>
									<div class="mj-testimonial__role">
										<span class="mj-only-fa"><?php echo esc_html( $t['role_fa'] ); ?></span>
										<span class="mj-only-en"><?php echo esc_html( $t['role_en'] ); ?></span>
									</div>
								</div>
								<div class="mj-testimonial__body">
									<div class="mj-testimonial__quote" aria-hidden="true">“</div>
									<div>
										<span class="mj-only-fa"><?php echo esc_html( $item['msg_fa'] ); ?></span>
										<span class="mj-only-en"><?php echo esc_html( $item['msg_en'] ); ?></span>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>
</section>
