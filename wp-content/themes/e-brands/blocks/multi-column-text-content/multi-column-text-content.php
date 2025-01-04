<section class="post-card-sec v-padded">
	<div class="container">
		<div class="post-card-sec__title-row">
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
		if ( have_rows( 'content_blocks' ) ) {
			?>
			<div class="post-card-wrap">
				<?php
				while ( have_rows( 'content_blocks' ) ) {
					the_row();
					?>
					<div class="post-card only-content">
						<div class="detail">
							<img class="icon" src="<?php echo home_url(); ?>/wp-content/uploads/2024/02/icon-relume.svg"
								 alt="">
							<?php
							if ( get_sub_field( 'text_content' ) ) {
								the_sub_field( 'text_content' );
							}
							if ( have_rows( 'cta_buttons' ) ) {
								while ( have_rows( 'cta_buttons' ) ) {
									the_row();
									$link = get_sub_field( 'link' );
									if ( $link && isset( $link['title'] ) && isset( $link['url'] ) ) {
										?>
										<a href="<?php echo esc_url( $link['url'] ); ?>"
										   class="btn is-link is-icon"><?php echo esc_html( $link['title'] ); ?>
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
												 xmlns="http://www.w3.org/2000/svg">
												<path d="M6 3L11 8L6 13" stroke="CurrentColor"
													  stroke-width="1.5"></path>
											</svg>
										</a>
										<?php
									}
								}
							}
							?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
	</div>
</section>
