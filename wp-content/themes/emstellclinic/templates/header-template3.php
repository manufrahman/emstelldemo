<?php
  $blog_title = get_bloginfo();
?>

  <!-- BOTTOM BAR -->
<?php 
  if ( class_exists( 'ReduxFrameworkPlugin' ) ) {        
      if ( clinika_redux('header_width') == 'fullwidth') {
          $header_container = 'fullwidth';
      }else{
          $header_container = 'container';
      }
  } else { 
    $header_container = 'container';
  } 
?>

  <nav class="header-v3 navbar navbar-default" id="modeltheme-main-head">
    <div class="<?php echo esc_html($header_container); ?>">
      <div class="row">
        <div class="navbar-header col-md-2">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <div class="logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
              <?php echo clinika_get_theme_logo(); ?>
              
              <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                <?php if ( clinika_redux('is_nav_sticky') != false ) { ?>
                  <?php echo clinika_get_theme_logo_sticky(); ?>
                <?php } ?>
              <?php } ?>
            </a>
          </div>
        </div>

        <div id="navbar" class="navbar-collapse collapse col-md-7">
          <div class="menu nav navbar-nav nav-effect nav-menu">
           <?php
              if ( has_nav_menu( 'primary' ) ) {
                $defaults = array(
                  'menu'            => '',
                  'container'       => false,
                  'container_class' => '',
                  'container_id'    => '',
                  'menu_class'      => 'menu',
                  'menu_id'         => '',
                  'echo'            => true,
                  'fallback_cb'     => false,
                  'before'          => '',
                  'after'           => '',
                  'link_before'     => '',
                  'link_after'      => '',
                  'items_wrap'      => '%3$s',
                  'depth'           => 0,
                  'walker'          => ''
                );
                $defaults['theme_location'] = 'primary';
                wp_nav_menu( $defaults );
              }else{
                if ( is_user_logged_in() ) {
                  echo '<p class="no-menu text-left">';
                    echo esc_html__('Primary navigation menu is missing.', 'clinika');
                  echo '</p>';
                }
              }
            ?>
          </div>
        </div>
        <div class="col-md-2 no-mobile">
          <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
            <?php if ( clinika_redux('clinika_contact_phone') ) { ?>
              <div class="telephone-btn">
                <a href="tel:<?php echo esc_html__(clinika_redux('clinika_contact_phone')); ?>"><?php echo esc_html__(clinika_redux('clinika_contact_phone')); ?></p></a>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
        <div class="col-md-1 no-mobile">
          <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
            <a href="<?php echo esc_url(clinika_redux('clinika_header_donation')); ?>">
            <div class="contact-btn">
              <p><?php echo esc_html__(clinika_redux('clinika_header_donation_txt')); ?></p>
            </div></a>
          <?php } ?>
        </div>
      </div>
    </div>
  </nav>