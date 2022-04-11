<?php
/**
* Plugin Name: ModelTheme Framework
* Plugin URI: https://modeltheme.com/
* Description: ModelTheme Framework.
* Version: 1.8
* Author: ModelTheme
* Author https://modeltheme.com/
* Text Domain: modeltheme
*/


$plugin_dir = plugin_dir_path( __FILE__ );


// SHARER
if (!function_exists('clinika_sharer')) {
    function clinika_sharer(){

        $html = '';
        $html .= '<div class="article-social">
                    <ul class="social-sharer">
                        <li class="facebook">
                            <a target="_blank" href="http://www.facebook.com/share.php?u='.get_permalink().'"><i class="fa fa-facebook"></i> '.esc_attr__('Share','modeltheme').'</a>
                        </li>
                        <li class="twitter">
                            <a target="_blank" href="http://twitter.com/home?'.get_permalink().'"><i class="fa fa-twitter"></i> '.esc_attr__('Tweet','modeltheme').'</a>
                        </li>
                        <li class="pinterest">
                            <a target="_blank" href="http://pinterest.com/pin/create/bookmarklet/?media='.get_permalink().'&url='.get_permalink().'&is_video=false&description='.get_permalink().'"><i class="fa fa-pinterest"></i> '.esc_attr__('Pin','modeltheme').'</a>
                        </li>
                    </ul>
                </div>';

        return $html;

    }
}



/**

||-> Function: modeltheme_enqueue_scripts()

*/
function modeltheme_framework() {
    // CSS
    wp_register_style( 'modelteme-framework-style',  plugin_dir_url( __FILE__ ) . 'css/modelteme-framework-style.css' );
    wp_enqueue_style( 'modelteme-framework-style' );

    wp_register_style( 'abs-custom-css',  plugin_dir_url( __FILE__ ) . 'css/tabs-custom.css' );
    wp_enqueue_style( 'abs-custom-css' );

    wp_enqueue_script( 'tabs-custom-js', plugin_dir_url( __FILE__ ) . 'js/tabs-custom.js', array('jquery'), '1.0.0', false );
    
}
add_action( 'wp_enqueue_scripts', 'modeltheme_framework' );


/**

||-> Function: modeltheme_enqueue_admin_scripts()

*/
function modeltheme_enqueue_admin_scripts( $hook ) {
    // CSS
    wp_register_style( 'modelteme-framework-admin-style',  plugin_dir_url( __FILE__ ) . 'css/modelteme-framework-admin-style.css' );
    wp_enqueue_style( 'modelteme-framework-admin-style' );

}
add_action('admin_enqueue_scripts', 'modeltheme_enqueue_admin_scripts');


// LOAD PLUGIN TEXTDOMAIN
function modeltheme_load_textdomain() {
    load_plugin_textdomain( 'modeltheme', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'modeltheme_load_textdomain' );

// POST TYPES
require_once('inc/post-types/post-types.php');

// SHORTCODES
require_once('inc/shortcodes/shortcodes.php');

// WIDGETS
require_once('inc/widgets/widgets-theme.php');

// METABOXES
require_once('inc/metaboxes/metaboxes.php');
require_once('inc/sb-google-maps-vc-addon/sb-google-maps-vc-addon.php');

// DEMO IMPORTER
require_once('inc/demo-importer-v2/wbc907-plugin-example.php');


add_action( 'init', 'modeltheme_cmb_initialize_cmb_meta_boxes', 9999 );
function modeltheme_cmb_initialize_cmb_meta_boxes() {
    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once ('init.php');
}

/**
||-> Function: mtlisitings_taxonomy_template_from_directory()
*/
function mtlisitings_taxonomy_template_from_directory($template){
    // is a specific custom taxonomy being shown?
    $taxonomy_array = array('mt-listing-category', 'mt-listing-category2', 'mt-listing-type', 'mt-listing-tags');
    foreach ($taxonomy_array as $taxonomy_single) {
        if ( is_tax($taxonomy_single) ) {
            if(file_exists(trailingslashit(plugin_dir_path( __FILE__ ) . 'inc/templates/taxonomy-listing-archive.php'))) {
                $template = trailingslashit(plugin_dir_path( __FILE__ ) . 'inc/templates/taxonomy-listing-archive.php');
            }else {
                $template = plugin_dir_path( __FILE__ ) . 'inc/templates/taxonomy-listing-archive.php';
            }
            break;
        }
    }
    return $template;
}
add_filter('template_include','mtlisitings_taxonomy_template_from_directory');

/* Filter the single_template with our custom function*/
function mtlisitings_listing_single_template($single) {
    global $wp_query, $post;
    /* Checks for single template by post type */
    if ( $post->post_type == 'mt_listing' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'inc/templates/single/single-listing.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'inc/templates/single/single-listing.php';
        }
    }
    return $single;
}
add_filter('single_template', 'mtlisitings_listing_single_template');

// |---> REDUX FRAMEWORK
function clinika_RemoveDemoModeLink() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'),null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'clinika_RemoveDemoModeLink');

// |---> VC Parallax Notices
if ( class_exists('GambitVCParallaxBackgrounds') ) {
    defined( 'GAMBIT_DISABLE_RATING_NOTICE' ) or define( 'GAMBIT_DISABLE_RATING_NOTICE', true );
}


/**
||-> Enqueue css to js_composer
*/
add_action( 'vc_base_register_front_css', 'clinika_enqueue_front_css_foreever' );
function clinika_enqueue_front_css_foreever() {
    wp_enqueue_style( 'js_composer_front' );
}