/**
 * 17. modalEffects.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
var ModalEffects = (function() {

    'use strict';

    function init() {

        var overlay = document.querySelector( '.modeltheme-overlay' );

        [].slice.call( document.querySelectorAll( '.modeltheme-trigger' ) ).forEach( function( el, i ) {

            var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                close = modal.querySelector( '.modeltheme-close' );

            function removeModal( hasPerspective ) {
                classie.remove( modal, 'modeltheme-show' );

                if( hasPerspective ) {
                    classie.remove( document.documentElement, 'modeltheme-perspective' );
                }
            }

            function removeModalHandler() {
                removeModal( classie.has( el, 'modeltheme-setperspective' ) ); 
            }

            el.addEventListener( 'click', function( ev ) {
                classie.add( modal, 'modeltheme-show' );
                overlay.removeEventListener( 'click', removeModalHandler );
                overlay.addEventListener( 'click', removeModalHandler );

                if( classie.has( el, 'modeltheme-setperspective' ) ) {
                    setTimeout( function() {
                        classie.add( document.documentElement, 'modeltheme-perspective' );
                    }, 25 );
                }
            });

            close.addEventListener( 'click', function( ev ) {
                ev.stopPropagation();
                removeModalHandler();
            });

        } );

    }

    init();

})();