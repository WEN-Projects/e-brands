<?php
if ( get_field( 'form_content' ) ) {
	?>
	<section class="cta v-padded"
			 style='background: url("<?php echo home_url(); ?>/wp-content/uploads/2024/02/cta-bg.jpg") no-repeat center; background-size: cover;'>
		<div class="container">
			<?php
			the_field( 'form_content' );

			?>
		</div>
	</section>
	<?php
}
?>
