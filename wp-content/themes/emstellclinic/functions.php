<?php

/**
 * modeltheme functions and definitions
 *
 * @package modeltheme
*/


if ( ! isset( $content_width ) ) {
    $content_width = 640; /* pixels */
}


/**
||-> clinika_setup
*/
function clinika_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on modeltheme, use a find and replace
     * to change 'clinika' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'clinika', get_template_directory() . '/languages' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary menu', 'clinika' ),
        'topbar' => esc_html__( 'Top Bar menu', 'clinika' ),
    ) );

    global  $clinika_redux;

    // ADD THEME SUPPORT
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    //WooCommerce v3.x New Gallery Support
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    remove_theme_support( 'widgets-block-editor' );

    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ) );// Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link',
    ) );// Enable support for Post Formats.
    add_theme_support( 'custom-background', apply_filters( 'clinika_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );// Set up the WordPress core custom background feature.
}
add_action( 'after_setup_theme', 'clinika_setup' );


/**
||-> Register widget area.
*/
function clinika_widgets_init() {

    global  $clinika_redux;

    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'clinika' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Main Theme Sidebar', 'clinika' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
        
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if (!empty($clinika_redux['dynamic_sidebars'])){
            foreach ($clinika_redux['dynamic_sidebars'] as &$value) {
                $id           = str_replace(' ', '', $value);
                $id_lowercase = strtolower($id);
                if ($id_lowercase) {
                    register_sidebar( array(
                        'name'          => $value,
                        'id'            => $id_lowercase,
                        'description'   => esc_html__( 'Dynamic Sidebar: ', 'clinika' ) . $value,
                        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                        'after_widget'  => '</aside>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    ) );
                }
            }
        }
        
        // FOOTER ROW 1
        if (isset($clinika_redux['footer_row_1']) && $clinika_redux['footer_row_1'] != false) {
            $footer_row_1 = $clinika_redux['footer_row_1_layout'];
            $nr1 = array("1", "2", "3", "4", "5", "6");
            if (in_array($footer_row_1, $nr1)) {
                for ($i=1; $i <= $footer_row_1 ; $i++) { 
                    register_sidebar( array(
                        'name'          => esc_html__( 'Footer Row 1 - Sidebar ', 'clinika' ).esc_html($i),
                        'id'            => 'footer_row_1_'.esc_attr($i),
                        'description'   => esc_html__( 'Footer Row 1 - Sidebar ', 'clinika' ).esc_html($i),
                        'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                        'after_widget'  => '</aside>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    ) );
                }
            }elseif ($footer_row_1 == 'column_half_sub_half' || $footer_row_1 == 'column_sub_half_half') {
                $footer_row_1 = '3';
                for ($i=1; $i <= $footer_row_1 ; $i++) { 
                    register_sidebar( array(
                        'name'          => esc_html__( 'Footer Row 1 - Sidebar ', 'clinika' ).esc_html($i),
                        'id'            => 'footer_row_1_'.esc_attr($i),
                        'description'   => esc_html__( 'Footer Row 1 - Sidebar ', 'clinika' ).esc_html($i),
                        'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                        'after_widget'  => '</aside>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    ) );
                }
            }elseif ($footer_row_1 == 'column_sub_fourth_third' || $footer_row_1 == 'column_third_sub_fourth') {
                $footer_row_1 = '5';
                for ($i=1; $i <= $footer_row_1 ; $i++) { 
                    register_sidebar( array(
                        'name'          => esc_html__( 'Footer Row 1 - Sidebar ', 'clinika' ).esc_html($i),
                        'id'            => 'footer_row_1_'.esc_attr($i),
                        'description'   => esc_html__( 'Footer Row 1 - Sidebar ', 'clinika' ).esc_html($i),
                        'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                        'after_widget'  => '</aside>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    ) );
                }
            }elseif ($footer_row_1 == 'column_sub_third_half' || $footer_row_1 == 'column_half_sub_third' || $footer_row_1 == 'column_fourth_sub_half') {
                $footer_row_1 = '4';
                for ($i=1; $i <= $footer_row_1 ; $i++) { 
                    register_sidebar( array(
                        'name'          => esc_html__( 'Footer Row 1 - Sidebar ', 'clinika' ).esc_html($i),
                        'id'            => 'footer_row_1_'.esc_attr($i),
                        'description'   => esc_html__( 'Footer Row 1 - Sidebar ', 'clinika' ).esc_html($i),
                        'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                        'after_widget'  => '</aside>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    ) );
                }
            }
        }

    }
}
add_action( 'widgets_init', 'clinika_widgets_init' );


/**
||-> Enqueue scripts and styles.
*/
function clinika_scripts() {

    //STYLESHEETS
    wp_enqueue_style( "font-awesome", get_template_directory_uri()."/css/font-awesome.min.css" );
    wp_enqueue_style( "simple-line-icons", get_template_directory_uri()."/css/simple-line-icons.css" );
    wp_enqueue_style( "clinika-responsive", get_template_directory_uri()."/css/responsive.css" );
    wp_enqueue_style( "clinika-media-screens", get_template_directory_uri()."/css/media-screens.css" );
    wp_enqueue_style( "owl-carousel", get_template_directory_uri()."/css/owl.carousel.css" );
    wp_enqueue_style( "owl-theme", get_template_directory_uri()."/css/owl.theme.css" );
    wp_enqueue_style( "animate", get_template_directory_uri()."/css/animate.css" );
    wp_enqueue_style( "loaders", get_template_directory_uri()."/css/loaders.css" );
    wp_enqueue_style( "clinika-styles", get_template_directory_uri()."/css/styles.css" );
    wp_enqueue_style( "clinika-style", get_stylesheet_uri() );
    wp_enqueue_style( "sidebarEffects", get_template_directory_uri()."/css/sidebarEffects.css" );

    if ( ! class_exists( "Vc_Manager" ) ) {
        wp_enqueue_style( "js-composer", get_template_directory_uri()."/css/js_composer.css" );
    }
   // Enqueue style if gutenberg is active
    wp_enqueue_style( "clinika-gutenberg-frontend", get_template_directory_uri()."/css/gutenberg-frontend.css" );

    //SCRIPTS
    wp_enqueue_script( "bootstrap", get_template_directory_uri() . "/js/bootstrap.min.js", array("jquery"), "3.3.1", true );
    wp_enqueue_script( "modernizr-custom", get_template_directory_uri() . "/js/modernizr.custom.js", array("jquery"), "2.6.2", true );
    wp_enqueue_script( "classie", get_template_directory_uri() . "/js/classie.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "jquery-form", get_template_directory_uri() . "/js/jquery.form.js", array("jquery"), "3.51.0", true );
    wp_enqueue_script( "jquery-validation", get_template_directory_uri() . "/js/jquery.validation.js", array("jquery"), "1.13.1", true );
    wp_enqueue_script( "jquery-sticky", get_template_directory_uri() . "/js/jquery.sticky.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "uisearch", get_template_directory_uri() . "/js/uisearch.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "jquery-appear", get_template_directory_uri() . "/js/jquery.appear.js", array("jquery"), "1.1.3", true );
    wp_enqueue_script( "jquery-countTo", get_template_directory_uri() . "/js/jquery.countTo.js", array("jquery"), "2.1.0", true );
    wp_enqueue_script( "sidebarEffects", get_template_directory_uri() . "/js/sidebarEffects.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "owl-carousel", get_template_directory_uri() . "/js/owl.carousel.min.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "modernizr-viewport", get_template_directory_uri() . "/js/modernizr.viewport.js", array("jquery"), "2.6.2", true );
    wp_enqueue_script( "animate", get_template_directory_uri() . "/js/animate.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "jquery-countdown", get_template_directory_uri() . "/js/jquery.countdown.js", array("jquery"), "2.1.0", true );
    wp_enqueue_script( "navigation", get_template_directory_uri() . "/js/navigation.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "skip-link-focus-fix", get_template_directory_uri() . "/js/skip-link-focus-fix.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "loaders", get_template_directory_uri() . "/js/loaders.css.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "share-tooltip", get_template_directory_uri() . "/js/share-tooltip.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "clinika-custom", get_template_directory_uri() . "/js/clinika-custom.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "masonry" );
    if ( is_singular() && comments_open() && get_option( "thread_comments" ) ) {
        wp_enqueue_script( "comment-reply" );
    }
}
add_action( "wp_enqueue_scripts", "clinika_scripts" );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
if (!function_exists('clinika_pingback_header')) {
    function clinika_pingback_header() {
        if ( is_singular() && pings_open() ) {
            echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
        }
    }
    add_action( 'wp_head', 'clinika_pingback_header' );
}

/**
||-> Enqueue admin css/js
*/
function clinika_enqueue_admin_scripts( $hook ) {
    wp_enqueue_script( "clinika-admin-scripts", get_template_directory_uri()."/js/clinika-admin-scripts.js" , array( "jquery" ) );
    wp_enqueue_script( "loaders", get_template_directory_uri()."/js/loaders.css.js" , array( "jquery" ) );

    wp_enqueue_style( "clinika-admin-style", get_template_directory_uri()."/css/admin-style.css" );
    wp_enqueue_style( "loaders", get_template_directory_uri()."/css/loaders.css" );
}
add_action('admin_enqueue_scripts', 'clinika_enqueue_admin_scripts');




/**
||-> Enqueue css to redux
*/
function clinika_register_fontawesome_to_redux() {
    wp_register_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.min.css', array(), time(), 'all' );  
    wp_enqueue_style( 'font-awesome' );
}
add_action( 'redux/page/redux_demo/enqueue', 'clinika_register_fontawesome_to_redux' );


/**
||-> Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
*/
add_action( 'vc_before_init', 'clinika_vc_set_as_theme' );
function clinika_vc_set_as_theme() {
    vc_set_as_theme( true );
}

/**
||-> Other required parts/files
*/
/* ========= LOAD CUSTOM FUNCTIONS ===================================== */
require_once get_template_directory() . '/inc/custom-functions.php';
/* ========= Customizer additions. ===================================== */
require_once get_template_directory() . '/inc/customizer.php';
/* ========= Load Jetpack compatibility file. ===================================== */
require_once get_template_directory() . '/inc/jetpack.php';
/* ========= Include the TGM_Plugin_Activation class. ===================================== */
require_once get_template_directory() . '/inc/tgm/include_plugins.php';
/* ========= LOAD - REDUX - FRAMEWORK ===================================== */
require_once get_template_directory() . '/redux-framework/modeltheme-config.php';
/* ========= CUSTOM COMMENTS ===================================== */
require_once get_template_directory() . '/inc/custom-comments.php';
/* ========= HEADER FUNCTIONS ===================================== */
require_once get_template_directory() . '/inc/custom-functions.header.php';
require_once get_template_directory() . '/inc/custom-functions.gutenberg.php';
require_once get_template_directory() . '/inc/custom-functions.woocommerce.php';


/**
||-> add_image_size //Resize images
*/
/* ========= RESIZE IMAGES ===================================== */
add_image_size( 'clinika_related_post_pic500x300', 500, 300, true );
add_image_size( 'clinika_post_pic700x450', 700, 450, true );
add_image_size( 'clinika_portfolio_pic900x500', 900, 500, true );
add_image_size( 'clinika_post_widget_pic150x120', 150, 120, true );
add_image_size( 'clinika_500x680', 500, 680, true );
add_image_size( 'clinika_530x450', 530, 450, true );
add_image_size( 'clinika_700x700', 700, 700, true );
add_image_size( 'clinika_700x500', 700, 500, true );
add_image_size( 'clinika_1150x400', 1150, 400, true );
add_image_size( 'clinika_700x500', 700, 500, true );
add_image_size( 'clinika_96x96', 96, 96, true );
add_image_size( 'clinika_500x500', 500, 500, true );
add_image_size( 'clinika_1150x550', 1150, 550, true );
add_image_size( 'clinika_1000x580', 1000, 580, true );
add_image_size( 'clinika_1400x400', 1400, 400, true );

/**
||-> LIMIT POST CONTENT
*/
function clinika_excerpt_limit($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if(count($words) > $word_limit) {
        array_pop($words);
    }
  
    return implode(' ', $words);
}

if (!function_exists('clinika_excerpt_limit_length')) {
    // Filter except length to 35 words.
    function clinika_excerpt_limit_length( $length ) {
        return 30;
    }
    add_filter( 'excerpt_length', 'clinika_excerpt_limit_length', 999 );
}

/**
||-> BREADCRUMBS
*/
if (!function_exists('clinika_breadcrumb')) {
    function clinika_breadcrumb() {
        
        global  $clinika_redux;

        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            if ( !$clinika_redux['modeltheme-enable-breadcrumbs'] ) {
                return false;
            }
        }

        $delimiter = '';
        $name = esc_html__("Home", "clinika");

            if (!is_home() && !is_front_page() || is_paged()) {
                global  $post;
                $home = esc_url(home_url('/'));
                echo '<li><a href="'.esc_url($home).'">' . esc_html($name) . '</a></li> ' . esc_html($delimiter) . '';
            
            if (is_category()) {
                global  $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                    if ($thisCat->parent != 0)
                echo (get_category_parents($parentCat, true, '' . esc_html($delimiter). ''));
                echo '<li class="active">' . single_cat_title('', false) . '</li>';
            }elseif (is_tax()) {
                global  $wp_query;
                echo  '<li class="active">' . single_cat_title('', false) . '</li>';
            } elseif (is_day()) {
                echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter). '';
                echo '<li><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('F') . '</a></li> ' . esc_html($delimiter). ' ';
                echo  '<li class="active">' . get_the_time('d') . '</li>';
            } elseif (is_month()) {
                echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter). '';
                echo  '<li class="active">' . get_the_time('F') . '</li>';
            } elseif (is_year()) {
                echo  '<li class="active">' . get_the_time('Y') . '</li>';
            } elseif (is_attachment()) {
                echo '<li class="active">';
                the_title();
                echo '</li>';
            } elseif (class_exists( 'WooCommerce' ) && is_shop()) {
                echo '<li class="active">';
                echo esc_html__('Shop','clinika');
                echo '</li>';
            }elseif (class_exists( 'WooCommerce' ) && is_product()) {

                global  $post;
                $cat = get_the_terms( $post->ID, 'product_cat' );

                if ($cat) {
                    foreach ($cat as $categoria) {
                        if($categoria->parent == 0){

                            // Get the ID of a given category
                            $category_id = get_cat_ID( $categoria->name );

                            // Get the URL of this category
                            $category_link = get_category_link( $category_id );

                            echo '<li><a href="'.esc_url(get_term_link($categoria->slug, 'product_cat')).'">' . esc_html($categoria->name) . '</a></li>';
                            echo esc_url($category_link);
                        }
                    }
                }

                echo  '<li class="active">';
                the_title();
                echo '</li>';

            } elseif (is_single()) {
                if (get_the_category()) {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    echo '<li>' . get_category_parents($cat, true, ' ' . esc_html($delimiter). '') . '</li>';
                }
                echo  '<li class="active">';
                the_title();
                echo '</li>';
            } elseif (is_page() && !$post->post_parent) {
                echo '<li class="active">';
                the_title();
                echo '</li>';
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb)
                    echo esc_html($crumb) . ' ' . esc_html($delimiter). ' ';
                echo '<li class="active">';
                    the_title();
                echo '</li>';
            } elseif (is_search()) {
                echo '<li class="active">' . get_search_query() . '</li>';
            } elseif (is_tag()) {
                echo '<li class="active">' . single_tag_title( '', false ) . '</li>';
            } elseif (is_author()) {
                global  $author;
                $userdata = get_userdata($author);
                echo '<li class="active">' . esc_html($userdata->display_name) . '</li>';
            } elseif (is_404()) {
                echo '<li class="active">' . esc_html__('404 Not Found','clinika') . '</li>';
            }
            if (get_query_var('paged')) {
                if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo '<li class="active">';
                echo esc_html__('Page','clinika') . ' ' . get_query_var('paged');
                if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo '</li>';
            }
        }
    }
}

/**
||-> PAGINATION
*/
if ( ! function_exists( 'clinika_pagination' ) ) {
    function clinika_pagination($query = null) {

        if (!$query) {
            global  $wp_query;
            $query = $wp_query;
        }
        
        $big = 999999999; // need an unlikely integer
        $current = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : '1');
        echo paginate_links( 
            array(
                'base'          => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'        => '?paged=%#%',
                'current'       => max( 1, $current ),
                'total'         => $query->max_num_pages,
                'prev_text'     => '&#171;',
                'next_text'     => '&#187;',
            ) 
        );
    }
}


