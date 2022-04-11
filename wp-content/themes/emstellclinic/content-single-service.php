<?php
/**
 * @package Modeltheme
 */

$class = "";
if ( clinika_redux('clinika_single_service_layout') == 'clinika_service_fullwidth' ) {
    $class = "col-md-12";
}elseif ( clinika_redux('clinika_single_service_layout') == 'clinika_service_right_sidebar' or clinika_redux('clinika_single_service_layout') == 'clinika_service_left_sidebar') {
    $class = "col-md-8";
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
                    <div class="article-details">
                        <h1 class="post-name"><?php echo get_the_title(); ?></h1>
                    </div>
                    <?php clinika_breadcrumb(); ?>
                </ol>
            </div>
        </div>
    </div>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('post high-padding'); ?>>
    <div class="container">
       <div class="row">

            <?php if ( clinika_redux('clinika_single_service_layout') == 'clinika_service_left_sidebar' && is_active_sidebar( $sidebar )) { ?>
            <div class="col-md-4 sidebar-content">
                <?php if ( is_active_sidebar ( $sidebar ) ) { ?>
                    <?php  dynamic_sidebar( $sidebar ); ?>
                <?php } ?>
            </div>
            <?php } ?>

            <div class="<?php echo esc_attr($class); ?> main-content">
                <div class="article-content">

                <?php the_content(); ?>

                <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'clinika' ),
                        'after'  => '</div>',
                    ) );
                ?>
                </div>
            </div>

            <?php if (clinika_redux('clinika_single_service_layout') == 'clinika_service_right_sidebar' && is_active_sidebar( $sidebar )) { ?>
            <div class="col-md-4 sidebar-content">
                <?php if ( is_active_sidebar ( $sidebar ) ) { ?>
                    <?php  dynamic_sidebar( $sidebar ); ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="comments_holder">
        <div class="container">
        <?php
            // If comments are open or we have at least one comment, load up the comment template
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        ?>
        </div>
    </div>
</article>