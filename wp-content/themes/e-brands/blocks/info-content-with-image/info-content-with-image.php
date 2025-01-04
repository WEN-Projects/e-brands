<section class="info-with-image v-padded">
	<div class="container">
		<div class="info-with-image__title-col">
			<?php
			$section_tag = get_field( 'section_tag' );
			if ( $section_tag ) {
				echo "<h4 class=\"title-mini\">" . esc_html( $section_tag ) . "</h4>";
			}
			if ( get_field( 'left_text_content' ) ) {
				echo the_field( 'left_text_content' );
			}
			?>
		</div>
		<div class="info-with-image__content-col">
			<?php
			if ( get_field( 'right_text_content' ) ) {
				the_field( 'right_text_content' );
			}
			if ( have_rows( 'right_cta_buttons' ) ) {
				?>
				<div class="btn-wrap">
					<?php
					while ( have_rows( 'right_cta_buttons' ) ) {
						the_row();
						$link        = get_sub_field( 'link' );
						$button_type = get_sub_field( 'button_type' );
						if ( $link && isset( $link['title'] ) && isset( $link['url'] ) ) {
							$button_class = '';
							if ( 1 == $button_type ) {
								$button_class = 'is-secondary';
							} elseif ( 2 == $button_type ) {
								$button_class = 'is-link is-icon';
							} elseif ( 3 == $button_type ) {
								$button_class = 'is-alternate';
							}
							?>
							<a href="<?php echo esc_url( $link['url'] ); ?>"
							   class="btn <?php echo $button_class; ?>">
								<?php
								echo esc_html( $link['title'] );
								if ( 2 == $button_type ) {
									echo '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 3L11 8L6 13" stroke="CurrentColor" stroke-width="1.5"></path></svg>';
								}
								?>
							</a>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
		$bottom_image = get_field( 'bottom_image' );
		if ( isset( $bottom_image['ID'] ) ) { ?>
			<div class="full-width-image">
				<?php echo wp_get_attachment_image( $bottom_image['ID'], 'full' ); ?>
			</div>
		<?php } ?>
	</div>
</section><!-- .info-with-image -->
