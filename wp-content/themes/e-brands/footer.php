<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package e-brands
 */

?>

<footer class="site-footer">

	<div class="to-top">
		<span class="wraps">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 42.67 64" id="" class="svg"><defs><style>.cls-1 {
							fill: #35353d;
						}</style></defs><title>Asset 45</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2"
																									  data-name="Layer 1"><path
							class="cls-1"
							d="M19.57.78.78,19.5a2.67,2.67,0,0,0,3.77,3.78L18.67,9.21V61.33a2.67,2.67,0,1,0,5.33,0V9L38.11,23.27a2.67,2.67,0,1,0,3.78-3.76L23.35.79a2.67,2.67,0,0,0-3.78,0Z"></path></g></g></svg>
		</span><!-- wraps -->
	</div>

	<div class="container">
		<div class="site-footer__top">
			<div class="site-footer__logo-col">
				<?php the_custom_logo(); ?>
				<?php
				$email   = get_field( 'ebrands_contact_email', 'option' );
				$phone   = get_field( 'ebrands_contact_phone', 'option' );
				$address = get_field( 'ebrands_contact_location_details', 'option' );
				?>
				<div class="site-footer__info">
					<?php
					if ( $address ) {
						?>
						<h6 class="info__title"><?php _e( 'Address:', 'e-brands' ); ?></h6>
						<p class="info__content"><?php echo esc_html( $address ); ?></p>
						<?php
					}
					if ( $email || $phone ) {
						?>
						<h6 class="info__title"><?php _e( 'Contact:', 'e-brands' ); ?></h6>
						<p class="info__content">
							<?php
							if ( $phone ) {
								?>
								<a href="tel:<?php echo esc_attr( $phone ); ?>"
								   class="info__phone"><?php echo esc_html( $phone ); ?></a><br>
								<?php
							}
							if ( $email ) {
								?>
								<a href="mailto:<?php echo sanitize_email( $email ); ?>"
								   class="info__email"><?php echo esc_html( $email ); ?></a>
								<?php
							}
							?>
						</p>
						<?php
					}
					?>
				</div>
				<?php
				$social_nw = get_field( 'ebrands_contact_social_networks', 'option' );
				if ( ! empty( $social_nw ) ) {
					?>
					<ul class="social-list">
						<?php
						if ( isset( $social_nw['facebook_link'] ) && ! empty( $social_nw['facebook_link'] ) ) {
							?>
							<li class="social-list__item">
								<a href="<?php echo esc_url( $social_nw['facebook_link'] ); ?>"
								   target="_blank" class="social-list__link">
									<svg class="social-list__icon" width="100%" height="100%" viewBox="0 0 24 24"
										 fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path
											d="M22 12.0611C22 6.50451 17.5229 2 12 2C6.47715 2 2 6.50451 2 12.0611C2 17.0828 5.65684 21.2452 10.4375 22V14.9694H7.89844V12.0611H10.4375V9.84452C10.4375 7.32296 11.9305 5.93012 14.2146 5.93012C15.3088 5.93012 16.4531 6.12663 16.4531 6.12663V8.60261H15.1922C13.95 8.60261 13.5625 9.37822 13.5625 10.1739V12.0611H16.3359L15.8926 14.9694H13.5625V22C18.3432 21.2452 22 17.083 22 12.0611Z"
											fill="CurrentColor"></path>
									</svg>
								</a>
							</li>
							<?php
						}
						if ( isset( $social_nw['instagram_link'] ) && ! empty( $social_nw['instagram_link'] ) ) {
							?>
							<li class="social-list__item">
								<a href="<?php echo esc_url( $social_nw['instagram_link'] ); ?>"
								   target="_blank" class="social-list__link">
									<svg class="social-list__icon" width="100%" height="100%" viewBox="0 0 24 24"
										 fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd"
											  d="M16 3H8C5.23858 3 3 5.23858 3 8V16C3 18.7614 5.23858 21 8 21H16C18.7614 21 21 18.7614 21 16V8C21 5.23858 18.7614 3 16 3ZM19.25 16C19.2445 17.7926 17.7926 19.2445 16 19.25H8C6.20735 19.2445 4.75549 17.7926 4.75 16V8C4.75549 6.20735 6.20735 4.75549 8 4.75H16C17.7926 4.75549 19.2445 6.20735 19.25 8V16ZM16.75 8.25C17.3023 8.25 17.75 7.80228 17.75 7.25C17.75 6.69772 17.3023 6.25 16.75 6.25C16.1977 6.25 15.75 6.69772 15.75 7.25C15.75 7.80228 16.1977 8.25 16.75 8.25ZM12 7.5C9.51472 7.5 7.5 9.51472 7.5 12C7.5 14.4853 9.51472 16.5 12 16.5C14.4853 16.5 16.5 14.4853 16.5 12C16.5027 10.8057 16.0294 9.65957 15.1849 8.81508C14.3404 7.97059 13.1943 7.49734 12 7.5ZM9.25 12C9.25 13.5188 10.4812 14.75 12 14.75C13.5188 14.75 14.75 13.5188 14.75 12C14.75 10.4812 13.5188 9.25 12 9.25C10.4812 9.25 9.25 10.4812 9.25 12Z"
											  fill="CurrentColor"></path>
									</svg>
								</a>
							</li>
							<?php
						}
						if ( isset( $social_nw['twitter_link'] ) && ! empty( $social_nw['twitter_link'] ) ) {
							?>
							<li class="social-list__item">
								<a href="<?php echo esc_url( $social_nw['twitter_link'] ); ?>"
								   target="_blank" class="social-list__link">
									<svg class="social-list__icon" width="100%" height="100%" viewBox="0 0 24 24"
										 fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path
											d="M17.1761 4H19.9362L13.9061 10.7774L21 20H15.4456L11.0951 14.4066L6.11723 20H3.35544L9.80517 12.7508L3 4H8.69545L12.6279 9.11262L17.1761 4ZM16.2073 18.3754H17.7368L7.86441 5.53928H6.2232L16.2073 18.3754Z"
											fill="CurrentColor"></path>
									</svg>
								</a>
							</li>
							<?php
						}
						if ( isset( $social_nw['linkedin_link'] ) && ! empty( $social_nw['linkedin_link'] ) ) {
							?>
							<li class="social-list__item">
								<a href="<?php echo esc_url( $social_nw['linkedin_link'] ); ?>"
								   target="_blank" class="social-list__link">
									<svg class="social-list__icon" width="100%" height="100%" viewBox="0 0 24 24"
										 fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd"
											  d="M4.5 3C3.67157 3 3 3.67157 3 4.5V19.5C3 20.3284 3.67157 21 4.5 21H19.5C20.3284 21 21 20.3284 21 19.5V4.5C21 3.67157 20.3284 3 19.5 3H4.5ZM8.52076 7.00272C8.52639 7.95897 7.81061 8.54819 6.96123 8.54397C6.16107 8.53975 5.46357 7.90272 5.46779 7.00413C5.47201 6.15897 6.13998 5.47975 7.00764 5.49944C7.88795 5.51913 8.52639 6.1646 8.52076 7.00272ZM12.2797 9.76176H9.75971H9.7583V18.3216H12.4217V18.1219C12.4217 17.742 12.4214 17.362 12.4211 16.9819V16.9818V16.9816V16.9815V16.9812C12.4203 15.9674 12.4194 14.9532 12.4246 13.9397C12.426 13.6936 12.4372 13.4377 12.5005 13.2028C12.7381 12.3253 13.5271 11.7586 14.4074 11.8979C14.9727 11.9864 15.3467 12.3141 15.5042 12.8471C15.6013 13.1803 15.6449 13.5389 15.6491 13.8863C15.6605 14.9339 15.6589 15.9815 15.6573 17.0292V17.0294C15.6567 17.3992 15.6561 17.769 15.6561 18.1388V18.3202H18.328V18.1149C18.328 17.6629 18.3278 17.211 18.3275 16.7591V16.759V16.7588C18.327 15.6293 18.3264 14.5001 18.3294 13.3702C18.3308 12.8597 18.276 12.3563 18.1508 11.8627C17.9638 11.1286 17.5771 10.5211 16.9485 10.0824C16.5027 9.77019 16.0133 9.5691 15.4663 9.5466C15.404 9.54401 15.3412 9.54062 15.2781 9.53721L15.2781 9.53721L15.2781 9.53721C14.9984 9.52209 14.7141 9.50673 14.4467 9.56066C13.6817 9.71394 13.0096 10.0641 12.5019 10.6814C12.4429 10.7522 12.3852 10.8241 12.2991 10.9314L12.2991 10.9315L12.2797 10.9557V9.76176ZM5.68164 18.3244H8.33242V9.76733H5.68164V18.3244Z"
											  fill="CurrentColor"></path>
									</svg>
								</a>
							</li>
							<?php
						}
						if ( isset( $social_nw['youtube'] ) && ! empty( $social_nw['youtube'] ) ) {
							?>
							<li class="social-list__item">
								<a href="<?php echo esc_url( $social_nw['youtube'] ); ?>" target="_blank" class="social-list__link">
									<svg class="social-list__icon" width="100%" height="100%" viewBox="0 0 24 24"
										 fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd"
											  d="M20.5686 4.77345C21.5163 5.02692 22.2555 5.76903 22.5118 6.71673C23.1821 9.42042 23.1385 14.5321 22.5259 17.278C22.2724 18.2257 21.5303 18.965 20.5826 19.2213C17.9071 19.8831 5.92356 19.8015 3.40294 19.2213C2.45524 18.9678 1.71595 18.2257 1.45966 17.278C0.827391 14.7011 0.871044 9.25144 1.44558 6.73081C1.69905 5.78311 2.44116 5.04382 3.38886 4.78753C6.96561 4.0412 19.2956 4.282 20.5686 4.77345ZM9.86682 8.70227L15.6122 11.9974L9.86682 15.2925V8.70227Z"
											  fill="CurrentColor"></path>
									</svg>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
					<?php
				}
				?>
			</div>

			<?php
			// Get all registered navigation menu locations
			$menu_locations = get_nav_menu_locations();
			$theme_location = 'menu-2';
			if ( isset( $menu_locations[ $theme_location ] ) ) {
				$menu_object = wp_get_nav_menu_object( $menu_locations[ $theme_location ] );
				$menu_items  = wp_get_nav_menu_items( $menu_object->name );
				$menu_items  = array_chunk( $menu_items, 5 );
				if ( ! empty( $menu_items ) ) {
					?>
					<div class="site-footer__menu-wrapper">
						<div class="site-footer__menu-wrapper__inner">
							<?php
							foreach ( $menu_items as $key => $item ) {
								echo "<ul class=\"site-footer__menu-wrapper__inner__list\">";
								foreach ( $item as $item2 ) {
									echo "<li><a href=\"" . esc_url( $item2->url ) . "\" class=\"link-list__item\">" . esc_html( $item2->post_title ) . "</a></li>";
								}
								echo "</ul>";
							}
							?>
							</ul>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
		<?php
		$footer_bootm_menu = wp_nav_menu(
			array(
				'theme_location' => 'menu-3',
				'container'      => false,
				'echo'           => false,
				'items_wrap'     => '%3$s',
				'link_class'     => 'legal-list__link'
			)
		);
		if ( $footer_bootm_menu ) {
			?>
			<div class="site-footer__bottom">
				<?php
				$copyright_text = get_field( 'ebrands_contact_copyright_text', 'option' );
				if ( $copyright_text ) {
					echo "<div class=\"site-footer__credit-text\">" . str_replace( '{$year}', get_the_time( 'Y' ), esc_html( $copyright_text ) ) . "</div>";
				}
				?>
				<div class="site-footer__legal-list">
					<?php
					echo strip_tags( $footer_bootm_menu, '<a>' );
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</footer>


</div><!-- #page -->

<?php wp_footer(); ?>
<?php
if ( get_field( 'ebrands_footer_scripts', 'option' ) ) {
	the_field( 'ebrands_footer_scripts', 'option' );
}
?>

</body>
</html>
