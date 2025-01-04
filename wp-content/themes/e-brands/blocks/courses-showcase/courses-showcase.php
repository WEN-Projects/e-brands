<?php
$event_listing_type = get_field( 'event_listing_type' );
if ( 'featured' == $event_listing_type ) {
	$titleLeft     = '';
	$ebrand_events = tribe_get_events( [
		'posts_per_page' => 3,
		'featured'       => TRUE,
	] );
	ob_start();
	if ( ! empty( $ebrand_events ) ) {
		?>
		<div class="post-card-wrap">
		<?php
		foreach ( $ebrand_events as $event ) {
			$event_id = isset( $event->ID ) ? $event->ID : 0;
			?>
			<div class="post-card">
				<div class="img-holder">
					<a href="<?php echo esc_url( get_permalink( $event_id ) ); ?>">
						<?php
						if ( has_post_thumbnail( $event_id ) ) {
							echo get_the_post_thumbnail( $event_id );
						} else {
							?>
							<img
								src="<?php echo get_template_directory_uri(); ?>/src/images/placeholder.png"
								alt="<?php echo esc_html( get_the_title( $event_id ) ); ?>">
							<?php
						}
						?>
					</a>
				</div>
				<div class="detail">
					<a href="<?php echo esc_url( get_permalink( $event_id ) ); ?>"
					   class="stretched-link"></a>
					<?php
					if ( function_exists( 'ebrands_get_event_categories' ) ) {
						$categories = ebrands_get_event_categories( $event_id );
						if ( ! empty( $categories ) ) {
							echo "<h6>" . implode( ",", $categories ) . "</h6>";
						}
					}
					?>
					<h5><?php echo esc_html( get_the_title( $event_id ) ); ?></h5>
					<p><?php echo esc_html( get_the_excerpt( $event_id ) ); ?></p>

					<div class="author-row">
						<div class="author-text">
							<div class="post-meta">
								<?php
								$event_date = tribe_get_start_date( $event_id, FALSE, 'j M Y' );
								if ( $event_date ) {
									echo "<div class=\"text-date\">" . esc_html( $event_date ) . "</div>";
								}
								?>

								<?php
								$event_venue = tribe_get_venue( $event_id );
								if ( ! empty( $event_venue ) ) {
									?>
									<div
										class="text-time">
										<div class="text-divider">•</div>
										<span><?php echo esc_html( $event_venue ); ?></span>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		</div><?php
	}
	$content = ob_get_clean();
} else {
	$posts_per_page = isset( $_GET['count'] ) && ! empty( $_GET['count'] ) ? (int) $_GET['count'] : 5;
	$args           = [];
	if ( isset( $_GET['event_category'] ) && ! empty( $_GET['event_category'] ) && 'all' != $_GET['event_category'] ) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'tribe_events_cat',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET['event_category'] ),
			],
		];
	}
	$ebrand_events       = tribe_get_events( array_merge( $args, [ 'posts_per_page' => $posts_per_page ] ) );
	$ebrand_events_total = tribe_get_events( array_merge( $args, [ 'posts_per_page' => - 1 ] ) );

	ob_start();
	if ( ! empty( $ebrand_events ) ) {
		$titleLeft = 'text-left';
		?>
		<div id="ebrands-events-listing" class="event-list">
			<?php
			$event_listing_page = ebrands_event_listin_page_url();
			$event_categories   = get_terms( [
				'taxonomy'   => 'tribe_events_cat',
				'hide_empty' => FALSE,
			] );
			$selected_cat       = isset( $_GET['event_category'] ) && ! empty( $_GET['event_category'] ) ? $_GET['event_category'] : 'all';
			?>
			<ul class="cat-list">
				<li <?php if ( 'all' == $selected_cat ) {
					echo 'class="current"';
				} ?>>
					<a class="btn <?php if ( 'all' == $selected_cat ) {
						echo 'is-secondary';
					} else {
						echo 'is-link';
					} ?> "
					   href="<?php echo $event_listing_page; ?>?event_category=all"><?php _e( 'View all' ); ?></a>
				</li>
				<?php
				if ( ! empty( $event_categories ) ) {
					foreach ( $event_categories as $cat ) {
						?>
						<li id="<?php echo $cat->slug; ?>" <?php if ( $cat->slug == $selected_cat ) {
							echo 'class="current"';
						} ?>>
							<a class="btn <?php echo $cat->slug == $selected_cat ? 'is-secondary' : 'is-link'; ?>"
							   href="<?php echo $event_listing_page; ?>?event_category=<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></a>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<?php
			foreach ( $ebrand_events as $event ) {
				$event_id = isset( $event->ID ) ? $event->ID : 0;
				?>
				<div class="event-list__item">
					<?php
					$event_date_day_name   = tribe_get_start_date( $event_id, FALSE, 'D' );
					$event_date_day        = tribe_get_start_date( $event_id, FALSE, 'd' );
					$event_date_month      = tribe_get_start_date( $event_id, FALSE, 'm' );
					$event_date_month_name = tribe_get_start_date( $event_id, FALSE, 'M' );
					$event_date_year       = tribe_get_start_date( $event_id, FALSE, 'Y' );
					?>
					<div class="event-list__item__date-col">
						<?php
						if ( $event_date_day_name ) {
							echo "<span class=\"weekday\">" . esc_html( $event_date_day_name ) . "</span>";
						}
						if ( $event_date_day ) {
							echo "<span class=\"monthday\">" . esc_html( $event_date_day ) . "</span>";
						}
						if ( $event_date_month_name ) {
							echo "<span class=\"yeardate\">" . esc_html( $event_date_month_name ) . " " . esc_html( $event_date_year ) . "</span>";
						}
						?>
					</div>
					<div class="event-list__item__detail-col">
						<?php
						$is_event_ticket_sold_out = tribe_events_has_soldout( $event_id );
						?>
						<h3>
							<?php
							echo esc_html( get_the_title( $event_id ) );
							if ( $is_event_ticket_sold_out ) {
								echo "<span class=\"meta-tag\">" . __( 'Sold out', 'e-brands' ) . "</span>";
							}
							?>
						</h3>
						<?php
						$event_venue = tribe_get_venue( $event_id );
						if ( ! empty( $event_venue ) ) {
							?>
							<span
								class="location"><?php echo esc_html( $event_venue ); ?></span>
							<?php
						}
						?>
						<p><?php echo esc_html( get_the_excerpt( $event_id ) ); ?></p>
					</div>
					<div class="event-list__item__button-col">
						<a href="<?php echo esc_url( get_permalink( $event_id ) ); ?>"
						   class="btn is-secondary"><?php _e( 'Mehr erfahren', 'e-brands' ); ?></a>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<div id="load-more-events-wrapper">
			<?php
			if ( count( $ebrand_events ) < count( $ebrand_events_total ) ) {
				?>
				<link rel="stylesheet"
					  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
				<a href="#" class="btn"
				   id="load-more-events"><?php _e( 'Mehr laden', 'e-brands' ); ?>
					<i
						style="display: none"
						class="fa fa-spinner fa-spin"></i></a>
				<?php
			}
			?>
		</div>

		<?php
	}
	$content = ob_get_clean();

	?>
	<?php
}
?>

<section class="post-card-sec v-padded">
	<div class="container">
		<div class="post-card-sec__title-row <?php echo $titleLeft; ?>">
			<?php
			$section_tag = get_field( 'section_tag' );
			if ( $section_tag ) {
				echo "<h4 class=\"title-mini\">" . esc_html( $section_tag ) . "</h4>";
			}
			if ( get_field( 'text_content' ) ) {
				the_field( 'text_content' );
			}
			?>
		</div>
		<?php
		echo $content;
		$more_courses_link = get_field( 'more_courses_link' );
		if ( isset( $more_courses_link['url'], $more_courses_link['title'] ) ) {
			?>
			<div class="btn-wrap">
				<a href="<?php echo esc_url( $more_courses_link['url'] ); ?>"
				   class="btn is-secondary"><?php echo esc_html( $more_courses_link['title'] ) ?>
				</a>
			</div>
			<?php
		}
		?>
	</div>
</section>