/**
||-> SEARCH FOR POSTS ONLY
*/

function clinika_redux($redux_meta_name1 = '',$redux_meta_name2 = ''){

    global  $clinika_redux;
    if (is_null($clinika_redux)) {
        return;
    }
    
    $html = '';
    if (isset($redux_meta_name1) && !empty($redux_meta_name1) && !empty($redux_meta_name2)) {
        $html = $clinika_redux[$redux_meta_name1][$redux_meta_name2];
    }elseif(isset($redux_meta_name1) && !empty($redux_meta_name1) && empty($redux_meta_name2)){
        $html = $clinika_redux[$redux_meta_name1];
    }
    
    return $html;
}


/**
||-> FUNCTION: ADD EDITOR STYLE
*/
function clinika_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}
add_action( 'admin_init', 'clinika_add_editor_styles' );


/**

||-> FUNCTION: CUSTOM SEARCH FORM

*/
function clinika_custom_search_form(){

    $content = '';
    $content .= '<div class="modeltheme-search">
                    <form method="GET" action="'.esc_url(home_url('/')).'">
                        <input class="search-input" placeholder="'.esc_attr__('Enter search term...', 'clinika').'" type="search" value="" name="s" id="search" />
                        <input type="hidden" name="post_type" value="post" />
                        <input class="search-submit" type="submit" value="'.esc_attr__('Search', 'clinika').'" />
                    </form>
                </div>';

    return $content;
}


