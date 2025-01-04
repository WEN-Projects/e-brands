<?php
$partners_type = get_field( 'partners_type' );
if ( ! $partners_type ) {
	return;
}
if ( 'our_partners' == $partners_type ) {
	if ( have_rows( 'ebrands_our_partners', 'option' ) ) {
		?>
		<section class="partners-logo block-medium"> <!-- to show on row please use "display-row" class -->
			<div class="container">
				<div class="partners-logo__title-col">
					<?php
					if ( get_field( 'section_title' ) ) {
						the_field( 'section_title' );
					}
					?>
				</div>
				<div class="partners-logo__logo-col">
					<ul>
						<?php
						while ( have_rows( 'ebrands_our_partners', 'option' ) ) {
							the_row();
							$client_logo  = get_sub_field( 'company_logo' );
							$company_link = get_sub_field( 'company_link' );
							if ( $client_logo) {
								?>
								<li>
									<a href="<?php echo esc_url( $company_link ); ?>">
										<?php echo wp_get_attachment_image( $client_logo, 'full' ); ?>
									</a>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
		</section><!-- .partners-logo -->
		<?php
	}
} else {
	if ( have_rows( 'our_partners_trusted_by', 'option' ) ) {
		?>
		<section class="partners-logo block-medium display-row"> <!-- to show on row please use "display-row" class -->
			<div class="container">
				<div class="partners-logo__title-col">
					<?php
					if ( get_field( 'section_title' ) ) {
						the_field( 'section_title' );
					}
					?>
				</div>
				<div class="partners-logo__logo-col">
					<ul>
						<?php
						while ( have_rows( 'our_partners_trusted_by', 'option' ) ) {
							the_row();
							$client_logo  = get_sub_field( 'company_logo' );
							$company_link = get_sub_field( 'company_link' );
							if ( isset( $client_logo) ) {
								?>
								<li>
									<a href="<?php echo esc_url( $company_link ); ?>">
										<?php echo wp_get_attachment_image( $client_logo, 'full' ); ?>
									</a>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
		</section><!-- .partners-logo -->
		<?php
	}
}
?>


