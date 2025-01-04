<?php
/** Template Name: Inner Page
 *
 *
 */

get_header();
if ( have_posts() ) {
	/* Start the Loop */ ?>
	<section class="v-padded">
		<div class="container">
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			} ?>
		</div>
	</section>
	<?php
}
get_footer();
