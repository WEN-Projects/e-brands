<?php
$testimonial_option = get_field( 'testimonial_option' );
if ( ! $testimonial_option ) {
	return;
}
if ( 'manual-reviews' == $testimonial_option ) {
	if ( have_rows( 'manual_testimonials' ) ) {
		$review_counts = 0;
		?>
		<section class="testimonial-row v-padded">
			<div class="container">
				<div class="swiper testimonial-slider">
					<div class="swiper-wrapper">
						<?php
						while ( have_rows( 'manual_testimonials' ) ) {
							the_row();
							$review_counts ++
							?>
							<div
								class="swiper-slide testimonial-item__wrap content-center padded">
								<?php
								$rating = get_sub_field( 'rating' );
								if ( $rating ) {
									?>
									<div class="testimonial-item__rating">
										<div class="inner">
											<div class="eb-stars"
												 data-eb-rating="<?php echo esc_html( $rating ); ?>">
												<?php
												get_template_part( 'block-components/svg/star-rating', null );
												?>
											</div>
										</div>
									</div>
									<?php
								}
								if ( get_sub_field( 'review_content' ) ) {
									echo "<h5 class=\"testimonial-item__title\">" . esc_html( get_sub_field( 'review_content' ) ) . "</h5>";
								}
								?>
								<div
									class="testimonial-item__author-wrapper inline">
									<div class="author-row">
										<?php
										$reviewer_profile_image = get_sub_field( 'profile_image' );
										if ( isset( $reviewer_profile_image['ID'] ) ) {
											?>
											<div class="img-wrap">
												<?php
												echo wp_get_attachment_image( $reviewer_profile_image['ID'] );
												?>
											</div>
											<?php
										} else { ?>
											<div class="img-wrap">
												<img
													src="<?php echo get_template_directory_uri(); ?>/src/images/placeholder.png"
													alt="Placeholder">
											</div>
											<?php
										}
										?>
										<div class="author-text">
											<?php
											if ( get_sub_field( 'reviewer_name' ) ) {
												echo "<h5>" . esc_html( get_sub_field( 'reviewer_name' ) ) . "</h5>";
											}
											if ( get_sub_field( 'associated_role_company' ) ) {
												?>
												<div class="post-meta">
													<div
														class="text-meta"><?php echo esc_html( get_sub_field( 'associated_role_company' ) ); ?>
													</div>
												</div>
												<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					if ( 1 < $review_counts ) {
						?>
						<div class="swiper-pagination"></div>
						<div class="swiper-navigation">
							<div class="swiper-button-prev">
								<img
									src="<?php echo get_template_directory_uri(); ?>/src/images/arrow-left.svg"
									alt="">
							</div>
							<div class="swiper-button-next">
								<img
									src="<?php echo get_template_directory_uri(); ?>/src/images/arrow-right.svg"
									alt="">
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</section>
		<?php
	}
} elseif ( 'google-reviews' == $testimonial_option ) {
	$google_reviews_embed_code = get_field( 'google_reviews_embed_code' );
	if ( $google_reviews_embed_code ) {
		?>
		<section class="review-list v-padded">
			<div class="container">
				<?php
				if ( get_field( 'title_content' ) ) {
					?>
					<div class="review-list__title-row">
						<?php
						the_field( 'title_content' );
						?>
					</div>
					<?php
				}
				?>
				<div class="review-list-wrap">
					<?php
					the_field( 'google_reviews_embed_code' );
					?>
				</div>
			</div>
		</section>
		<?php
	}
}
?>
