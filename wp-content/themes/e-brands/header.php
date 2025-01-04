<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package e-brands
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php
	if ( get_field( 'ebrands_header_scripts', 'option' ) ) {
		the_field( 'ebrands_header_scripts', 'option' );
	}
	?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link sr-only" href="#primary"><?php esc_html_e( 'Skip to content', 'e-brands' ); ?></a>
	<header id="masthead" class="site-header">
		<div class="inner">
			<div class="container">
				<div class="site-branding">
					<?php
					the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title sr-only">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
							   rel="home"><?php bloginfo( 'name' ); ?></a>
						</h1>
					<?php
					else :
						?>
						<p class="site-title sr-only">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
							   rel="home"><?php bloginfo( 'name' ); ?></a>
						</p>
					<?php
					endif;
					$e_brands_description = get_bloginfo( 'description', 'display' );
					if ( $e_brands_description || is_customize_preview() ) :
						?>
						<p class="site-description sr-only"><?php echo $e_brands_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->

				<nav id="site-navigation" class="main-navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span></span><span></span><span></span></button>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
						)
					); ?>
				</nav><!-- #site-navigation -->
				<div class="navbar-buttons-wrap">
					<div class="navbar-buttons">
						<?php
						if ( is_user_logged_in() ) {
							?>
							<a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"
							   class="btn is-small"><?php _e( 'My Account', 'e-brands' ); ?></a>
							<?php
						} else {
							?>
							<a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>?action=register"
							   class="btn is-secondary is-small trigger-modal"
							   data-id="modal-register"><?php _e( 'Registrieren', 'e-brands' ); ?></a>
							<a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"
							   class="btn is-small"><?php _e( 'Log In', 'e-brands' ); ?></a>

							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<section class="content-nav">
			<div class="container">
				<div class="content-nav__wrap">
					<?php
					if ( have_rows( 'ebrands_header_more_menu', 'option' ) ) {
						?>
						<div class="content-nav__link-list">
							<?php
							while ( have_rows( 'ebrands_header_more_menu', 'option' ) ) {
								the_row();
								?>
								<div class="content-nav__link-list__list">
									<?php
									$upper_level_menu = get_sub_field( 'upper_level_menu_item' );
									if ( isset( $upper_level_menu['title'], $upper_level_menu['url'] ) ) {
										echo "<h4>" . esc_html( $upper_level_menu['title'] ) . "</h4>";
										$lower_level_menu_items = get_sub_field( 'lower_level_menu_items', 'option' );
										if ( ! empty( $lower_level_menu_items ) ) {
											?>
											<ul>
												<?php
												foreach ( $lower_level_menu_items as $key => $item ) {
													?>
													<li>
														<div class="icon">
															<img
																src="<?php echo get_template_directory_uri(); ?>/src/images/sample-icon.svg"
																alt="Icon">
														</div>
														<div class="detail">
															<?php
															if ( isset( $item->post_title ) ) {
																echo "<h5>" . esc_html( $item->post_title ) . "</h5>";
															}
															?>
															<p><?php _e( 'Learn More', 'e-brands' ) ?></p>
														</div>
														<?php
														if ( isset( $item->ID ) ) {
															echo "<a href=\"" . esc_url( get_permalink( $item->ID ) ) . "\" class=\"stretched-link\"></a>";
														}
														?>

													</li>
													<?php
												}
												?>
											</ul>
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
					}
					$ebrands_header_more_menu_right_bar_section = get_field( 'ebrands_header_more_menu_right_bar_section', 'option' );
					if ( $ebrands_header_more_menu_right_bar_section ) {
						?>
						<div class="content-nav__card">
							<?php
							if ( "latest-blog" == $ebrands_header_more_menu_right_bar_section ) {
								?>
								<h4><?php _e( 'Read Our Blog', 'e-brands' ) ?></h4>
								<?php
								$args  = array(
									'post_type'      => 'post',
									'posts_per_page' => 1,
									'orderby'        => 'date',
									'order'          => 'DESC',
									'post_status'    => 'publish'
								); //query to get the latest post
								$query = new WP_Query( $args );
								if ( $query->have_posts() ) {
									while ( $query->have_posts() ) {
										$query->the_post();
										?>
										<div class="content-nav__card__inner">
											<?php
											the_post_thumbnail();
											?>
											<h4><?php the_title(); ?></h4>
											<p><?php the_excerpt(); ?></p>
											<a href="<?php the_permalink(); ?>"
											   class="link"><?php _e( 'Read more', 'e-brands' ) ?></a>
										</div>
										<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"
										   class="btn is-link is-icon">See all articles
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
												 xmlns="http://www.w3.org/2000/svg">
												<path d="M6 3L11 8L6 13" stroke="CurrentColor"
													  stroke-width="1.5"></path>
											</svg>
										</a>
										<?php
									}
									wp_reset_postdata(); // Restore original post data
								}
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</section>
	</header><!-- #masthead -->


	<div class="modal" id="modal-register">
		<div class="modal-content">
			<span class="close-button">×</span>
			<div class="two-col-layout">
				<?php
				$ebrand_shop_registration_modal = get_field( 'ebrand_shop_registration_modal', 'option' );
				?>
				<div class="col">
					<?php
					if ( isset( $ebrand_shop_registration_modal['text_content'] ) && ! empty( $ebrand_shop_registration_modal['text_content'] ) ) {
						echo $ebrand_shop_registration_modal['text_content'];
					}
					if ( isset( $ebrand_shop_registration_modal['cta_button']['url'], $ebrand_shop_registration_modal['cta_button']['title'] ) ) {
						?>
						<div class="btn-wrap">
							<a href="<?php echo esc_url( $ebrand_shop_registration_modal['cta_button']['url'] ); ?>"
							   class="btn is-alternate"><?php echo esc_html( $ebrand_shop_registration_modal['cta_button']['title'] ); ?>
							</a>
						</div>
						<?php
					}
					?>

				</div>

				<div class="col">
					<?php
					$ebrand_eigenmarke_modal = get_field( 'ebrand_eigenmarke_modal', 'option' );
					if ( isset( $ebrand_eigenmarke_modal['text_content'] ) && ! empty( $ebrand_eigenmarke_modal['text_content'] ) ) {
						echo $ebrand_eigenmarke_modal['text_content'];
					}
					?>
					<div class="btn-wrap">
						<?php
						if ( isset( $ebrand_eigenmarke_modal['cta_button_one']['url'], $ebrand_eigenmarke_modal['cta_button_one']['title'] ) ) {
							?>
							<a href="<?php echo esc_url( $ebrand_eigenmarke_modal['cta_button_one']['url'] ); ?>"
							   class="btn is-alternate"><?php echo esc_html( $ebrand_eigenmarke_modal['cta_button_one']['title'] ); ?>
							</a>
							<?php
						}
						if ( isset( $ebrand_eigenmarke_modal['cta_button_two']['url'], $ebrand_eigenmarke_modal['cta_button_two']['title'] ) ) {
							?>
							<a href="<?php echo esc_url( $ebrand_eigenmarke_modal['cta_button_two']['url'] ); ?>"
							   class="btn is-link is-icon"><?php echo esc_html( $ebrand_eigenmarke_modal['cta_button_two']['title'] ); ?>
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
									 xmlns="http://www.w3.org/2000/svg">
									<path d="M6 3L11 8L6 13" stroke="CurrentColor" stroke-width="1.5"></path>
								</svg>
							</a>
							<?php
						}
						?>

					</div>
				</div>
			</div>
		</div>
	</div>

