<section class="image-content-layout v-padded">
	<?php
	$left_content_type                = get_field( 'left_text_content' );
	$left_content_veritical_alignment = get_field( 'left_content_veritical_alignment' );
	?>
	<div class="container <?php echo $left_content_veritical_alignment ? 'content-v-center' : ''; ?>">
		<div class="image-content-layout__content-col">
			<?php
			$left_content_show_section_tag = get_field( 'left_content_show_section_tag' );
			$section_tag                   = get_field( 'left_content_section_tag' );
			if ( $left_content_show_section_tag && $section_tag ) {
				echo "<h4 class=\"title-mini\">" . esc_html( $section_tag ) . "</h4>";
			}
			if ( $left_content_type ) {
				the_field( 'left_text_content' );
			}
			if ( have_rows( 'left_cta_buttons' ) ) {
				?>
				<div class="btn-wrap">
					<?php
					while ( have_rows( 'left_cta_buttons' ) ) {
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
							<a href="<?php echo esc_url( $link['url'] ); ?>" class="btn <?php echo $button_class; ?>">
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
		<div class="image-content-layout__img-col">
			<?php
			$right_image = get_field( 'right_image' );
			if ( isset( $right_image['ID'] ) ) {
				echo wp_get_attachment_image( $right_image['ID'], 'full' );
			}
			?>
		</div>
	</div>
</section><!-- .image-content-layout -->


