<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$c = mj_setting( 'contact', array() );
?>
<section class="mj-page mj-page--soft mj-contact" data-mj-page="contact">
	<div class="mj-container">
		<div class="mj-contact__wrap">
			<h2 class="mj-h2 mj-fade" data-dir="up" data-delay="0.2" style="text-align:center;margin-bottom:3rem;">
				<span class="mj-block-fa"><?php echo esc_html( $c['heading_fa'] ); ?> <span class="mj-accent"><?php echo esc_html( $c['heading_accent_fa'] ); ?></span></span>
				<span class="mj-block-en"><?php echo esc_html( $c['heading_en'] ); ?> <span class="mj-accent"><?php echo esc_html( $c['heading_accent_en'] ); ?></span></span>
			</h2>

			<form class="mj-form mj-fade" data-dir="up" data-delay="0.4" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
				<input type="hidden" name="action" value="mj_contact_stub" />
				<div class="mj-form__row">
					<input class="mj-input" type="text" name="name" required
						data-ph-fa="<?php echo esc_attr( $c['name_ph_fa'] ); ?>" data-ph-en="<?php echo esc_attr( $c['name_ph_en'] ); ?>"
						aria-label="Name" />
					<input class="mj-input" type="email" name="email" required dir="ltr"
						data-ph-fa="<?php echo esc_attr( $c['email_ph_fa'] ); ?>" data-ph-en="<?php echo esc_attr( $c['email_ph_en'] ); ?>"
						aria-label="Email" />
				</div>
				<input class="mj-input" type="text" name="subject" required
					data-ph-fa="<?php echo esc_attr( $c['subject_ph_fa'] ); ?>" data-ph-en="<?php echo esc_attr( $c['subject_ph_en'] ); ?>"
					aria-label="Subject" />
				<textarea class="mj-textarea" name="message" required
					data-ph-fa="<?php echo esc_attr( $c['message_ph_fa'] ); ?>" data-ph-en="<?php echo esc_attr( $c['message_ph_en'] ); ?>"
					aria-label="Message"></textarea>

				<button type="submit" class="mj-submit">
					<span class="mj-submit__text">
						<span class="mj-only-fa"><?php echo esc_html( $c['submit_fa'] ); ?></span>
						<span class="mj-only-en"><?php echo esc_html( $c['submit_en'] ); ?></span>
					</span>
					<span class="mj-submit__icon" aria-hidden="true">→</span>
				</button>

				<p class="mj-form-note">
					<span class="mj-block-fa"><?php echo esc_html( $c['note_fa'] ); ?></span>
					<span class="mj-block-en"><?php echo esc_html( $c['note_en'] ); ?></span>
				</p>
			</form>
		</div>
	</div>
</section>
<script>
(function(){
  function syncPlaceholders(){
    var locale = (window.MJLocale && MJLocale.get()) || 'fa';
    document.querySelectorAll('[data-ph-fa]').forEach(function(el){
      el.setAttribute('placeholder', locale === 'fa' ? el.getAttribute('data-ph-fa') : el.getAttribute('data-ph-en'));
    });
  }
  document.addEventListener('DOMContentLoaded', syncPlaceholders);
  document.addEventListener('mj:localechange', syncPlaceholders);
  syncPlaceholders();
})();
</script>
