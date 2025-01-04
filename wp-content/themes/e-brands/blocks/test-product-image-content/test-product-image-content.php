<section class="content-image-tab v-padded">
	<div class="container">
		<div class="content-image-tab__title-row">
			<?php
			$section_tag = get_field( 'section_tag' );
			if ( $section_tag ) {
				echo "<h4 class=\"title-mini\">" . esc_html( $section_tag ) . "</h4>";
			}
			if ( get_field( 'section_title_content' ) ) {
				the_field( 'section_title_content' );
			}
			?>
		</div>
		<?php
		if ( have_rows( 'section_content' ) ) {
			?>
			<div class="content-image-tab__wrap">
				<div class="content-image-tab__controls-container" id="controls-container">
					<?php
					while ( have_rows( 'section_content' ) ) {
						the_row();
						?>
						<div class="content-image-tab__control">
							<div class="control-btn <?php echo 1 == get_row_index() ? 'active' : ''; ?>"
								 data-image="<?php echo get_row_index(); ?>">
								<?php
								if ( get_sub_field( 'text_content' ) ) {
									the_sub_field( 'text_content' );
								}
								?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="content-image-tab__images-container" id="images-container">
					<?php
					while ( have_rows( 'section_content' ) ) {
						the_row();
						?>
						<div class="image image-<?php echo get_row_index(); ?> <?php echo 1 == get_row_index() ? 'active' : ''; ?>"
							 id="<?php echo get_row_index(); ?>">
							<?php
							$mage = get_sub_field( 'content_image' );
							if ( isset( $mage['ID'] ) ) {
								echo wp_get_attachment_image( $mage['ID'], 'full' );
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</section>
