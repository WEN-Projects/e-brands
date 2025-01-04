<section class="faq-wrap content v-padded">
	<div class="container">
		<?php
		if ( get_field( 'title_content' ) ) {
			?>
			<div class="faq-wrap__title-row">
				<?php
				the_field( 'title_content' );
				?>
			</div>
			<?php
		}
		if ( have_rows( 'ebrands_faq_list', 'option' ) ) {
			?>
			<div class="content__faq-list">
				<div class="content__accordion">
					<?php
					while ( have_rows( 'ebrands_faq_list', 'option' ) ) {
						the_row();
						?>
						<div class="content__accordion_item">
							<?php
							$question = get_sub_field( 'question' );
							if ( $question ) {
								?>
								<div class="content__accordion_head" tabindex="0">
									<h3 class="content__accordion_title"><?php echo esc_html( $question ) ?></h3>
									<span class="content__accordion_icon"></span>
								</div>
								<?php
							}
							if ( get_sub_field( 'answer' ) ) {
								?>
								<div class="content__accordion_body">
									<div class="content__accordion_body_inner">
										<?php
										the_sub_field( 'answer' );
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
			</div>
			<?php
		}
		if ( get_field( 'text_below_faq_list' ) || get_field( 'cta_button' ) ) {
			?>
			<div class="faq-cta">
				<?php
				the_field( 'text_below_faq_list' );
				$cta_button = get_field( 'cta_button' );
				if ( isset( $cta_button['url'], $cta_button['title'] ) ) {
					?>
					<a href="<?php echo esc_url( $cta_button['url'] ); ?>"
					   class="btn is-secondary"><?php echo esc_html( $cta_button['title'] ); ?></a>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
	</div>


</section>
