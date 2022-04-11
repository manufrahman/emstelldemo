<?php 
require_once(__DIR__.'/../vc-shortcodes.inc.arrays.php');

function mt_affiliate_single_course($params,  $content = NULL) {
    extract( shortcode_atts( 
        array(
          'number_columns'     => ''
        ), $params ) );

    $html = '';
      $html .= '<div class="affiliate-course-wrapper col-md-12">';
        $html .= '<div class="mt-course-content mt_'.esc_attr($number_columns).'">';       
            $html .= do_shortcode($content);
        $html .= '</div>';
    $html .= '</div>';

    return $html;
}
add_shortcode('mt_affiliate_single_course_short', 'mt_affiliate_single_course');
/**
||-> Shortcode: Child Shortcode v1
*/
function mt_affiliate_single_course_items($params, $content = NULL) {

    extract( shortcode_atts( 
        array(
          'additional_title'        => '',
          'banner_img'              => '',
          'banner_button_url'       => '',
          'banner_rating'           => '',
          'banner_difficulty1'      => '',
          'banner_price'            => '',
          'banner_subject'          => '',
          'banner_language'         => ''
        ), $params ) );

    $banner = wp_get_attachment_image_src($banner_img, "iffiliate_portfolio_pic500x350");

    $html = '';
      $html .= '<ul class="single-course-wrapper">'; 
        $html .= '<li class="single-course">';
        
        if($banner) { 
            $html .= '<img src="'.$banner[0].'" alt="'.esc_attr($additional_title).'" />';
        }else{
            $html .= '<img src="http://placehold.it/500x350" alt="'.esc_attr($additional_title).'" />'; 
        }

        $html .= '<div class="course_infos">';
          $html .= '<div class="rating-list">
                      <div class="mt-rating-empty"></div><div class="mt-rating-fill" style="width: '.$banner_rating.' "></div>
                    </div>';
           $html .= '<p class="mt-title"><a href="'.esc_url($banner_button_url).'">'.esc_attr($additional_title).'</a></p>';

           if($banner_price) {
              $html .= '<p class="mt-price text-center">'.esc_attr($banner_price).'<span>'.esc_html__(' / month','modeltheme').'</span></p>';
           }
          $html .= '<ul>';
            if($banner_difficulty1) {
                $html .= '<li>'.esc_html__('Course Level :','modeltheme').'<span class="info-right">'.esc_attr($banner_difficulty1).'</span></li>';
            }
            if($banner_subject) {
                $html .= '<li>'.esc_html__('Subject :','modeltheme').'<span class="info-right">'.esc_attr($banner_subject).'</span></li>';
            }
            if($banner_language) { 
                $html .= '<li>'.esc_html__('Language :','modeltheme').'<span class="info-right">'.esc_attr($banner_language).'</span></li>';
            }
          $html .= '</ul>';    
        $html .= '</div>';   
        $html .= '</li>';
      $html .= '</ul>';

      return $html;
}
add_shortcode('mt_affiliate_single_course_short_item', 'mt_affiliate_single_course_items');

/**
||-> Map Shortcode in Visual Composer with: vc_map();
*/
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
    vc_map( array(
        "name" => esc_attr__("iffiliate - Courses Grid (Course Affiliates)", 'modeltheme'),
        "base" => "mt_affiliate_single_course_short",
        "as_parent" => array('only' => 'mt_affiliate_single_course_short_item'), 
        "content_element" => true,
        "show_settings_on_create" => true,
        "icon" => plugins_url( '../images/travel-amenities.svg', __FILE__ ),
        "category" => esc_attr__('Iffiliate', 'modeltheme'),
        "is_container" => true,
        "params" => array(
            array(
               "group" => "Options",
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Number of columns",'modeltheme'),
               "param_name" => "number_columns",
               "std" => '',
               "value" => array(
                    '4'          => 'col-md-3',
                    '3'          => 'col-md-4'
               )
            ),  
        ),
        "js_view" => 'VcColumnView'
    ) );
    vc_map( array(
        "name" => esc_attr__("Single Course", 'modeltheme'),
        "base" => "mt_affiliate_single_course_short_item",
        "content_element" => true,
        "as_child" => array('only' => 'mt_affiliate_single_course_short'),
        "params" => array(
             array(
                 "group" => "Options",
                 "type" => "attach_image",
                 "class" => "",
                 "heading" => esc_attr__("Course Image", 'modeltheme'),
                 "param_name" => "banner_img",
                 "value" => esc_attr__("#", 'modeltheme')
              ),
             array(
               "group" => "Options",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Set course title",'modeltheme'),
               "param_name" => "additional_title",
               "std" => ''
            ),
            array(
              "group" => "Options",
              "type" => "textfield",
              "holder" => "div",
              "class" => "",
              "heading" => esc_attr__("Course Link", 'modeltheme'),
              "param_name" => "banner_button_url",
              "value" => esc_attr__("#", 'modeltheme')
            ),
            array(
              "group" => "Options",
              "type" => "textfield",
              "class" => "",
              "heading" => esc_attr__("Course Price", 'modeltheme'),
              "param_name" => "banner_price",
              "value" => esc_attr__("$25", 'modeltheme')
            ),
            array(
              "group"        => "Options",
              "type"         => "dropdown",
              "class"        => "",
              "param_name"   => "banner_rating",
              "heading"      => esc_attr__("Rating", 'modeltheme'),
              "description"  => esc_attr__("Enter title for current rate item.", 'modeltheme'),
              "value" => array(
                '0%' => __( 'No rated', 'modeltheme' ),
                            '10%' => __( '10%', 'modeltheme' ),
                            '20%' => __( '20%', 'modeltheme' ),
                            '30%' => __( '30%', 'modeltheme' ),
                            '40%' => __( '40%', 'modeltheme' ),
                            '50%' => __( '50%', 'modeltheme' ),
                            '60%' => __( '60%', 'modeltheme' ),
                            '70%' => __( '70%', 'modeltheme' ),
                            '80%' => __( '80%', 'modeltheme' ),
                            '90%' => __( '90%', 'modeltheme' ),
                            '100%' => __( '100%', 'modeltheme' ),
                  ),
            ),
            array(
              "group" => "Options",
              "type" => "textfield",
              "class" => "",
              "heading" => esc_attr__("Course Difficulty", 'modeltheme'),
              "param_name" => "banner_difficulty1"
            ),
            array(
              "group" => "Options",
              "type" => "textfield",
              "class" => "",
              "heading" => esc_attr__("Course Subject", 'modeltheme'),
              "param_name" => "banner_subject"
            ),
            array(
              "group" => "Options",
              "type" => "textfield",
              "class" => "",
              "heading" => esc_attr__("Course Language", 'modeltheme'),
              "param_name" => "banner_language"
            ),
        )
    ) );
    //Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_mt_affiliate_single_course_short extends WPBakeryShortCodesContainer {
        }
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_mt_affiliate_single_course_short_item extends WPBakeryShortCode {
        }
    }
}
?>