<?php

/* Custom functions for woocommerce */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


if (!function_exists('clinika_woocommerce_show_top_custom_block')) {
    function clinika_woocommerce_show_top_custom_block() {
        $args = array();
        global $product;
        global $clinika_redux;
        echo '<div class="thumbnail-and-details">';    
                  
            wc_get_template( 'loop/sale-flash.php' );
            
            echo '<div class="overlay-container">';
                echo '<div class="thumbnail-overlay"></div>';
                echo '<div class="overlay-components">';

                    echo '<div class="component add-to-cart">';
                        echo '<a href="'.esc_url(get_the_permalink()).'" class="button product_type_simple add_to_cart_button" data-tooltip="'.esc_attr__('Purchase', 'clinika').'" data-product_id="' . esc_attr($product->get_id()) . '"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>';
                    echo '</div>';

                    if ( class_exists( 'YITH_WCWL' ) ) {
                        echo '<div class="component wishlist">';
                            echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
                        echo '</div>';
                    }

                    if (  class_exists( 'YITH_WCQV' ) ) {
                        echo '<div class="component quick-view">';
                            echo '<a href="'.esc_url('#').'" class="button yith-wcqv-button" data-tooltip="'.esc_attr__('Quickview', 'clinika').'" data-product_id="' . esc_attr($product->get_id()) . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        echo '</div>';
                    }
                    
                echo '</div>';
            echo '</div>';
            echo '<a class="woo_catalog_media_images" title="'.esc_attr(the_title_attribute('echo=0')).'" href="'.esc_url(get_the_permalink(get_the_ID())).'">'.woocommerce_get_product_thumbnail();
            echo '</a>';
            
        echo '</div>';
    }
    add_action( 'woocommerce_before_shop_loop_item_title', 'clinika_woocommerce_show_top_custom_block' );
}


if (!function_exists('clinika_woocommerce_show_price_and_review')) {
    function clinika_woocommerce_show_price_and_review() {
        $args = array();
        global $product;
        global $clinika_redux;

        echo '<div class="details-container">';
            echo '<div class="details-price-container details-item">';
                wc_get_template( 'loop/price.php' );
                   
                echo '<div class="details-review-container details-item">';
                    wc_get_template( 'loop/rating.php' );
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
    add_action( 'woocommerce_after_shop_loop_item_title', 'clinika_woocommerce_show_price_and_review' );
}

// always display rating stars
function clinika_filter_woocommerce_product_get_rating_html( $rating_html, $rating, $count ) { 
    $rating_html  = '<div class="star-rating">';
    $rating_html .= wc_get_star_rating_html( $rating, $count );
    $rating_html .= '</div>';

    return $rating_html; 
};  
add_filter( 'woocommerce_product_get_rating_html', 'clinika_filter_woocommerce_product_get_rating_html', 10, 3 ); 


/**
||-> Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
*/
function clinika_woocommerce_header_add_to_cart_fragment( $fragments ) {
    ob_start();
?>
<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'View your shopping cart','clinika' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count, 'clinika' ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
<?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
} 
add_filter( 'woocommerce_add_to_cart_fragments', 'clinika_woocommerce_header_add_to_cart_fragment' );

remove_action( 'wp_head', 'rest_output_link_wp_head' );



/**
 * Modify image width theme support.
 Archive shop
 */
function clinika_modify_theme_support() {
    $theme_support = get_theme_support( 'woocommerce' );
    $theme_support = is_array( $theme_support ) ? $theme_support[0] : array();

    $theme_support['single_image_width'] = 1000;
    $theme_support['thumbnail_image_width'] = 1000;
    $theme_support['gallery_thumbnail_image_width'] = 180;

    remove_theme_support( 'woocommerce' );
    add_theme_support( 'woocommerce', $theme_support );
}
add_action( 'after_setup_theme', 'clinika_modify_theme_support', 10 );

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

/**
 Single product
 */
add_filter( 'woocommerce_get_image_size_single', 'clinika_product_img_size' );
add_filter( 'woocommerce_get_image_size_shop_single', 'clinika_product_img_size' );
add_filter( 'woocommerce_get_image_size_woocommerce_single', 'clinika_product_img_size' );
function clinika_product_img_size()
{
    $size = array(
        'width'  => 700,
        'height' => 800,
        'crop'   => 1,
    );
    return $size;
}


/**
||-> Custom functions for woocommerce
*/
function clinika_woocommerce_get_sidebar() {
    global  $clinika_redux;

    if ( is_shop() ) {
        $sidebar = $clinika_redux['clinika_shop_layout_sidebar'];
    }elseif ( is_product() ) {
        $sidebar = $clinika_redux['clinika_single_shop_sidebar'];
    }else{
        $sidebar = 'woocommerce';
    }

if ( is_active_sidebar ( $sidebar ) ) { 
     dynamic_sidebar( $sidebar ); 
} 

}
add_action ( 'woocommerce_sidebar', 'clinika_woocommerce_get_sidebar' );

add_filter( 'loop_shop_columns', 'clinika_wc_loop_shop_columns', 1, 10 );

/*
 * Return a new number of maximum columns for shop archives
 * @param int Original value
 * @return int New number of columns
 */
function clinika_wc_loop_shop_columns( $number_columns ) {
    global  $clinika_redux;

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if ( $clinika_redux['modeltheme-shop-columns'] ) {
            return $clinika_redux['modeltheme-shop-columns'];
        }else{
            return 3;
        }
    }else{
        return 3;
    }
}


add_filter( 'woocommerce_output_related_products_args', 'clinika_related_products_args' );
function clinika_related_products_args( $args ) {
    global  $clinika_redux;

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        $args['posts_per_page'] = $clinika_redux['modeltheme-related-products-number'];
    }else{
        $args['posts_per_page'] = 3;
    }
    $args['columns'] = 3;

    return $args;
}


add_filter( 'woocommerce_widget_cart_is_hidden', 'clinika_always_show_cart', 40, 0 );
function clinika_always_show_cart() {
    return false;
}


// Change Woocommerce css breaktpoint from max width: 768px to 767px  
add_filter('woocommerce_style_smallscreen_breakpoint', 'clinika_woo_custom_breakpoint');
function clinika_woo_custom_breakpoint($px) {
  $px = '767px';
  return $px;
}


//change woocommerce-loop product title from h2 to h3
remove_action( 'woocommerce_template_loop_product_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

add_action('woocommerce_template_loop_product_title', 'clinika_change_products_title', 10 );
add_action('woocommerce_shop_loop_item_title', 'clinika_change_products_title', 10 );
function clinika_change_products_title() {
    echo '<h3 class="woocommerce-loop-product_title">' . esc_html(get_the_title()) . '</h3>';
}