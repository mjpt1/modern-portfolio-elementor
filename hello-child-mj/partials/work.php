<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$w        = mj_setting( 'work', array() );
$projects = isset( $w['projects'] ) && is_array( $w['projects'] ) ? array_values( $w['projects'] ) : array();
// Chunk into slides of 4 (match Next work slider grids).
$slides = array_chunk( $projects, 4 );
if ( empty( $slides ) ) {
	$slides = array( array() );
}
?>
<section class="mj-page mj-page--soft mj-split" data-mj-page="work">
	<div class="mj-circles" aria-hidden="true"><img src="<?php echo esc_url( mj_img_uri( 'circles.png' ) ); ?>" alt="" loading="lazy" decoding="async" /></div>
	<div class="mj-bulb" aria-hidden="true"><img src="<?php echo esc_url( mj_img_uri( 'bulb.png' ) ); ?>" alt="" loading="lazy" decoding="async" /></div>

	<div class="mj-container">
		<div class="mj-split__row">
			<div class="mj-split__copy">
				<h2 class="mj-h2 mj-fade" data-dir="up" data-delay="0.2">
					<span class="mj-only-fa"><?php echo esc_html( $w['heading_fa'] ); ?></span>
					<span class="mj-only-en"><?php echo esc_html( $w['heading_en'] ); ?></span>
					<span class="mj-accent">.</span>
				</h2>
				<p class="mj-lead mj-fade" data-dir="up" data-delay="0.4">
					<span class="mj-only-fa"><?php echo esc_html( $w['subtitle_fa'] ); ?></span>
					<span class="mj-only-en"><?php echo esc_html( $w['subtitle_en'] ); ?></span>
				</p>
			</div>

			<div class="mj-split__slider mj-fade" data-dir="down" data-delay="0.6">
				<div class="swiper mj-swiper-work">
					<div class="swiper-wrapper">
						<?php foreach ( $slides as $slide ) : ?>
							<div class="swiper-slide">
								<div class="mj-work-grid">
									<?php foreach ( $slide as $proj ) : ?>
										<?php
										$url = ! empty( $proj['url'] ) ? $proj['url'] : '#';
										$img = mj_item_image_url( $proj, 'thumb1.jpg' );
										?>
										<a class="mj-work-card" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
											<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $proj['title_en'] ?: $proj['title_fa'] ); ?>" loading="lazy" decoding="async" />
											<span class="mj-work-card__overlay" aria-hidden="true"></span>
											<span class="mj-work-card__label">
												<span class="mj-only-fa"><?php echo esc_html( $w['live_label_fa'] ); ?></span>
												<span class="mj-only-en"><?php echo esc_html( $w['live_label_en'] ); ?></span>
												<span class="mj-work-card__project">
													<span class="mj-only-fa"><?php echo esc_html( $proj['title_fa'] ?: $w['proj_label_fa'] ); ?></span>
													<span class="mj-only-en"><?php echo esc_html( $proj['title_en'] ?: $w['proj_label_en'] ); ?></span>
												</span>
												<span class="mj-work-card__arrow" aria-hidden="true">→</span>
											</span>
										</a>
									<?php endforeach; ?>
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
