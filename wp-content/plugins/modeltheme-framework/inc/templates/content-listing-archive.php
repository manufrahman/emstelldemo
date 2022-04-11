<?php 
/**
* Template for Listings
* Used in: search.php
**/


$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'clinika_530x450' );
$mt_listing_phone_number = get_post_meta( get_the_ID(), 'mt_listing_phone_number', true );
$mt_listing_mail_address = get_post_meta( get_the_ID(), 'mt_listing_mail_address', true );          
$mt_listing_location_address = get_post_meta( get_the_ID(), 'mt_listing_location_address', true );
$listing_img = '<img class="listing_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.get_the_title().'" />';
                  
$listing_term_style = get_term_meta( get_queried_object_id(), 'listing_term_style', true );
$term_column_single_listing = '';
if(empty($listing_term_style) || $listing_term_style == 'style1') {
    $term_column_single_listing = 'col-md-6';
} elseif($listing_term_style == 'style2') {
    $term_column_single_listing = 'col-md-4';
}

?>

<div class="<?php echo esc_attr($term_column_single_listing); ?> single-listing list-view listing-taxonomy-shortcode">
    <div class="col-md-12 listings_custom">
      

      <div class=" col-md-4 thumb_img">
       <div class="blog_custom_listings thumbnail-name">
		      <div class="listing-thumbnail">
		          <a class="relative" ><?php echo $listing_img; ?></a>
		      </div>
		 </div>
	 </div>

      <div class="title-n-categories col-md-8">
        	<div class="single_job_info ">
		        <h4 class="post-name"><?php echo get_the_title(); ?></h4>
            <ul class="listing-details-author-info">
                    <li><i class="fa fa-map-pin" aria-hidden="true"></i> <?php echo esc_html($mt_listing_location_address); ?></li>
                    <li><i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html($mt_listing_phone_number); ?></li>
                    <li><i class="fa fa-envelope"></i><a href="mailto:<?php echo esc_html($mt_listing_mail_address); ?>"><?php echo esc_html($mt_listing_mail_address); ?></a></li>
                  </ul>
		      </div>
      </div>

    </div>
</div>
