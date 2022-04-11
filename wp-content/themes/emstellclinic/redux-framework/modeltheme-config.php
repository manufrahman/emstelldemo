<?php
/**
  ReduxFramework Modeltheme Theme Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */


if (!class_exists("Redux_Framework_clinika_config")) {

    class Redux_Framework_clinika_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }
            
            // This is needed. Bah WordPress bugs.  ;)
            if ( get_template_directory() && strpos( Redux_Helpers::cleanFilePath(__FILE__), Redux_Helpers::cleanFilePath( get_template_directory() ) ) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);    
            }
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

 
        public function setSections() {

            include_once(get_template_directory() . '/redux-framework/modeltheme-config.arrays.php');
            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $clinika_patterns_path = ReduxFramework::$_dir . '../polygon/patterns/';
            $clinika_patterns_url = ReduxFramework::$_url . '../polygon/patterns/';
            $clinika_patterns = array();

            if (is_dir($clinika_patterns_path)) :

                if ($clinika_patterns_dir = opendir($clinika_patterns_path)) :
                    $clinika_patterns = array();

                    while (( $clinika_patterns_file = readdir($clinika_patterns_dir) ) !== false) {

                        if (stristr($clinika_patterns_file, '.png') !== false || stristr($clinika_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $clinika_patterns_file);
                            $name = str_replace('.' . end($name), '', $clinika_patterns_file);
                            $clinika_patterns[] = array('alt' => $name, 'img' => $clinika_patterns_url . $clinika_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'clinika'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php the_title_attribute('echo=0'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','clinika'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo  esc_attr($this->theme->display('Name')); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'clinika'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'clinika'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . esc_html__('Tags', 'clinika') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo  esc_attr($this->theme->display('Description')); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' .__('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'clinika') . '</p>', esc_url('http://codex.WordPress.org/Child_Themes'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $pmHTML = '';
            if (file_exists(get_template_directory() . '/redux-framework/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global  $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH.'wp-admin/includes/file.php' );
                    WP_Filesystem();
                }
                $pmHTML = $wp_filesystem->get_contents(get_template_directory() . '/redux-framework/info-html.html');
            }


            /**
            ||-> SECTION: General Settings
            */

            $this->sections[] = array(
                'icon' => 'el-icon-wrench',
                'title' => esc_html__('General Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_general_breadcrumbs',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '1.1 - Breadcrumbs', 'clinika' )
                    ),
                    array(
                        'id'       => 'modeltheme-enable-breadcrumbs',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Breadcrumbs', 'clinika'),
                        'subtitle' => esc_html__('Enable or disable breadcrumbs', 'clinika'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'breadcrumbs-delimitator',
                        'type'     => 'text',
                        'title'    => esc_html__('Breadcrumbs delimitator', 'clinika'),
                        'subtitle' => esc_html__('This is a little space under the Field Title in the Options table, additional info is good in here.', 'clinika'),
                        'desc'     => esc_html__('This is the description field, again good for additional info.', 'clinika'),
                        'default'  => '/'
                    ),
                    array(
                        'id' => 'clinika_header_breadcrumbs_image',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Header Breadcrumbs Area Image', 'clinika'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                    ),
                    array(
                        'id'       => 'clinika_border_radius',
                        'type'     => 'select', 
                        'title'    => __('Select Border Radius', 'clinika'),
                        'options'   => array(
                            'default'   => 'Rounded',
                            'round'     => 'Round',
                            'boxed'     => 'Rectangular'
                        ),
                        'default'   => 'default'
                    ),
                )
            );


            /**
            ||-> SECTION: Sidebars
            */
            $this->sections[] = array(
                'icon' => 'el-icon-stop',
                'title' => esc_html__('Sidebars', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_sidebars_generator',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '2.1 - Generate Unlimited Sidebars', 'clinika' )
                    ),
                    array(
                        'id'       => 'dynamic_sidebars',
                        'type'     => 'multi_text',
                        'title'    => esc_html__( 'Sidebars', 'clinika' ),
                        'subtitle' => esc_html__( 'Use the "Add More" button to create unlimited sidebars.', 'clinika' ),
                        'desc'     => esc_html__( '', 'clinika' ),
                        'add_text' => esc_html__( 'Add one more Sidebar', 'clinika' )
                    )
                )
            );


            /**
            ||-> SECTION: Back to Top
            */
            $this->sections[] = array(
                'icon'       => 'el el-circle-arrow-up',
                'title'      => esc_html__( 'Back to Top Button', 'clinika' ),
                'fields'     => array(
                    array(
                        'id'   => 'mt_back_to_top',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '3.1 - Back to Top Settings', 'clinika' )
                    ),
                    array(
                        'id'       => 'mt_backtotop_status',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Back to Top Button Status', 'clinika'),
                        'subtitle' => esc_html__('Enable or disable "Back to Top Button"', 'clinika'),
                        'default'  => true,
                    ),
                    array(         
                        'id'       => 'mt_backtotop_bg_color',
                        'type'     => 'background',
                        'title'    => esc_html__('Back to Top Button Status Backgrond', 'clinika'), 
                        'subtitle' => esc_html__('Default: #006ba6', 'clinika'),
                        'default'  => array(
                            'background-color' => '#006ba6',
                            'background-repeat' => 'no-repeat',
                            'background-position' => 'center center',
                            'background-image' => get_template_directory_uri().'/images/mt-to-top-arrow.svg',
                        )
                    ),
                ),
            );


            /**
            ||-> SECTION: Styling Settings
            */
            $this->sections[] = array(
                'icon'       => 'el-icon-magic',
                'title'      => esc_html__( 'Styling Settings', 'clinika' ),
                'fields'     => array(
                    array(
                        'id'   => 'mt_styling_colors',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '4.1 - Select Background and Colors', 'clinika' )
                    ),
                    array(
                        'id'       => 'mt_global_link_styling',
                        'type'     => 'link_color',
                        'title'    => esc_html__('Links Color Option', 'clinika'),
                        'subtitle' => esc_html__('Only color validation can be done on this field type(Default Regular: rgba(34, 52, 65, 1); Default Hover: #4db0e1; Default Active: #4db0e1;)', 'clinika'),
                        'default'  => array(
                            'regular'  => 'rgba(34, 52, 65, 1)', // blue
                            'hover'    => '#4db0e1', // blue-x3
                            'active'   => '#4db0e1',  // blue-x3
                            'visited'  => '#4db0e1',  // blue-x3
                        )
                    ),
                    array(
                        'id'       => 'mt_style_main_texts_color',
                        'type'     => 'color',  
                        'title'    => esc_html__('Main texts color', 'clinika'), 
                        'subtitle' => esc_html__('Default: #4db0e1', 'clinika'),
                        'default'  => '#4db0e1',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_main_backgrounds_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Main backgrounds color', 'clinika'), 
                        'subtitle' => esc_html__('Default: #006ba6', 'clinika'),
                        'default'  => '#006ba6',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_main_backgrounds_color_hover',
                        'type'     => 'color',
                        'title'    => esc_html__('Main backgrounds color (hover)', 'clinika'), 
                        'subtitle' => esc_html__('Default: #4db0e1', 'clinika'),
                        'default'  => '#4db0e1',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_semi_opacity_backgrounds',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Semitransparent blocks background', 'clinika' ),
                        'subtitle' => esc_html__( 'Default: rgba(56, 169, 224, 0.9)', 'clinika' ),
                        'default'  => array(
                            'color' => '#4db0e1',
                            'alpha' => '.7'
                        ),
                        'mode'     => 'background'
                    ),
                    array(
                        'id'       => 'mt_text_selection_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Text selection color', 'clinika'), 
                        'subtitle' => esc_html__('Default: #ffffff', 'clinika'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_text_selection_background_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Text selection background color', 'clinika'), 
                        'subtitle' => esc_html__('Default: #4db0e1', 'clinika'),
                        'default'  => '#4db0e1',
                        'validate' => 'color',
                    )

                ),
            );


            /**
            ||-> SECTION: Typography Settings
            */
            $this->sections[] = array(
                'icon' => 'el el-text-width',
                'title' => esc_html__('Typography Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_typo_custom_fonts',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.1 - Import Google Fonts', 'clinika' )
                    ),
                    array(
                        'id'       => 'google-fonts-select',
                        'type'     => 'select',
                        'multi'    => true,
                        'title'    => esc_html__('Import Google Font Globally', 'clinika'), 
                        'subtitle' => esc_html__('Select one or multiple fonts', 'clinika'),
                        'desc'     => esc_html__('Importing fonts made easy', 'clinika'),
                        'options'  => $google_fonts_list,
                        'default'  => array(
                                        'Jost:regular,300,400,500,600,700,bold',
                                        'Poppins:300,regular,500,600,700,latin-ext,latin,devanagari',
                                      ),
                    ),
                    array(
                        'id'   => 'mt_typo_blog_post',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.3 - Choose Article Font/Style', 'clinika' )
                    ),
                    array(
                        'id'          => 'modeltheme-blog-post-typography',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Blog Post Font family', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => false,
                        'font-weight'  => true,
                        'font-size'   => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Poppins', 
                            'font-weight'  => '400',
                            'google'      => true,
                        ),
                    ),
                    array(
                        'id'   => 'mt_typo_headings',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.4 - Choose Headings Font/Style', 'clinika' )
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h1',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H1 Font family', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '36px', 
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h2',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H2 Font family', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '30px', 
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h3',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H3 Font family', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '24px',
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h4',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H4 Font family', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '18px', 
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h5',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H5 Font family', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '14px', 
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h6',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H6 Font family', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '12px', 
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_typo_inputs',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.5 - Choose Inputs Font/Style', 'clinika' )
                    ),
                    array(
                        'id'                => 'modeltheme-inputs-typography',
                        'type'              => 'typography', 
                        'title'             => esc_html__('Inputs Font family', 'clinika'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => true,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'units'             =>'px',
                        'subtitle'          => esc_html__('Font family for inputs and textareas', 'clinika'),
                        'default'           => array(
                            'font-family'       => 'Poppins', 
                            'google'            => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_typo_buttons',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.6 - Choose Buttons Font/Style', 'clinika' )
                    ),
                    array(
                        'id'                => 'modeltheme-buttons-typography',
                        'type'              => 'typography', 
                        'title'             => esc_html__('Buttons Font family', 'clinika'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => true,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'units'             =>'px',
                        'subtitle'          => esc_html__('Font family for buttons', 'clinika'),
                        'default'           => array(
                            'font-family'       => 'Poppins',
                            'font-weight'       => '700', 
                            'google'            => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_typo_buttons',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.7 - Choose Menu Font/Style', 'clinika' )
                    ),
                    array(
                        'id'                => 'modeltheme-navigation-typography',
                        'type'              => 'typography', 
                        'title'             => esc_html__('Menu Font family', 'clinika'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => true,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'units'             =>'px',
                        'subtitle'          => esc_html__('Font family for buttons', 'clinika'),
                        'default'           => array(
                            'font-family'       => 'Poppins',
                            'font-weight'       => '600', 
                            'google'            => true
                        ),
                    ),
                )
            );

            /**
            ||-> SECTION: Responsive Typography
            */
            $this->sections[] = array(
                'title'      => esc_html__( 'Responsive Typography', 'clinika' ),
                'id'         => 'mt_styling_typography_responsive',
                'fields'     => array(
                    array(
                        'id'   => 'mt_divider_responsive_h_tablets',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__('Headings Typography on Tablets (Medium Resolution Devices)', 'clinika')
                    ),
                    array(
                        'id'          => 'mt_heading_h1_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H1 Font size - Tablets', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '36px', 
                            'line-height' => '39px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h2_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H2 Font size - Tablets', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '32px', 
                            'line-height' => '36px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h3_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H3 Font size - Tablets', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '26px', 
                            'line-height' => '32px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h4_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H4 Font size - Tablets', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-family'  => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '22px', 
                            'line-height' => '27px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h5_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H5 Font size - Tablets', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '20px', 
                            'line-height' => '23px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h6_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H6 Font size - Tablets', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'font-family'  => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '18px', 
                            'line-height' => '21px', 
                        ),
                    ),
                    array(
                        'id'   => 'mt_divider_responsive_h_smartphones',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__('Headings Typography on SmartPhones (Small Resolution Devices)', 'clinika')
                    ),
                    array(
                        'id'          => 'mt_heading_h1_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H1 Font size - Smartphones', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '26px', 
                            'line-height' => '29px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h2_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H2 Font size - Smartphones', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '24px', 
                            'line-height' => '27px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h3_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H3 Font size - Smartphones', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '22px', 
                            'line-height' => '25px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h4_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H4 Font size - Smartphones', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-family'  => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '19px', 
                            'line-height' => '22px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h5_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H5 Font size - Smartphones', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '16px', 
                            'line-height' => '19px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h6_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H6 Font size - Smartphones', 'clinika'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'font-family'  => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '14px', 
                            'line-height' => '17px', 
                        ),
                    ),
                ),
            );



            /**
            ||-> SECTION: Page Preloader
            */
            $this->sections[] = array(
                'title' => esc_html__( 'Page Preloader Settings', 'clinika' ),
                'icon' => 'el el-dashboard',
                'fields' => array(
                    array(
                        'id'   => 'mt_preloader_status',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '6.1 - Preloader Status', 'clinika' )
                    ),
                    array(
                        'id'       => 'mt_preloader_status',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Enable Page Preloader', 'clinika'),
                        'subtitle' => esc_html__('Enable or disable page preloader', 'clinika'),
                        'default'  => false,
                    ),
                    array(
                        'id'   => 'mt_preloader_styling',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '6.2 - Preloader Styling', 'clinika' )
                    ),
                    array(         
                        'id'       => 'mt_preloader_bg_color',
                        'type'     => 'background',
                        'title'    => esc_html__('Page Preloader Backgrond', 'clinika'), 
                        'subtitle' => esc_html__('Default: #4aafe1', 'clinika'),
                        'default'  => array(
                            'background-color' => '#4aafe1',
                        ),
                        'output' => array(
                            '.linify_preloader_holder'
                        )
                    ),
                    array(
                        'id'       => 'mt_preloader_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Preloader color:', 'clinika'), 
                        'subtitle' => esc_html__('Default: #ffffff', 'clinika'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                    ),
                ),
            );


            /**
            ||-> SECTION: Header Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-arrow-up',
                'title' => esc_html__('Header Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_header_layout',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '7.1 - Select Header layout', 'clinika' )
                    ),
                    array(
                        'id'       => 'header_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Select Header layout', 'clinika' ),
                        'options'  => array(
                            'first_header' => array(
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_1.jpg'
                            ),
                            'second_header' => array(
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_2.jpg'
                            ),
                            'third_header' => array(
                                'img' => get_template_directory_uri().'/redux-framework/assets/headers/header_2.jpg'
                            ),
                        ),
                        'default'  => 'first_header'
                    ),
                    array(
                        'id'   => 'mt_divider_second_header',
                        'type' => 'info',
                        'class' => 'ibid_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 2 Custom Settings', 'clinika' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'second_header' ),
                    ),
                
                    array(
                        'id' => 'clinika_header_booking',
                        'type' => 'text',
                        'title' => esc_html__('Booking Button Link', 'clinika'),
                        'required' => array( 'header_layout', '=', 'second_header' ),
                        'default' => 'https://clinika.modeltheme.com/booking'
                    ),
                    array(
                        'id'   => 'mt_divider_third_header',
                        'type' => 'info',
                        'class' => 'ibid_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 3 Custom Settings', 'clinika' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'third_header' ),
                    ),
                    array(
                        'id' => 'clinika_header_donation',
                        'type' => 'text',
                        'title' => esc_html__('Booking Button Link', 'clinika'),
                        'required' => array( 'header_layout', '=', 'third_header' ),
                        'default' => 'https://clinika.modeltheme.com/booking'
                    ),
                    array(
                        'id' => 'clinika_header_donation_txt',
                        'type' => 'text',
                        'title' => esc_html__('Booking Button Text', 'clinika'),
                        'required' => array( 'header_layout', '=', 'third_header' ),
                        'default' => 'Donate'
                    ),
                    array(
                        'id'   => 'mt_header_main',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '7.3 - Header Main - Options', 'clinika' )
                    ),
                    array(
                        'id' => 'clinika_logo',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Logo', 'clinika'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/theme_clinika_logo.png'),
                    ),
                    array(
                        'id' => 'clinika_logo_sticky_header',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Logo (Sticky Header)', 'clinika'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/theme_clinika_logo_dark.png'),
                    ),
                    array(
                        'id'        => 'logo_max_width',
                        'type'      => 'slider',
                        'title'     => esc_html__('Logo Max Width', 'clinika'),
                        'subtitle'  => esc_html__('Use the slider to increase/decrease max size of the logo.', 'clinika'),
                        'desc'      => esc_html__('Min: 1px, max: 500px, step: 1px, default value: 140px', 'clinika'),
                        "default"   => 177,
                        "min"       => 1,
                        "step"      => 1,
                        "max"       => 500,
                        'display_value' => 'label'
                    ),
                    array(
                        'id' => 'clinika_favicon',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Favicon url', 'clinika'),
                        'compiler' => 'true',
                        'desc' => esc_html__('', 'clinika'),
                        'subtitle' => esc_html__('Use the upload button to import media.', 'clinika'),
                        'default' => array('url' => get_template_directory_uri().'/images/theme_clinika_favicon.png'),
                    ),
                    array(         
                        'id'       => 'header_main_background',
                        'type'     => 'background',
                        'title'    => esc_html__('Header (main-header) - background', 'clinika'),
                        'subtitle' => esc_html__('Header background with image or color.', 'clinika'),
                        'output'      => array('.navbar-default,.sub-menu'),
                        'default'  => array(
                            'background-color' => '#fff',
                        )
                    ),
                    array(
                        'id'       => 'header_nav_color',
                        'type'     => 'color',  
                        'title'    => esc_html__('Navigation texts color', 'clinika'), 
                        'subtitle' => esc_html__('Default: #fff', 'clinika'),
                        'default'  => '#fff',
                        'validate' => 'color',
                        'output'   => array('.is_header_semitransparent #navbar .menu-item > a')
                    ),
                    array(
                        'id'       => 'is_nav_sticky',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Fixed Navigation menu?', 'clinika'),
                        'subtitle' => esc_html__('Enable or disable "fixed positioned navigation menu".', 'clinika'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'header_width',
                        'type'     => 'select', 
                        'title'    => __('Select Header Width', 'clinika'),
                        'options'   => array(
                            'container'   => 'Contain',
                            'fullwidth'   => 'Fullwidth'
                        ),
                        'default'   => 'container'
                    ),
                    array(
                        'id'   => 'mt_top_bar',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( 'Top Bar', 'clinika' )
                    ),
                    array(
                        'id'       => 'is_top_bar',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Enable Header Top Bar?', 'clinika'),
                        'subtitle' => esc_html__('Enable or disable Header Top Bar', 'clinika'),
                        'default'  => false,
                    ),
                )
            );


            /**
            ||-> SECTION: Footer Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-arrow-down',
                'title' => esc_html__('Footer Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_footer_rows_1',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '8.1 - Footer Widgets Row #1', 'clinika' )
                    ),
                    array(
                        'id'       => 'footer_row_1',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Footer Row #1 - Status', 'clinika' ),
                        'subtitle' => esc_html__( 'Enable/Disable Footer ROW 1', 'clinika' ),
                        'default'  => 0,
                        'on'       => esc_html__( 'Enabled', 'clinika' ),
                        'off'      => esc_html__( 'Disabled', 'clinika' ),
                    ),
                    array(
                        'id'       => 'footer_row_1_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Footer Row #1 - Layout', 'clinika' ),
                        'options'  => array(
                            '1' => array(
                                'alt' => 'Footer 1 Column',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_1.png'
                            ),
                            '2' => array(
                                'alt' => 'Footer 2 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_2.png'
                            ),
                            '3' => array(
                                'alt' => 'Footer 3 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_3.png'
                            ),
                            '4' => array(
                                'alt' => 'Footer 4 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_4.png'
                            ),
                            '5' => array(
                                'alt' => 'Footer 5 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_5.png'
                            ),
                            '6' => array(
                                'alt' => 'Footer 6 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_6.png'
                            ),
                            'column_half_sub_half' => array(
                                'alt' => 'Footer 6 + 3 + 3',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_half_sub_half.png'
                            ),
                            'column_sub_half_half' => array(
                                'alt' => 'Footer 3 + 3 + 6',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_sub_half_half.png'
                            ),
                            'column_sub_fourth_third' => array(
                                'alt' => 'Footer 2 + 2 + 2 + 2 + 4',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_sub_fourth_third.png'
                            ),
                            'column_third_sub_fourth' => array(
                                'alt' => 'Footer 4 + 2 + 2 + 2 + 2',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_third_sub_fourth.png'
                            ),
                            'column_sub_third_half' => array(
                                'alt' => 'Footer 2 + 2 + 2 + 6',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_sub_third_half.png'
                            ),
                            'column_half_sub_third' => array(
                                'alt' => 'Footer 6 + 2 + 2 + 2',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_sub_third_half2.png'
                            ),
                            'column_fourth_sub_half' => array(
                                'alt' =>'Footer 4 + 2 + 2 + 4',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_4_2_2_4.jpg'
                            ),
                        ),
                        'default'  => '4',
                        'required' => array( 'footer_row_1', '=', '1' ),
                    ),
                    array(
                        'id'             => 'footer_row_1_spacing',
                        'type'           => 'spacing',
                        'output'         => array('.footer-row-1'),
                        'mode'           => 'padding',
                        'units'          => array('em', 'px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Footer Row #1 - Padding', 'clinika'),
                        'subtitle'       => esc_html__('Choose the spacing for the first row from footer.', 'clinika'),
                        'required' => array( 'footer_row_1', '=', '1' ),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-bottom'  => '0px', 
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'             => 'footer_row_1margin',
                        'type'           => 'spacing',
                        'output'         => array('.footer-row-1'),
                        'mode'           => 'margin',
                        'units'          => array('em', 'px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Footer Row #1 - Margin', 'clinika'),
                        'subtitle'       => esc_html__('Choose the margin for the first row from footer.', 'clinika'),
                        'required' => array( 'footer_row_1', '=', '1' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-bottom'  => '0px', 
                            'units'          => 'px', 
                        )
                    ),
                    array( 
                        'id'       => 'footer_row_1border',
                        'type'     => 'border',
                        'title'    => esc_html__('Footer Row #1 - Borders', 'clinika'),
                        'subtitle' => esc_html__('Only color validation can be done on this field', 'clinika'),
                        'output'   => array('.footer-row-1'),
                        'all'      => false,
                        'required' => array( 'footer_row_1', '=', '1' ),
                        'default'  => array(
                            'border-color'  => '#515b5e', 
                            'border-style'  => 'solid', 
                            'border-top'    => '0', 
                            'border-right'  => '0', 
                            'border-bottom' => '0', 
                            'border-left'   => '0'
                        )
                    ),


                    array(
                        'id'   => 'mt_footer_copyright_text',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '8.4 - Footer Copyright Text - Options', 'clinika' )
                    ),
                    array(
                        'id'       => 'modeltheme-enable-copyright',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Footer Copyright', 'clinika'),
                        'subtitle' => esc_html__('Enable or disable footer copyright', 'clinika'),
                        'default'  => true,
                    ),
                    array(
                        'id' => 'clinika_footer_text_left',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Text left', 'clinika'),
                        'required' => array('modeltheme-enable-copyright', 'equals', '1'),
                        'default' => 'Copyright Clinika | All right Reserved',
                    ),
                    array(
                        'id' => 'clinika_footer_text_right',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Text right', 'clinika'),
                        'required' => array('modeltheme-enable-copyright', 'equals', '1'),
                        'default' => '© Clinika Theme by <a href="https://modeltheme.com" target="_blank" rel="noopener">ModelTheme.com</a>. All rights Reserved.',
                    ),
                    array(
                        'id'   => 'mt_footer_styling',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '8.5 - Footer Styling', 'clinika' )
                    ),
                    array(
                        'id'        => 'footer-global-texts-color',
                        'type'      => 'color_rgba',
                        'title'     => 'Footer Global Text Color',
                        'subtitle'  => 'Set color and alpha channel',
                        'desc'      => 'Set color and alpha channel for footer texts (Especially for widget titles)',
                        'output'    => array('color' => 'footer h1.widget-title, footer h3.widget-title, footer .widget-title, footer .textwidget, p.copyright, footer .menu .menu-item a, footer .textwidget p, .footer-top .tagcloud > a'),
                        'default'   => array(
                            'color'     => '#fff',
                            'alpha'     => 1
                        ),
                        'options'       => array(
                            'show_input'                => true,
                            'show_initial'              => true,
                            'show_alpha'                => true,
                            'show_palette'              => true,
                            'show_palette_only'         => false,
                            'show_selection_palette'    => true,
                            'max_palette_size'          => 10,
                            'allow_empty'               => true,
                            'clickout_fires_change'     => false,
                            'choose_text'               => 'Choose',
                            'cancel_text'               => 'Cancel',
                            'show_buttons'              => true,
                            'use_extended_classes'      => true,
                            'palette'                   => null,
                            'input_text'                => 'Select Color'
                        ),                        
                    ),
                    array(         
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => esc_html__('Footer (top) - background', 'clinika'),
                        'subtitle' => esc_html__('Footer background with image or color.', 'clinika'),
                        'output'      => array('footer'),
                        'default'  => array(
                            'background-color' => '#006BA6',
                        )
                    ),
                    array(         
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => esc_html__('Footer (bottom) - background', 'clinika'),
                        'subtitle' => esc_html__('Footer background with image or color.', 'clinika'),
                        'output'      => array('footer .footer'),
                        'default'  => array(
                            'background-color' => '#006ba6',
                        )
                    )
                )
            );



            /**
            ||-> SECTION: Contact Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-map-marker-alt',
                'title' => esc_html__('Contact Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_contact',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '10.1 - Contact Settings', 'clinika' )
                    ),
                    array(
                        'id' => 'clinika_contact_phone',
                        'type' => 'text',
                        'title' => esc_html__('Phone Number', 'clinika'),
                        'subtitle' => esc_html__('Contact phone number displayed on the contact us page.', 'clinika'),
                        'validate_callback' => 'redux_validate_callback_function',
                        'default' => ' +04 77 333 454 221'
                    ),
                    array(
                        'id' => 'clinika_contact_email',
                        'type' => 'text',
                        'title' => esc_html__('Email', 'clinika'),
                        'subtitle' => esc_html__('Contact email displayed on the contact us page., additional info is good in here.', 'clinika'),
                        'validate' => 'email',
                        'msg' => 'custom error message',
                        'default' => 'clinika@example.com'
                    ),
                    array(
                        'id' => 'clinika_contact_address',
                        'type' => 'text',
                        'title' => esc_html__('Address', 'clinika'),
                        'subtitle' => esc_html__('Enter your contact address', 'clinika'),
                        'default' => '321 Education Street,  New York, NY, USA'
                    ),
                    array(
                        'id' => 'mt_listings_api_key',
                        'type' => 'text',
                        'title' => esc_html__('Google Maps Key', 'clinika'),
                        'subtitle' => esc_html__('Generate a maps key from your google account and paste it here.', 'clinika'),
                    )
                )
            );


            /**
            ||-> SECTION: Services Settings
            */
            $this->sections[] = array(
                'icon' => 'fa fa-briefcase',
                'title' => esc_html__('Services Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_services',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '11.1 - Services Settings', 'clinika' )
                    ),
                    array(
                        'id'       => 'clinika_single_service_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single Service Layout', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Single Service Layout.', 'clinika' ),
                        'options'  => array(
                            'clinika_service_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'clinika_service_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'clinika_service_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'clinika_service_right_sidebar',
                    ),
                    array(
                        'id'       => 'clinika_single_service_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Single Service Sidebar', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Single Service Sidebar.', 'clinika' ),
                        'default'   => 'sidebar-1',
                        'required' => array('clinika_single_service_layout', '!=', 'clinika_service_fullwidth'),
                    ),

                )
            );


            /**
            ||-> SECTION: Blog Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-comment',
                'title' => esc_html__('Blog Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_blog_list',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '12.1 - Blog Archive Options', 'clinika' )
                    ),
                     array(
                            'id'       => 'clinika_blog_layout',
                            'type'     => 'image_select',
                            'compiler' => true,
                            'title'    => esc_html__( 'Blog List Layout', 'clinika' ),
                            'subtitle' => esc_html__( 'Select Blog List layout.', 'clinika' ),
                            'options'  => array(
                                'clinika_blog_left_sidebar' => array(
                                    'alt' => '2 Columns - Left sidebar',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                                ),
                                'clinika_blog_fullwidth' => array(
                                    'alt' => '1 Column - Full width',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                                ),
                                'clinika_blog_right_sidebar' => array(
                                    'alt' => '2 Columns - Right sidebar',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                                )
                            ),
                            'default'  => 'clinika_blog_left_sidebar'
                        ),
                    array(
                        'id'       => 'clinika_blog_layout_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Blog List Sidebar', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Blog List Sidebar.', 'clinika' ),
                        'default'   => 'sidebar-1',
                        'required' => array('clinika_blog_layout', '!=', 'clinika_blog_fullwidth'),
                    ),
                    array(
                        'id'        => 'blog-display-type',
                        'type'      => 'select',
                        'title'     => esc_html__('How to display posts', 'clinika'),
                        'subtitle'  => esc_html__('Select how you want to display post on blog list.', 'clinika'),
                        'options'   => array(
                                'list'   => 'List',
                                'grid'   => 'Grid'
                            ),
                        'default'   => 'grid',
                        ),
                    array(
                        'id'        => 'blog-grid-columns',
                        'type'      => 'select',
                        'title'     => esc_html__('Grid columns', 'clinika'),
                        'subtitle'  => esc_html__('Select how many columns you want.', 'clinika'),
                        'options'   => array(
                                '1'   => '1',
                                '2'   => '2',
                                '3'   => '3',
                                '4'   => '4'
                            ),
                        'default'   => '1',
                        'required' => array('blog-display-type', 'equals', 'grid'),
                    ),
                    array(
                        'id'   => 'mt_blog_article',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '12.2 - Blog Article Options', 'clinika' )
                    ),
                    array(
                        'id'       => 'clinika_single_blog_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single Blog Layout', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Single Blog Layout.', 'clinika' ),
                        'options'  => array(
                            'clinika_blog_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'clinika_blog_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'clinika_blog_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'clinika_blog_left_sidebar',
                        ),
                    array(
                        'id'       => 'clinika_single_blog_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Single Blog Sidebar', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Single Blog Sidebar.', 'clinika' ),
                        'default'   => 'sidebar-1',
                        'required' => array('clinika_single_blog_layout', '!=', 'clinika_blog_fullwidth'),
                    ),
                    array(
                        'id'       => 'post_featured_image',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Enable/disable featured image for single post.', 'clinika'),
                        'subtitle' => esc_html__('Show or Hide the featured image from blog post page.".', 'clinika'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'modeltheme-enable-related-posts',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Related Posts', 'clinika'),
                        'subtitle' => esc_html__('Enable or disable related posts', 'clinika'),
                        'default'  => false,
                    ),
                )
            );


            /**
            ||-> SECTION: Shop Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-shopping-cart-sign',
                'title' => esc_html__('Shop Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_shop',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '13.1 - Shop Archive Options', 'clinika' )
                    ),
                    array(
                        'id'       => 'clinika_shop_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Shop List Products Layout', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Shop List Products layout.', 'clinika' ),
                        'options'  => array(
                            'clinika_shop_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                        ),
                        'default'  => 'clinika_shop_fullwidth'
                    ),
                    array(
                        'id'       => 'clinika_shop_layout_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Shop List Sidebar', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Shop List Sidebar.', 'clinika' ),
                        'default'   => 'sidebar-1',
                        'required' => array('clinika_shop_layout', '!=', 'clinika_shop_fullwidth'),
                    ),
                    array(
                        'id'        => 'modeltheme-shop-columns',
                        'type'      => 'select',
                        'title'     => esc_html__('Number of shop columns', 'clinika'),
                        'subtitle'  => esc_html__('Number of products per column to show on shop list template.', 'clinika'),
                        'options'   => array(
                            '2'   => '2 columns',
                            '3'   => '3 columns',
                            '4'   => '4 columns'
                        ),
                        'default'   => '3',
                    ),


                    array(
                        'id'   => 'mt_shop_single',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '13.2 - Shop Single Product Options', 'clinika' )
                    ),
                     array(
                        'id'       => 'clinika_single_product_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single Product Layout', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Single Product Layout.', 'clinika' ),
                        'options'  => array(
                            'clinika_shop_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                        ),
                        'default'  => 'clinika_shop_fullwidth'
                    ),
                    array(
                        'id'       => 'clinika_single_shop_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Shop Single Product Sidebar', 'clinika' ),
                        'subtitle' => esc_html__( 'Select Single Product Sidebar.', 'clinika' ),
                        'default'   => 'sidebar-1',
                        'required' => array('clinika_single_product_layout', '!=', 'clinika_shop_fullwidth'),
                    ),
                    array(
                        'id'       => 'modeltheme-enable-related-products',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Related Products', 'clinika'),
                        'subtitle' => esc_html__('Enable or disable related products on single product', 'clinika'),
                        'default'  => true,
                    ),
                    array(
                        'id'        => 'modeltheme-related-products-number',
                        'type'      => 'select',
                        'title'     => esc_html__('Number of related products', 'clinika'),
                        'subtitle'  => esc_html__('Number of related products to show on single product template.', 'clinika'),
                        'options'   => array(
                            '2'   => '3',
                            '3'   => '6',
                            '4'   => '9'
                        ),
                        'default'   => '3',
                        'required' => array('modeltheme-enable-related-products', '=', true),
                    ),

                )
            );


            /**
            ||-> SECTION: Social Media Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-myspace',
                'title' => esc_html__('Social Media Settings', 'clinika'),
                'fields' => array(
                    array(
                        'id'   => 'mt_social_media',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '15.1 - Social Media Urls', 'clinika' )
                    ),
                    array(
                        'id' => 'clinika_social_fb',
                        'type' => 'text',
                        'title' => esc_html__('Facebook URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Facebook url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_tw',
                        'type' => 'text',
                        'title' => esc_html__('Twitter username', 'clinika'),
                        'subtitle' => esc_html__('Type your Twitter username.', 'clinika'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Pinterest url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_skype',
                        'type' => 'text',
                        'title' => esc_html__('Skype Name', 'clinika'),
                        'subtitle' => esc_html__('Type your Skype username.', 'clinika'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_instagram',
                        'type' => 'text',
                        'title' => esc_html__('Instagram URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Instagram url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_youtube',
                        'type' => 'text',
                        'title' => esc_html__('YouTube URL', 'clinika'),
                        'subtitle' => esc_html__('Type your YouTube url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_dribbble',
                        'type' => 'text',
                        'title' => esc_html__('Dribbble URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Dribbble url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_linkedin',
                        'type' => 'text',
                        'title' => esc_html__('LinkedIn URL', 'clinika'),
                        'subtitle' => esc_html__('Type your LinkedIn url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_deviantart',
                        'type' => 'text',
                        'title' => esc_html__('Deviant Art URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Deviant Art url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_digg',
                        'type' => 'text',
                        'title' => esc_html__('Digg URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Digg url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_flickr',
                        'type' => 'text',
                        'title' => esc_html__('Flickr URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Flickr url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_stumbleupon',
                        'type' => 'text',
                        'title' => esc_html__('Stumbleupon URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Stumbleupon url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_tumblr',
                        'type' => 'text',
                        'title' => esc_html__('Tumblr URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Tumblr url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'clinika_social_vimeo',
                        'type' => 'text',
                        'title' => esc_html__('Vimeo URL', 'clinika'),
                        'subtitle' => esc_html__('Type your Vimeo url.', 'clinika'),
                        'validate' => 'url',
                        'default' => ''
                    ),

                )
            );


            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri"><strong>' . esc_html__('Theme URL:', 'clinika') . '</strong> 
            <a href="' . esc_url($this->theme->get('ThemeURI')) . '" target="_blank">' .  esc_url($this->theme->get('ThemeURI')) . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author"><strong>' . esc_html__('Author:', 'clinika') . '</strong> ' . esc_attr($this->theme->get('Author')) . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version"><strong>' . esc_html__('Version:', 'clinika') . '</strong> ' . esc_attr($this->theme->get('Version')) . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . esc_attr($this->theme->get('Description')) . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags"><strong>' . esc_html__('Tags:', 'clinika') . '</strong> ' . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1'
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2'
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = '';
        }

        /**
          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
        */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'redux_demo', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Theme Panel', 'clinika'),
                'page' => esc_html__('Theme Panel', 'clinika'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => 'clinika_redux', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.WordPress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => get_template_directory_uri().'/images/svg/theme-panel-menu-icon.svg', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                'domain'              => 'clinika', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '',       
                'show_options_object'       => false,
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('', 'clinika'), $v);
            } else {
                $this->args['intro_text'] = '';
            }

            // Add content after the form.
            $this->args['footer_text'] = '';
        }

    }

    new Redux_Framework_clinika_config();
}