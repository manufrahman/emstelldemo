<?php
/**
 * The template for displaying all single posts.
 *
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
            <?php require_once('content-single-listing.php'); ?>
		<?php endwhile; // end of the loop. ?>
		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>