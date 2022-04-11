/*
 Project author:     ModelTheme
 File name:          Custom JS
*/

(function ($) {
    'use strict';

    jQuery(window).load(function(){
        jQuery( '.linify_preloader_holder' ).fadeOut( 1000, function() {
            jQuery( this ).fadeOut();
        });
    });

    // Set Inline CSS for buttons
    jQuery('.mt_modeltheme_button').each(function(){
        var btn_identificator = jQuery(this).attr('data-identificator'),
            btn_backgroundColorHover = jQuery(this).attr('data-background-color-hover'),
            btn_backgroundColor = jQuery(this).attr('data-background-color');

        jQuery('.'+btn_identificator+' a.rippler.rippler-default').css("background-color", btn_backgroundColor);
        jQuery('.'+btn_identificator+' a.rippler.rippler-default').hover(function(){
            jQuery(this).css("background-color", btn_backgroundColorHover);
        }, function(){
            jQuery(this).css("background-color", btn_backgroundColor);
        });
    });

  
    /*LOGIN MODAL */
    var ModalEffects = (function() {
            function init_modal() {

                var overlay = document.querySelector( '.modeltheme-overlay' );
                var overlay_inner = document.querySelector( '.modeltheme-overlay-inner' );
                var modal_holder = document.querySelector( '.modeltheme-modal-holder' );
                var html = document.querySelector( 'html' );

                [].slice.call( document.querySelectorAll( '.modeltheme-trigger' ) ).forEach( function( el, i ) {

                    var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                        close = modal.querySelector( '.modeltheme-close' );

                    function removeModal( hasPerspective ) {
                        classie.remove( modal, 'modeltheme-show' );
                        classie.remove( modal_holder, 'modeltheme-show' );
                        classie.remove( html, 'modal-open' );

                        if( hasPerspective ) {
                            classie.remove( document.documentElement, 'modeltheme-perspective' );
                        }
                    }

                    function removeModalHandler() {
                        removeModal( classie.has( el, 'modeltheme-setperspective' ) ); 
                    }

                    el.addEventListener( 'click', function( ev ) {
                        classie.add( modal, 'modeltheme-show' );
                        classie.add( modal_holder, 'modeltheme-show' );
                        classie.add( html, 'modal-open' );
                        overlay.removeEventListener( 'click', removeModalHandler );
                        overlay.addEventListener( 'click', removeModalHandler );

                        overlay_inner.removeEventListener( 'click', removeModalHandler );
                        overlay_inner.addEventListener( 'click', removeModalHandler );

                        if( classie.has( el, 'modeltheme-setperspective' ) ) {
                            setTimeout( function() {
                                classie.add( document.documentElement, 'modeltheme-perspective' );
                            }, 25 );
                        }
                    });

                } );

            }

        if (!jQuery("body").hasClass("login-register-page")) {
            init_modal();
        }

    })();
    
    jQuery('.widget_categories li .children').each(function(){
        jQuery(this).parent().addClass('cat_item_has_children');
    });
    jQuery('.widget_nav_menu li a').each(function(){
        if (jQuery(this).text() == '') {
            jQuery(this).parent().addClass('link_missing_text');
        }
    });


    jQuery(document).on('touchstart click', 'li.vc_tta-tab a,li.vc_tta-tab,.vc_tta-panel-title', function(){
        jQuery('html, body').stop();
    });

    jQuery( ".compare.button" ).on( "click", function() {
        setTimeout( function(){ 
            jQuery(".compare.button.added").empty();
        },3000 );
    });

    jQuery(function () {
        jQuery('.share-button').share({
            flyout: 'top center'
        });
    });

    // 9th MENU Toggle - Hamburger
    var toggles = document.querySelectorAll(".c-hamburger");

    for (var i = toggles.length - 1; i >= 0; i--) {
      var toggle = toggles[i];
      toggleHandler(toggle);
    };

    function toggleHandler(toggle) {
      toggle.addEventListener( "click", function(e) {
        e.preventDefault();
        (this.classList.contains("is-btn-active") === true) ? this.classList.remove("is-btn-active") : this.classList.add("is-btn-active");
      });
    }

    
    jQuery(document).ready(function() {

        jQuery(".search_products").on({
            mouseenter: function () {
                //stuff to do on mouse enter
                jQuery('.header_search_form').addClass('visibile_contact');
            },
            mouseleave: function () {
                //stuff to do on mouse leave
                jQuery('.header_search_form').removeClass('visibile_contact');
            }
        });

    }); 

    // make woocommerce +/- quantity buttons functional
    if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function() {
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });

    $(document).ready(function() {

        jQuery(".shop_cart").on({
            mouseenter: function () {
                //stuff to do on mouse enter
                jQuery('.header_mini_cart').addClass('visible_cart');
            },
            mouseleave: function () {
                //stuff to do on mouse leave
                jQuery('.header_mini_cart').removeClass('visible_cart');
            }
        });

        jQuery(".header_mini_cart").on({
            mouseenter: function () {
                //stuff to do on mouse enter
                jQuery(this).addClass('visible_cart');
            },
            mouseleave: function () {
                //stuff to do on mouse leave
                jQuery(this).removeClass('visible_cart');
            }
        });
        
        //Begin: Validate and Submit contact form via Ajax
        jQuery("#contact_form").validate({
            //Ajax validation rules
            rules: {
                user_name: {
                    required: true,
                    minlength: 2
                },
                user_message: {
                    required: true,
                    minlength: 10
                },
                user_subject: {
                    required: true,
                    minlength: 5
                },
                user_email: {
                    required: true,
                    email: true
                }
            },
            //Ajax validation messages
            messages: {
                user_name: {
                    required: "Please enter a name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                user_message: {
                    required: "Please enter a message",
                    minlength: "Your message must consist of at least 10 characters"
                },
                user_subject: {
                    required: "Please provide a subject",
                    minlength: "Your subject must be at least 5 characters long"
                },
                user_email: "Please enter a valid email address"
            },
            //Submit via Ajax Form
            submitHandler: function() {
                jQuery('#contact_form').ajaxSubmit();
                jQuery('.success_message').fadeIn('slow');
            }
        });
        //End: Validate and Submit contact form via Ajax



        //Begin: Validate and Submit contact form 2 via Ajax
        jQuery("#contact_form2").validate({
            //Ajax validation rules
            rules: {
                user_name: {
                    required: true,
                    minlength: 2
                },
                user_message: {
                    required: true,
                    minlength: 10
                },
                user_subject: {
                    required: true,
                    minlength: 5
                },
                user_email: {
                    required: true,
                    email: true
                },
                user_phone: {
                    required: true,
                    minlength: 6,
                    number: true
                },
                user_city: {
                    required: true
                }
            },
            //Ajax validation messages
            messages: {
                user_name: {
                    required: "Please enter a name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                user_message: {
                    required: "Please enter a message",
                    minlength: "Your message must consist of at least 10 characters"
                },
                user_subject: {
                    required: "Please provide a subject",
                    minlength: "Your subject must be at least 5 characters long"
                },
                user_phone: {
                    required: "Please provide a phone number",
                    minlength: "Your phone must be at least 6 numbers long",
                    number: "You must enter a number"
                },
                user_city: {
                    required: "Please provide a city"
                },
                user_email: {
                    required: "Please provide a email",
                    email: "Please enter a valid email address"
                }
            }
        });
        //End: Validate and Submit contact form via Ajax


        if ( jQuery( "#commentform p:empty" ).length ) {
            jQuery('#commentform p:empty').remove();
        }

        if ( jQuery( ".woocommerce_categories" ).length ) {
            jQuery( ".category a" ).on( "click", function() {
                var attr = jQuery(this).attr("class");
                jQuery(".products_by_category").removeClass("active");
                jQuery(attr).addClass("active");
                jQuery('.category').removeClass("active");
                jQuery(this).parent('.category').addClass("active");
            });  
            jQuery('.products_category .products_by_category:first').addClass("active");
            jQuery('.categories_shortcode .category:first').addClass("active");
        }
        //Begin: Search Form
        if ( jQuery( "#modeltheme-search" ).length ) {
            new UISearch( document.getElementById( 'modeltheme-search' ) );
        }
        //End: Search Form



        /*Begin: Testimonials slider*/
        jQuery(".quotes-slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : true,
            rewindNav       : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });

        jQuery(".quotes-container").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        jQuery(".testimonials-container").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  2],
                [1200,  2],
                [1400,  2],
                [1600,  2]
            ]
        });
        jQuery(".testimonials-container-1").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   1],
                [700,   1],
                [1000,  1],
                [1200,  1],
                [1400,  1],
                [1600,  1]
            ]
        });
        jQuery(".testimonials-container-2").owlCarousel({
            
            pagination      : true,
            navigation:false,
            dots         : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   1],
                [700,   1],
                [1000,  2],
                [1200,  2],
                [1400,  2],
                [1600,  2]
            ]
        });
        jQuery(".testimonials-container-3").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  3],
                [1200,  3],
                [1400,  3],
                [1600,  3]
            ]
        });
        /*End: Testimonials slider*/
        jQuery(".testimonials-container-3").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  3],
                [1200,  3],
                [1400,  3],
                [1600,  3]
            ]
        });
        /*Begin: Pastors slider*/
        jQuery(".pastor_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  4],
                [1200,  4],
                [1400,  4],
                [1600,  4]
            ]
        });
        /*End: Pastors slider*/
        /*Begin: Clients slider*/
        jQuery(".categories_shortcode").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            navigationText  : ["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
            itemsCustom : [
                [0,     1],
                [450,   2],
                [600,   2],
                [700,   5],
                [1000,  5],
                [1200,  5],
                [1400,  5],
                [1600,  5]
            ]
        });
        /*Begin: Products by category*/
        jQuery(".clients-container").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   2],
                [600,   2],
                [700,   3],
                [1000,  5],
                [1200,  5],
                [1400,  5],
                [1600,  5]
            ]
        });
        /*Begin: Portfolio single slider*/
        jQuery(".portfolio_thumbnails_slider").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            navigationText  : ["",""],
            singleItem      : true
        });
        /*End: Portfolio single slider*/
        /*Begin: Testimonials slider*/
        jQuery(".post_thumbnails_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        var owl = jQuery(".post_thumbnails_slider");
        jQuery( ".next" ).on( "click", function() {
            owl.trigger('owl.next');
        })
        jQuery( ".prev" ).on( "click", function() {
            owl.trigger('owl.prev');
        })
        /*End: Testimonials slider*/
        
        /*Begin: Testimonials slider*/
        jQuery(".testimonials_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        /*End: Testimonials slider*/
        /* Animate */
        jQuery('.animateIn').animateIn();
        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
            //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
            offset_opacity = 1200,
            //duration of the top scrolling animation (in ms)
            scroll_top_duration = 700,
            //grab the "back to top" link
            $back_to_top = jQuery('.back-to-top');
        //hide or show the "back to top" link
        jQuery(window).scroll(function(){
            ( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('modeltheme-is-visible') : $back_to_top.removeClass('modeltheme-is-visible modeltheme-fade-out');
            if( jQuery(this).scrollTop() > offset_opacity ) { 
                $back_to_top.addClass('modeltheme-fade-out');
            }
        });
        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });
        //Begin: Skills
        jQuery('.statistics').appear(function() {
            jQuery('.percentage').each(function(){
                var dataperc = jQuery(this).attr('data-perc');
                jQuery(this).find('.skill-count').delay(6000).countTo({
                    from: 0,
                    to: dataperc,
                    speed: 5000,
                    refreshInterval: 100
                });
            });
        }); 
        //End: Skills 
        /* Youtube Video */
        if (jQuery('.player').length){
            jQuery(".player").mb_YTPlayer({});
            jQuery('.player').on("YTPStart",function(){
               jQuery('.video-bg').animate({opacity: 1}, 5000,function(){});
            });
        }



        jQuery(".testimonials-container-1").owlCarousel({
            navigation      : true, // Show next and prev buttons
            navigationText: [
            "<i class='fa fa-angle-left' aria-hidden='true'></i>",
            "<i class='fa fa-angle-right' aria-hidden='true'></i>"
            ],
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   1],
                [700,   1],
                [1000,  1],
                [1200,  1],
                [1400,  1],
                [1600,  1]
            ]
        });

        jQuery('#learn-press-course-curriculum h4.section-header').on('click',function() {
            jQuery(this).parent().removeClass('active');
            if(jQuery(this).find('.collapse').hasClass('plus')) {
                jQuery(this).parent().addClass('active');
            }
        });

        


    })
} (jQuery) );


