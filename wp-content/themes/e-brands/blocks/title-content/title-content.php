<?php
if ( get_field( 'title_content' ) ) {
	?>
    <section class="title-only v-padded text-center">
        <div class="container">
            <?php
                the_field('title_content');
            ?>
        </div>
    </section>
	<?php
}
