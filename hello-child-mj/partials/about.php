<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a      = mj_setting( 'about', array() );
$skills = isset( $a['skills'] ) && is_array( $a['skills'] ) ? $a['skills'] : array();
?>
<section class="mj-page mj-page--soft mj-about" data-mj-page="about">
	<div class="mj-circles" aria-hidden="true">
		<img src="<?php echo esc_url( mj_img_uri( 'circles.png' ) ); ?>" alt="" width="260" height="200" decoding="async" />
	</div>
	<div class="mj-about__avatar mj-fade" data-dir="right" data-delay="0.2" data-mj-above-fold="1" aria-hidden="true">
		<img class="mj-avatar-img" src="<?php echo esc_url( mj_avatar_url() ); ?>" alt="" width="500" height="460" loading="eager" decoding="async" />
	</div>

	<div class="mj-container mj-about__grid">
		<div class="mj-about__left">
			<h2 class="mj-h2 mj-fade" data-dir="right" data-delay="0.2" data-mj-above-fold="1">
				<span class="mj-block-fa"><?php echo esc_html( $a['heading_fa'] ); ?> <span class="mj-accent"><?php echo esc_html( $a['heading_accent_fa'] ); ?></span> <?php echo esc_html( $a['heading_suffix_fa'] ); ?></span>
				<span class="mj-block-en"><?php echo esc_html( $a['heading_en'] ); ?> <span class="mj-accent"><?php echo esc_html( $a['heading_accent_en'] ); ?></span> <?php echo esc_html( $a['heading_suffix_en'] ); ?></span>
			</h2>
			<p class="mj-lead mj-about__lead mj-fade" data-dir="right" data-delay="0.4" data-mj-above-fold="1">
				<span class="mj-only-fa"><?php echo esc_html( $a['subtitle_fa'] ); ?></span>
				<span class="mj-only-en"><?php echo esc_html( $a['subtitle_en'] ); ?></span>
			</p>

			<div class="mj-counters mj-fade" data-dir="right" data-delay="0.6" data-mj-above-fold="1">
				<div class="mj-counter">
					<div class="mj-counter__num" data-end="<?php echo esc_attr( (string) $a['counter_exp'] ); ?>" data-duration="5">0</div>
					<div class="mj-counter__label">
						<span class="mj-only-fa"><?php echo esc_html( $a['counter_exp_label_fa'] ); ?></span>
						<span class="mj-only-en"><?php echo esc_html( $a['counter_exp_label_en'] ); ?></span>
					</div>
				</div>
				<div class="mj-counter">
					<div class="mj-counter__num" data-end="<?php echo esc_attr( (string) $a['counter_clients'] ); ?>" data-duration="5">0</div>
					<div class="mj-counter__label">
						<span class="mj-only-fa"><?php echo esc_html( $a['counter_cli_label_fa'] ); ?></span>
						<span class="mj-only-en"><?php echo esc_html( $a['counter_cli_label_en'] ); ?></span>
					</div>
				</div>
				<div class="mj-counter">
					<div class="mj-counter__num" data-end="<?php echo esc_attr( (string) $a['counter_projects'] ); ?>" data-duration="5">0</div>
					<div class="mj-counter__label">
						<span class="mj-only-fa"><?php echo esc_html( $a['counter_prj_label_fa'] ); ?></span>
						<span class="mj-only-en"><?php echo esc_html( $a['counter_prj_label_en'] ); ?></span>
					</div>
				</div>
				<div class="mj-counter">
					<div class="mj-counter__num" data-end="<?php echo esc_attr( (string) $a['counter_awards'] ); ?>" data-duration="5">0</div>
					<div class="mj-counter__label">
						<span class="mj-only-fa"><?php echo esc_html( $a['counter_awd_label_fa'] ); ?></span>
						<span class="mj-only-en"><?php echo esc_html( $a['counter_awd_label_en'] ); ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="mj-about__tabs mj-fade" data-dir="left" data-delay="0.4" data-mj-above-fold="1" data-mj-tabs>
			<div class="mj-tabs__nav" role="tablist" aria-label="About">
				<button type="button" class="mj-tabs__btn is-active" role="tab" aria-selected="true" data-tab="0">
					<span class="mj-only-fa"><?php echo esc_html( $a['tab_skills_fa'] ); ?></span><span class="mj-only-en"><?php echo esc_html( $a['tab_skills_en'] ); ?></span>
				</button>
				<button type="button" class="mj-tabs__btn" role="tab" aria-selected="false" data-tab="1">
					<span class="mj-only-fa"><?php echo esc_html( $a['tab_awards_fa'] ); ?></span><span class="mj-only-en"><?php echo esc_html( $a['tab_awards_en'] ); ?></span>
				</button>
				<button type="button" class="mj-tabs__btn" role="tab" aria-selected="false" data-tab="2">
					<span class="mj-only-fa"><?php echo esc_html( $a['tab_experience_fa'] ); ?></span><span class="mj-only-en"><?php echo esc_html( $a['tab_experience_en'] ); ?></span>
				</button>
				<button type="button" class="mj-tabs__btn" role="tab" aria-selected="false" data-tab="3">
					<span class="mj-only-fa"><?php echo esc_html( $a['tab_credentials_fa'] ); ?></span><span class="mj-only-en"><?php echo esc_html( $a['tab_credentials_en'] ); ?></span>
				</button>
			</div>

			<div class="mj-tabs__panel is-active" role="tabpanel" data-panel="0">
				<?php foreach ( $skills as $row ) : ?>
					<div class="mj-tabs__item mj-tabs__item--skills">
						<span class="mj-tabs__title">
							<span class="mj-only-fa"><?php echo esc_html( $row['title_fa'] ); ?></span>
							<span class="mj-only-en"><?php echo esc_html( $row['title_en'] ); ?></span>
						</span>
						<span class="mj-tabs__dash" aria-hidden="true">—</span>
						<div class="mj-tabs__icons" role="list">
							<?php
							$icons = array_filter( array_map( 'trim', explode( ',', $row['icons'] ?? '' ) ) );
							foreach ( $icons as $icon ) :
								?>
								<span class="mj-skill-icon" role="listitem" title="<?php echo esc_attr( $icon ); ?>"><?php echo esc_html( $icon ); ?></span>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php
			$panels = array(
				1 => 'awards',
				2 => 'experience',
				3 => 'credentials',
			);
			foreach ( $panels as $idx => $key ) :
				$rows = isset( $a[ $key ] ) && is_array( $a[ $key ] ) ? $a[ $key ] : array();
				?>
				<div class="mj-tabs__panel" role="tabpanel" data-panel="<?php echo esc_attr( (string) $idx ); ?>" hidden>
					<?php foreach ( $rows as $row ) : ?>
						<div class="mj-tabs__item">
							<span class="mj-tabs__title">
								<span class="mj-only-fa"><?php echo esc_html( $row['title_fa'] ); ?></span>
								<span class="mj-only-en"><?php echo esc_html( $row['title_en'] ); ?></span>
							</span>
							<span class="mj-tabs__dash" aria-hidden="true">—</span>
							<span class="mj-tabs__stage">
								<span class="mj-only-fa"><?php echo esc_html( $row['stage_fa'] ); ?></span>
								<span class="mj-only-en"><?php echo esc_html( $row['stage_en'] ); ?></span>
							</span>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
