<?php
/**
 * Site's Front Page
 *
 */

get_header();
if ( have_posts() ) {
	/* Start the Loop */ ?>
	<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	} ?>
	<?php
}
get_footer();
