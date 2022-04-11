<?php
/**
 * The template for displaying the footer.
 *
*/

?>

    <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        <?php if (clinika_redux('mt_backtotop_status') == true) { ?>
            <!-- BACK TO TOP BUTTON -->
            <a class="back-to-top modeltheme-is-visible modeltheme-fade-out">
                <span></span>
            </a>
        <?php } ?>
    <?php } ?>


    <div class="clearfix"></div>
    <footer>

        <?php if ( class_exists('ReduxFrameworkPlugin')) { ?>
        <!-- FOOTER TOP -->
        <div class="row footer-top">
            <div class="container">
            <?php
                // Check if the Redux Framework is active
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    //FOOTER ROW #1
                    echo clinika_footer_row1();
                }
             ?>
            </div>
        </div>
        <?php } ?>
        
        <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
            <?php if(clinika_redux('modeltheme-enable-copyright')==true){ ?>
                <div class="footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <p class="copyright"><?php echo wp_kses(clinika_redux('clinika_footer_text_left'), 'link'); ?></p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p class="copyright"><?php echo wp_kses(clinika_redux('clinika_footer_text_right'), 'link'); ?></p>            
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <div class="footer footer-fallback">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="copyright"><?php echo esc_html__('© Clinika Theme. | All right Reserved.', 'clinika'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>