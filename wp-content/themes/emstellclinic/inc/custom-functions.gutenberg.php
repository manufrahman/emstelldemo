<?php
// Add backend styles for Gutenberg.
add_action( 'enqueue_block_editor_assets', 'clinika_add_gutenberg_assets' );
/**
 * Load Gutenberg stylesheet.
 */
function clinika_add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'clinika-gutenberg-style', get_theme_file_uri( '/css/gutenberg-editor-style.css' ), false );
    wp_enqueue_style( 
        'clinika-gutenberg-fonts', 
        '//fonts.googleapis.com/css?family=Jost:regular,300,400,500,bold%7CPoppins:300,regular,500,600,700' 
    ); 
}