// Navigation Submenus dropdown direction (right or left)
(function ($) {
    
    $(document).ready(function () {
        MTDefaultNavMenu.init();
    });
    
    $(window).resize(function(){
        MTDefaultNavMenu.init();
    });
    
    var MTDefaultNavMenu = {
        init: function () {
            var $menuItems = $('#navbar ul.menu > li.menu-item-has-children');
            
            if ($menuItems.length) {
                $menuItems.each(function (i) {
                    var thisItem = $(this),
                        menuItemPosition = thisItem.offset().left,
                        dropdownMenuItem = thisItem.find(' > ul'),
                        dropdownMenuWidth = dropdownMenuItem.outerWidth(),
                        menuItemFromLeft = $(window).width() - menuItemPosition;

                    var dropDownMenuFromLeft;
                    
                    if (thisItem.find('li.menu-item-has-children').length > 0) {
                        dropDownMenuFromLeft = menuItemFromLeft - dropdownMenuWidth;
                    }
                    
                    dropdownMenuItem.removeClass('mt-drop-down--right');
                    
                    if (menuItemFromLeft < dropdownMenuWidth || dropDownMenuFromLeft < dropdownMenuWidth) {
                        dropdownMenuItem.addClass('mt-drop-down--right');
                    }
                });
            }
        }
    };
    
})(jQuery);


