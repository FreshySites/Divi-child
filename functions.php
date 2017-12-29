<?php
/* Custom functions code goes here. */

function fs_theme_enqueue_styles() {

	$parent_style = 'parent-style';

	// enqueue the parent theme stylesheet
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' ); 

}
add_action( 'wp_enqueue_scripts', 'fs_theme_enqueue_styles' );

?>