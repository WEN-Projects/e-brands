<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
//
$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = Tribe__Events__Main::postIdHelper( get_the_ID() );

/**
 * Allows filtering of the event ID.
 *
 * @param int $event_id
 *
 * @since 6.0.1
 *
 */
$event_id = apply_filters( 'tec_events_single_event_id', $event_id );

/**
 * Allows filtering of the single event template title classes.
 *
 * @param array $title_classes List of classes to create the class string from.
 * @param string $event_id The ID of the displayed event.
 *
 * @since 5.8.0
 *
 */
$title_classes = apply_filters( 'tribe_events_single_event_title_classes', [ 'tribe-events-single-event-title' ], $event_id );
$title_classes = implode( ' ', tribe_get_classes( $title_classes ) );

/**
 * Allows filtering of the single event template title before HTML.
 *
 * @param string $before HTML string to display before the title text.
 * @param string $event_id The ID of the displayed event.
 *
 * @since 5.8.0
 *
 */
$before = apply_filters( 'tribe_events_single_event_title_html_before', '<h2 class="' . $title_classes . '">', $event_id );

/**
 * Allows filtering of the single event template title after HTML.
 *
 * @param string $after HTML string to display after the title text.
 * @param string $event_id The ID of the displayed event.
 *
 * @since 5.8.0
 *
 */
$after = apply_filters( 'tribe_events_single_event_title_html_after', '</h2>', $event_id );

/**
 * Allows filtering of the single event template title HTML.
 *
 * @param string $after HTML string to display. Return an empty string to not
 *     display the title.
 * @param string $event_id The ID of the displayed event.
 *
 * @since 5.8.0
 *
 */
$title      = apply_filters( 'tribe_events_single_event_title_html', the_title( $before, $after, FALSE ), $event_id );
$cost       = tribe_get_formatted_cost( $event_id );
$venue      = tribe_get_venue( $event_id );
$start_date = tribe_get_start_date( $event_id, FALSE, 'j.m.Y' );
$start_time = tribe_get_start_date( $event_id, FALSE, 'H:i' );
$end_time   = tribe_get_end_date( $event_id, FALSE, 'H:i' );

?>
<!-- Notices -->
<?php
//tribe_the_notices()
?>

<section class="title-only v-padded text-center">
	<div class="container">
		<?php
		if ( get_field( 'header_title_text' ) ) {
			the_field( 'header_title_text' );
		} else {
			echo $title;
		}
		$event_cats = get_the_terms( $event_id, 'tribe_events_cat' );
		if ( ! empty( $event_cats ) ) {
			?>
			<ul class="meta-tag-list">
				<?php
				foreach ( $event_cats as $cat ) {
					if ( isset( $cat->name ) && isset( $cat->slug ) ) {
						$event_listin_page = ebrands_event_listin_page_url();
						?>
						<li>
							<a href="<?php echo $event_listin_page; ?>?event_category=<?php echo $cat->slug; ?>"
							   class="meta-tag"><?php echo esc_html( $cat->name ); ?></a>
						</li>
						<?php
					}
				} ?>
			</ul>
			<?php
		}
		$cats = ebrands_get_event_categories()
		?>
	</div>
</section>

