<?php
add_action( 'wp_enqueue_scripts', 'fs_theme_enqueue_stuff' );
function fs_theme_enqueue_stuff() {
	$parent_style = 'divi-style'; // This is the style of the default Divi parent stylesheet
	$parent_version = wp_get_theme()->parent()->get( 'Version' );
	$child_version = wp_get_theme()->get( 'Version' );
	// we check file date of child stylesheet and script, so we can append to version number (for cache busting)
	$style_cache_buster = date("YmdHi", filemtime( get_stylesheet_directory() . '/style.css'));
	$script_cache_buster = date("YmdHi", filemtime( get_stylesheet_directory() . '/script.js'));
	// dequeue the parent stylesheet, otherwise you will have duplicate child stylesheet, since the parent theme also pulls in the child stylesheet automatically
	wp_dequeue_style( $parent_style );
	// now re-add parent style and add parent version
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array(), $parent_version );
	// get child style which is dependent on parent style, and get child version
	wp_enqueue_style( 'fs-child-style', get_stylesheet_uri(), array( $parent_style ), $child_version .'-'. $style_cache_buster );
	// will grab the script file from the child theme directory, and is reliant on jquery and the divi-custom-script (so it comes after that one)
	wp_enqueue_script( 'fs-child-script', get_stylesheet_directory_uri() . '/script.js', array( 'jquery', 'divi-custom-script' ), $child_version .'-'. $script_cache_buster, true );
}