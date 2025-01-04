<?php
$contact_form_id    = get_field( 'contact_form_id' );
$form_title_content = get_field( 'form_title_content' );
if ( $contact_form_id ) {
	?>
	<section class="contact-form-sec v-padded">
		<div class="container">
			<?php
			if ( get_field( 'form_title_content' ) ) {
				?>
				<div class="contact-form-sec__title-row">
					<?php
					the_field( 'form_title_content' );
					?>
				</div>
				<?php
			}
			if ( $contact_form_id ) {
				?>
				<div class="form-wrap">
					<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $contact_form_id ) . '" title="Contact form"]' ); ?>
				</div>
				<?php
			}
			?>

		</div>
	</section>
	<?php
}
