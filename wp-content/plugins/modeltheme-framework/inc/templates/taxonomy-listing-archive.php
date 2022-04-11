<?php
/**
 * The template for displaying search results pages.
 */
get_header(); 

?>
<div class="clearfix"></div>

<div class="modeltheme-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <h3 class="page-title"><?php echo esc_html__('Clinic Locations','modeltheme'); ?></h3>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php 

$listing_term_style = get_term_meta( get_queried_object_id(), 'listing_term_style', true );
$term_style = '';
$term_column_map = '';
$term_column_listings = '';
$term_column_single_listing = '';
if(empty($listing_term_style) || $listing_term_style == 'style1') {
    $term_style = 'term-style1';
    $term_column_single_listing = 'col-md-3';
} elseif($listing_term_style == 'style2') {
    $term_style = 'term-style2 row';
    $term_column_map = 'col-md-5';
    $term_column_listings = 'col-md-7';
    $term_column_single_listing = 'col-md-4';
}
?>
<div class="taxonomy-listing-page <?php echo esc_attr($term_style); ?>">
<?php if ( have_posts() ) : ?>

        <!-- MAP PINS ON ARCHIVE -->
        <?php if(function_exists('modeltheme_framework')){ ?>
            <!-- MAP LOCATION -->
            <div class="mt_listings_page mt_listing_map_location container high-padding-top <?php echo esc_attr($term_column_map); ?>">
            <?php 

                $gmap_pin = '';
                $api_key = '';
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    $api_key = clinika_redux('mt_listings_api_key');
                }
                // Start Map
                $gmap_pin .= '[sbvcgmap map_width="100" map_height="500" zoom="12" scrollwheel="no" pancontrol="no" scalecontrol="no" scalecontrol="no" streetviewcontrol="no" zoomcontrol="yes"  maptypecontrol="no" overviewmapcontrol="no" searchradius="500"  scrollwheel="no sbvcgmap_title="Google Maps" mapstyles="style-55"   sbvcgmap_apikey="'.$api_key.'"]';

                    while ( have_posts() ) : the_post();

                        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'clinika_listing_archive_thumbnail' );
              
                        if ($thumbnail_src) {
                            $listing_img_pin = '<img class="listing_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.get_the_title().'" />';
                        } else {
                            $listing_img_pin = '';
                        }

                        $mt_listing_location_address = get_post_meta( get_the_ID(), 'mt_listing_location_address', true );
                        $mt_listing_location_address_pin = '';
                        if($mt_listing_location_address) { 
                            $mt_listing_location_address_pin = $mt_listing_location_address;
                        } 

                        // Get the current category ID, e.g. if we're on a category archive page
                        $categories = wp_get_post_terms(get_the_ID(), 'mt-listing-category2', array("fields" => "all"));
                        foreach($categories as $category) {
                            if ($category) {
                                $image_id = get_term_meta ( $category->term_id, 'category-image-id-v3', true );
                                $mt_map_coordinates = get_post_meta( get_the_ID(), 'mt_map_coordinates', true );
                                if (isset($mt_map_coordinates) && !empty($mt_map_coordinates)) {
                                    if (isset($image_id) && !empty($image_id)) {
                                        $gmap_pin .= '[sbvcgmap_marker animation="DROP" address="'.esc_attr($mt_map_coordinates).'" icon="'.esc_attr($image_id).'"]'.$listing_img_pin.'<a>'.get_the_title().'</a><p>'.$mt_listing_location_address_pin.'</p>[/sbvcgmap_marker]';
                                    }
                                }
                            }
                        }
                    endwhile;
                // End Map
                $gmap_pin .= '[/sbvcgmap]';
                echo do_shortcode($gmap_pin);
            ?>
            </div>
        <?php } ?>

<?php endif; ?>

<!-- Page content -->
<div class="high-padding <?php echo esc_attr($term_column_listings); ?>">
    <!-- Blog content -->

    <?php if(empty($listing_term_style) || $listing_term_style == 'style1') { ?>
        <div class="container">
    <?php } ?>

            <div class="main-content row">

                
                <?php if ( have_posts() ) : ?>
                        <?php /* Start the Loop */ ?>
                        <?php $i = 1; ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php include('content-listing-archive.php');  ?>

                            <?php $i++; ?>

                        <?php endwhile; ?>

                        <div class="modeltheme-pagination-holder col-md-12">             
                            <div class="modeltheme-pagination pagination">             
                                <?php the_posts_pagination(); ?>
                            </div>
                        </div>
                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
            </div>
    <?php if(empty($listing_term_style) || $listing_term_style == 'style1') { ?>        
    </div>
    <?php } ?>
</div>
</div>
<?php get_footer(); ?>