//Begin: Sticky Header
(function ($) {
    
    $(document).ready(function () {
        MTStickyHeader.init();
    });
    
    var MTStickyHeader = {
        init: function () {
            var $headerHolder = $("#modeltheme-main-head");
            
            if ($headerHolder.length) {
                $(function(){
                    if ($('body').hasClass('is_nav_sticky')) {
                        $($headerHolder).sticky({
                            topSpacing:0
                        });
                    }
                });
            }
        }
    };
    
})(jQuery);


//Begin: Mobile Navigation
(function ($) {
    
    $(document).ready(function () {
        MTMobileNavigationExpand.init();
    });
    
    $(window).resize(function(){
        MTMobileNavigationExpand.init();
    });
    
    var MTMobileNavigationExpand = {
        init: function () {
            var $nav_submenu = $(".navbar-collapse .menu-item-has-children");
            
            if ($nav_submenu.length) {
                $(function(){
                   if (jQuery(window).width() < 768) {
                        var expand = '<span class="expand"><a class="action-expand"></a></span>';
                        jQuery('.navbar-collapse .menu-item-has-children, .navbar-collapse .mega_menu').each(function(){
                            if (!jQuery(this).find('.action-expand').length) {
                                jQuery('.navbar-collapse .menu-item-has-children, .navbar-collapse .mega_menu').append(expand);
                            }
                        });
                        jQuery('.first_header #navbar .sub-menu').hide();
                        jQuery('.third_header #navbar .sub-menu').hide();
                        jQuery(".menu-item-has-children .expand a").on("click",function() {
                            jQuery(this).parent().parent().find(' > ul').toggle();
                            jQuery(this).toggleClass("show-menu");
                        });
                        jQuery(".mega_menu .expand a").on("click",function() {
                            jQuery(this).parent().parent().find(' > .cf-mega-menu').toggle();
                            jQuery(this).toggleClass("show-menu");
                        });
                    }
                });
            }
        }
    };
    
})(jQuery);

(function ($) {
//accordeon footer
    $(document).ready(function(){
        if($(window).width() <= 991) {
            jQuery(".footer-row-1 .col-md-2").each(function(){
                var heading = jQuery(this).find('.widget-title');
                jQuery(heading).click(function(){
                    jQuery(heading).toggleClass("active");
                    var siblings = jQuery(this).nextAll();
                    jQuery(siblings).slideToggle();
                })
            });
            jQuery(".footer-row-1 .col-md-6").each(function(){
                var heading = jQuery(this).find('.widget-title').not('.follow_us');
                jQuery(heading).click(function(){
                    jQuery(heading).toggleClass("active");
                    var siblings = jQuery(this).nextAll();
                    jQuery(siblings).slideToggle();
                })
            });
        }
    })
})(jQuery);

