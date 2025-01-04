<?php
if ( have_rows( 'team_members' ) ) {
	?>
    <section class="post-card-sec v-padded">
        <div class="container">
            <div class="post-card-sec__title-row">

				<?php
				if ( get_field( 'section_tag' ) ) {
					?>
                    <h4 class="title-mini"><?php the_field( 'section_tag' ); ?></h4>
					<?php
				}
				if ( get_field( 'title_content' ) ) {
					the_field( 'title_content' );
				}
				?>
            </div>
			<?php
			if ( have_rows( 'team_members' ) ) {
				?>
                <div class="post-card-wrap team-list">
					<?php
					while ( have_rows( 'team_members' ) ) {
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
								if ( get_sub_field( 'tm_full_name' ) ) {
									echo "<h6>" . esc_html( get_sub_field( 'tm_full_name' ) ) . "</h6>";
								}
								if ( get_sub_field( 'tm_team_role' ) ) {
									echo "<p>" . esc_html( get_sub_field( 'tm_team_role' ) ) . "</p>";
								}
								if ( get_sub_field( 'tm_description_text' ) ) {
									echo "<p>" . esc_html( get_sub_field( 'tm_description_text' ) ) . "</p>";
								}
								$tm_social_links = get_sub_field( 'tm_social_links' );
								if ( $tm_social_links ) {
									?>
                                    <ul class="social-list">
										<?php
										if ( isset( $tm_social_links['linked_in'] ) && ! empty( $tm_social_links['linked_in'] ) ) {
											?>
                                            <li class="social-list__item">
                                                <a href="<?php echo esc_html( $tm_social_links['linked_in'] ); ?>"
                                                   class="social-list__link"
                                                   target="_blank">
                                                    <svg class="social-list__icon"
                                                         width="100%"
                                                         height="100%"
                                                         viewBox="0 0 24 24"
                                                         fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                              clip-rule="evenodd"
                                                              d="M4.5 3C3.67157 3 3 3.67157 3 4.5V19.5C3 20.3284 3.67157 21 4.5 21H19.5C20.3284 21 21 20.3284 21 19.5V4.5C21 3.67157 20.3284 3 19.5 3H4.5ZM8.52076 7.00272C8.52639 7.95897 7.81061 8.54819 6.96123 8.54397C6.16107 8.53975 5.46357 7.90272 5.46779 7.00413C5.47201 6.15897 6.13998 5.47975 7.00764 5.49944C7.88795 5.51913 8.52639 6.1646 8.52076 7.00272ZM12.2797 9.76176H9.75971H9.7583V18.3216H12.4217V18.1219C12.4217 17.742 12.4214 17.362 12.4211 16.9819V16.9818V16.9816V16.9815V16.9812C12.4203 15.9674 12.4194 14.9532 12.4246 13.9397C12.426 13.6936 12.4372 13.4377 12.5005 13.2028C12.7381 12.3253 13.5271 11.7586 14.4074 11.8979C14.9727 11.9864 15.3467 12.3141 15.5042 12.8471C15.6013 13.1803 15.6449 13.5389 15.6491 13.8863C15.6605 14.9339 15.6589 15.9815 15.6573 17.0292V17.0294C15.6567 17.3992 15.6561 17.769 15.6561 18.1388V18.3202H18.328V18.1149C18.328 17.6629 18.3278 17.211 18.3275 16.7591V16.759V16.7588C18.327 15.6293 18.3264 14.5001 18.3294 13.3702C18.3308 12.8597 18.276 12.3563 18.1508 11.8627C17.9638 11.1286 17.5771 10.5211 16.9485 10.0824C16.5027 9.77019 16.0133 9.5691 15.4663 9.5466C15.404 9.54401 15.3412 9.54062 15.2781 9.53721L15.2781 9.53721L15.2781 9.53721C14.9984 9.52209 14.7141 9.50673 14.4467 9.56066C13.6817 9.71394 13.0096 10.0641 12.5019 10.6814C12.4429 10.7522 12.3852 10.8241 12.2991 10.9314L12.2991 10.9315L12.2797 10.9557V9.76176ZM5.68164 18.3244H8.33242V9.76733H5.68164V18.3244Z"
                                                              fill="CurrentColor"></path>
                                                    </svg>
                                                </a>
                                            </li>
											<?php
										}
										if ( isset( $tm_social_links['linked_in'] ) && ! empty( $tm_social_links['linked_in'] ) ) {
											?>
                                            <li class="social-list__item">
                                                <a href="<?php echo esc_html( $tm_social_links['linked_in'] ); ?>"
                                                   class="social-list__link"
                                                   target="_blank">
                                                    <svg class="social-list__icon"
                                                         width="100%"
                                                         height="100%"
                                                         viewBox="0 0 24 24"
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
										if ( isset( $tm_social_links['dribble'] ) && ! empty( $tm_social_links['dribble'] ) ) {
											?>
                                            <li class="social-list__item">
                                                <a href="<?php echo esc_html( $tm_social_links['dribble'] ); ?>"
                                                   class="social-list__link"
                                                   target="_blank">
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         width="24px" height="24px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
<path d="M12,2C6.5,2,2,6.5,2,12c0,5.5,4.5,10,10,10c5.5,0,10-4.5,10-10C22,6.5,17.5,2,12,2z M18.6,6.6c1.2,1.5,1.9,3.3,1.9,5.3
	c-0.3-0.1-3.1-0.6-5.9-0.3c-0.1-0.1-0.1-0.3-0.2-0.4c-0.2-0.4-0.4-0.8-0.6-1.2C17,8.7,18.4,6.8,18.6,6.6z M12,3.5
	c2.2,0,4.2,0.8,5.7,2.1c-0.2,0.2-1.4,1.9-4.5,3.1c-1.4-2.6-3-4.7-3.2-5C10.6,3.6,11.3,3.5,12,3.5z M8.4,4.3c0.2,0.3,1.7,2.4,3.2,4.9
	c-4,1.1-7.5,1-7.9,1C4.2,7.6,6,5.4,8.4,4.3z M3.5,12c0-0.1,0-0.2,0-0.3c0.4,0,4.5,0.1,8.8-1.2c0.2,0.5,0.5,1,0.7,1.5
	c-0.1,0-0.2,0.1-0.3,0.1c-4.4,1.4-6.7,5.3-6.9,5.6C4.3,16.2,3.5,14.2,3.5,12z M12,20.5c-2,0-3.8-0.7-5.2-1.8
	c0.2-0.3,1.9-3.7,6.7-5.3c0,0,0,0,0.1,0c1.2,3.1,1.7,5.7,1.8,6.5C14.3,20.3,13.2,20.5,12,20.5z M16.8,19.1c-0.1-0.5-0.5-3-1.7-6.1
	c2.7-0.4,5,0.3,5.3,0.4C20,15.7,18.7,17.8,16.8,19.1z" fill="CurrentColor"/>
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
	<?php
}