<section class="image-content-layout v-padded">
	<div class="container content-v-center">
		<div class="image-content-layout__content-col">
			<?php
			if ( get_the_content() ) {
				the_content();
			}
			?>

			<div class="event-info">
				<ul>
					<?php
					if ( ! empty( $start_date ) ) {
						?>
						<li><span
								class="subject-caption"><?php _e( 'Datum', 'e-brands' ); ?>: </span><span
								class="detail"><?php echo esc_html( $start_date ); ?></span>
						</li>
						<?php
					}
					?>

					<?php
					if ( ! empty( $start_time ) && $end_time ) {
						?>
						<li><span
								class="subject-caption"><?php _e( 'Zeit', 'e-brands' ); ?>: </span><span
								class="detail"><?php echo esc_html( $start_time ); ?>
                                - <?php echo esc_html( $end_time ); ?> <?php _e( 'Uhr', 'e-brands' ); ?></span>
						</li>
						<?php
					}
					if ( $venue ) {
						?>
						<li><span
								class="subject-caption"><?php _e( 'Ort', 'e-brands' ); ?>: </span>
							<span
								class="detail"><?php echo esc_html( $venue ); ?>
								</span>
						</li>
						<?php
					}
					if ( ! empty( $cost ) ) : ?>
						<li><span
								class="subject-caption"><?php _e( 'Preis', 'e-brands' ); ?>: </span><span
								class="detail"><?php echo esc_html( $cost ) ?>-</span>
						</li>
					<?php endif; ?>

				</ul>
			</div>
			<div id="event-cart-popup">
				<!-- Event meta -->
				<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
				<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
			</div>
		</div>
		<div class="image-content-layout__img-col">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'full' );
			} else {
				?>
				<img
					src="<?php echo get_template_directory_uri(); ?>/src/images/placeholder.png"
					alt="">
				<?php
			}
			?>
		</div>
	</div>
</section>

<?php
if ( have_rows( 'associated_speakers' ) ) {
	?>
	<section class="post-card-sec v-padded">
		<div class="container">
			<div class="post-card-sec__title-row">
				<?php
				if ( get_field( 'associated_speaker_section_tag' ) ) {
					?>
					<?php
				}
				if ( get_field( 'associated_speaker_title_content' ) ) {
					the_field( 'associated_speaker_title_content' );
				}
				?>
			</div>
			<?php
			if ( have_rows( 'associated_speakers' ) ) {
				?>
				<div class="post-card-wrap team-list">
					<?php
					while ( have_rows( 'associated_speakers' ) ) {
						the_row();
						?>
						<div class="post-card">
							<?php
							$reviewer_profile_image = get_sub_field( 'profile_image' );
							if ( isset( $reviewer_profile_image['ID'] ) ) {
								?>
								<div class="img-holder">
									<?php
									echo wp_get_attachment_image( $reviewer_profile_image['ID'], 'full' );
									?>
								</div>
								<?php
							} else { ?>
								<div class="img-holder">
									<img
										src="<?php echo get_template_directory_uri(); ?>/src/images/placeholder.png"
										alt="Placeholder">
								</div>
								<?php
							}
							?>
							<div class="detail">
								<?php
								if ( get_sub_field( 'name' ) ) {
									echo "<h6>" . esc_html( get_sub_field( 'name' ) ) . "</h6>";
								}
								if ( get_sub_field( 'role' ) ) {
									echo "<p>" . esc_html( get_sub_field( 'role' ) ) . "</p>";
								}
								if ( get_sub_field( 'description' ) ) {
									echo "<p>" . esc_html( get_sub_field( 'description' ) ) . "</p>";
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
			<div class="btn-wrap">
				<a href="#tribe-tickets__tickets-form"
				   class="btn is-alternate"><?php _e( 'Ticket sichern', 'e-brands' ); ?></a>
			</div>
		</div>
	</section>
	<?php
}
if ( have_rows( 'reviews_list' ) ) {
	$review_counts = 0;
	?>
	<section class="testimonial-row v-padded">
		<div class="container">
			<div class="swiper testimonial-slider">
				<div class="swiper-wrapper">
					<?php
					while ( have_rows( 'reviews_list' ) ) {
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
											get_template_part( 'block-components/svg/star-rating', NULL );
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
										if ( get_sub_field( 'role_company' ) ) {
											?>
											<div class="post-meta">
												<div
													class="text-meta"><?php echo esc_html( get_sub_field( 'role_company' ) ); ?>
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
?>
<?php
$cta_button = get_field( 'cta_button' );
if ( isset( $cta_button['url'], $cta_button['title'] ) ) {
	?>
	<section class="single-cta">
		<div class="container text-center">
			<div class="faq-cta">
				<?php
				the_field( 'title_text' );
				$cta_button = get_field( 'cta_button' );
				?>
				<a href="<?php echo esc_url( $cta_button['url'] ); ?>"
				   class="btn is-secondary"><?php echo esc_html( $cta_button['title'] ); ?></a>
			</div>
		</div>
	</section>
	<?php
}
?>
