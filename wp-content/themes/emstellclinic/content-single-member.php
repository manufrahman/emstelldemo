<?php
/**
 * @package Modeltheme
 */

$class = "";
if ( clinika_redux('clinika_single_service_layout') == 'clinika_service_fullwidth' ) {
    $class = "col-md-12";
}elseif ( clinika_redux('clinika_single_service_layout') == 'clinika_service_right_sidebar' or clinika_redux('clinika_single_service_layout') == 'clinika_service_left_sidebar') {
    $class = "col-md-9";
}

$sidebar = clinika_redux('clinika_single_service_sidebar');
$prev_post = get_previous_post();
$next_post = get_next_post();
?>

<div class="clearfix"></div>

<div class="modeltheme-breadcrumbs">
    <div id="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                	<h3 class="page-title"><?php echo get_the_title(); ?></h3>
                </ol>
            </div>
        </div>
    </div>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('post high-padding'); ?>>
	 <div class="container">
        <div class="row">
			<div class="entry-content">
				<?php the_content(); ?>
				<div class="clearfix"></div>
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'clinika' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
			<div class="clearfix"></div>
			<?php edit_post_link( esc_html__( 'Edit', 'clinika' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</div>
</article><!-- #post-## -->