/**
||-> REMOVE PLUGINS NOTIFICATIONS and NOTICES
*/
// |---> REVOLUTION SLIDER
if(function_exists( 'set_revslider_as_theme' )){
    add_action( 'init', 'clinika_disable_revslider_update_notices' );
    function clinika_disable_revslider_update_notices() {
        set_revslider_as_theme();
    }
}


function clinika_search_form( $form ) {
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url( '/' )) . '" >
    <label><input type="text" class="search-field" placeholder="'.esc_attr__('Search ...','clinika').'" name="s" id="s" /></label>
    <button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'clinika_search_form', 100 );

// Removing the WPBakery frontend editor
if (!function_exists('clinika_disable_wpbakery_frontend_editor')) {
    function clinika_disable_wpbakery_frontend_editor(){
        /**
        * Removes frontend editor
        */
        // if ( function_exists( 'vc_disable_frontend' ) ) {
        //     vc_disable_frontend();
        // }
    }
    add_action('vc_after_init', 'clinika_disable_wpbakery_frontend_editor');
}

// KSES ALLOWED HTML
if (!function_exists('clinika_kses_allowed_html')) {
    function clinika_kses_allowed_html($tags, $context) {
      switch($context) {
        case 'link': 
            $tags = array( 
                'a' => array(
                    'href' => array(),
                    'class' => array(),
                    'title' => array(),
                    'target' => array(),
                    'rel' => array(),
                    'data-commentid' => array(),
                    'data-postid' => array(),
                    'data-belowelement' => array(),
                    'data-respondelement' => array(),
                    'data-replyto' => array(),
                    'aria-label' => array(),
                ),
                'img' => array(
                    'src' => array(),
                    'alt' => array(),
                    'style' => array(),
                    'height' => array(),
                    'width' => array(),

                ),
            );
            return $tags;
        break;

        case 'icon':
            $tags = array(
                'i' => array(
                    'class' => array(),
                ),
            );
            return $tags;
        break;
        
        default: 
            return $tags;
      }
    }
    add_filter( 'wp_kses_allowed_html', 'clinika_kses_allowed_html', 10, 2);
}


/**
 * Minifying the CSS
  */
function clinika_minify_css($css){
  $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
  return $css;
}


/* My Account */
if (!function_exists('clinika_account_login_lightbox')) {
    function clinika_account_login_lightbox(){
        if ( class_exists( 'WooCommerce' ) ) {
            if (!is_user_logged_in() && !is_account_page()) {
                ?>
                <div class="modeltheme-modal-holder">
                    <div class="modeltheme-overlay-inner"></div>
                    <div class="modeltheme-modal-container">
                        <div class="modeltheme-modal" id="modal-log-in">
                            <div class="modeltheme-content" id="login-modal-content">
                                <h3 class="relative text-center">
                                    <?php echo esc_html__('Access Your Account', 'clinika'); ?>
                                </h3>
                                <div class="modal-content row">
                                    <div class="col-md-12">
                                        <?php wc_get_template_part('myaccount/form-login'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <?php
            }
        }
    }
    add_action('clinika_after_body_open_tag', 'clinika_account_login_lightbox');
}