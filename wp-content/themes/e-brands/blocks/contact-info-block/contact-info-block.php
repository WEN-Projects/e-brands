<section class="contact-sec v-padded">
	<div class="container">
		<div class="contact-sec__title-wrap">
			<?php
			$section_tag  = get_field( 'contact_block_section_tag', 'option' );
			$text_content = get_field( 'contact_block_title_content', 'option' );
			if ( $section_tag || $text_content ) {
				?>
				<div class="contact-sec__title-col">
					<?php
					if ( $section_tag ) {
						echo "<h4 class=\"title-mini\">" . $section_tag . "</h4>";
					}
					the_field( 'contact_block_title_content', 'option' );
					?>
				</div>
				<?php
			}
			?>

			<div class="contact-sec__info-col">
				<?php
				$email   = get_field( 'contact_block_email', 'option' );
				$phone   = get_field( 'contact_block_phone', 'option' );
				$address = get_field( 'contact_block_location_details', 'option' );
				if ( $email ) {
					?>
					<div class="item">
						<div class="icon">
							<svg width=" 100%" height=" 100%"
								 viewBox="0 0 24 24" fill="none"
								 xmlns="http://www.w3.org/2000/svg">
								<path
									d="M20 4H4C2.897 4 2 4.897 2 6V18C2 19.103 2.897 20 4 20H20C21.103 20 22 19.103 22 18V6C22 4.897 21.103 4 20 4ZM20 6V6.511L12 12.734L4 6.512V6H20ZM4 18V9.044L11.386 14.789C11.5611 14.9265 11.7773 15.0013 12 15.0013C12.2227 15.0013 12.4389 14.9265 12.614 14.789L20 9.044L20.002 18H4Z"
									fill="currentColor"></path>
							</svg>
						</div>
						<div class="item-text-wrapper">
							<h6><?php _e( 'Email', 'e-brands' ); ?></h6>
							<a href="mailto:<?php echo sanitize_email( $email ); ?>"
							   class="text-style-link"><?php echo esc_html( $email ); ?></a>
						</div>
					</div>
					<?php
				}
				if ( $phone ) {
					?>
					<div class="item">
						<div class="icon">
							<svg width=" 100%" height=" 100%"
								 viewBox="0 0 24 24" fill="none"
								 xmlns="http://www.w3.org/2000/svg">
								<path
									d="M17.707 12.293C17.6142 12.2 17.504 12.1263 17.3827 12.076C17.2614 12.0257 17.1313 11.9998 17 11.9998C16.8687 11.9998 16.7386 12.0257 16.6173 12.076C16.496 12.1263 16.3858 12.2 16.293 12.293L14.699 13.887C13.96 13.667 12.581 13.167 11.707 12.293C10.833 11.419 10.333 10.04 10.113 9.30096L11.707 7.70696C11.7999 7.61417 11.8737 7.50397 11.924 7.38265C11.9743 7.26134 12.0002 7.13129 12.0002 6.99996C12.0002 6.86862 11.9743 6.73858 11.924 6.61726C11.8737 6.49595 11.7999 6.38575 11.707 6.29296L7.707 2.29296C7.61421 2.20001 7.50401 2.12627 7.38269 2.07596C7.26138 2.02565 7.13133 1.99976 7 1.99976C6.86866 1.99976 6.73862 2.02565 6.6173 2.07596C6.49599 2.12627 6.38579 2.20001 6.293 2.29296L3.581 5.00496C3.201 5.38496 2.987 5.90696 2.995 6.43996C3.018 7.86396 3.395 12.81 7.293 16.708C11.191 20.606 16.137 20.982 17.562 21.006H17.59C18.118 21.006 18.617 20.798 18.995 20.42L21.707 17.708C21.7999 17.6152 21.8737 17.505 21.924 17.3837C21.9743 17.2623 22.0002 17.1323 22.0002 17.001C22.0002 16.8696 21.9743 16.7396 21.924 16.6183C21.8737 16.4969 21.7999 16.3867 21.707 16.294L17.707 12.293ZM17.58 19.005C16.332 18.984 12.062 18.649 8.707 15.293C5.341 11.927 5.015 7.64196 4.995 6.41896L7 4.41396L9.586 6.99996L8.293 8.29296C8.17546 8.41041 8.08904 8.55529 8.04155 8.71453C7.99406 8.87376 7.987 9.04231 8.021 9.20496C8.045 9.31996 8.632 12.047 10.292 13.707C11.952 15.367 14.679 15.954 14.794 15.978C14.9565 16.0129 15.1253 16.0064 15.2846 15.9591C15.444 15.9117 15.5889 15.825 15.706 15.707L17 14.414L19.586 17L17.58 19.005V19.005Z"
									fill="currentColor"></path>
							</svg>
						</div>
						<div class="item-text-wrapper">
							<h6><?php _e( 'Phone', 'e-brands' ); ?></h6>
							<a href="tel:<?php echo esc_attr( $phone ); ?>"
							   class="text-style-link">
								<?php echo esc_html( $phone ); ?>
							</a>
						</div>
					</div>
					<?php
				}
				if ( $address ) {
					?>
					<div class="item">
						<div class="icon">
							<svg width=" 100%" height=" 100%"
								 viewBox="0 0 24 24" fill="none"
								 xmlns="http://www.w3.org/2000/svg">
								<path
									d="M12 14C14.206 14 16 12.206 16 10C16 7.794 14.206 6 12 6C9.794 6 8 7.794 8 10C8 12.206 9.794 14 12 14ZM12 8C13.103 8 14 8.897 14 10C14 11.103 13.103 12 12 12C10.897 12 10 11.103 10 10C10 8.897 10.897 8 12 8Z"
									fill="currentColor"></path>
								<path
									d="M11.42 21.814C11.5892 21.9349 11.792 21.9998 12 21.9998C12.208 21.9998 12.4107 21.9349 12.58 21.814C12.884 21.599 20.029 16.44 20 10C20 5.589 16.411 2 12 2C7.589 2 4 5.589 4 9.995C3.971 16.44 11.116 21.599 11.42 21.814ZM12 4C15.309 4 18 6.691 18 10.005C18.021 14.443 13.612 18.428 12 19.735C10.389 18.427 5.979 14.441 6 10C6 6.691 8.691 4 12 4Z"
									fill="currentColor"></path>
							</svg>
						</div>
						<div class="item-text-wrapper">
							<h6><?php _e( 'Office', 'e-brands' ); ?></h6>
							<span><?php echo esc_html( $address ); ?></span>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
		$map     = get_field( 'ebrands_contact_locationi_map', 'option' );
		$api_key = get_option( 'google_map_api_key' );
		if ( $map && isset( $map['place_id'] ) && isset( $map['zoom'] ) ):?>
			<div class="contact-sec__map-wrap">
				<iframe
					width="600"
					height="450"
					frameborder="0" style="border:0"
					referrerpolicy="no-referrer-when-downgrade"
					src="https://www.google.com/maps/embed/v1/place?key=<?php echo $api_key; ?>&q=place_id:<?php echo $map['place_id']; ?>&zoom=<?php echo $map['zoom']; ?>"
					allowfullscreen
					async
				>
				</iframe>
			</div>
		<?php endif; ?>

	</div>
</section>
