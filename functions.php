<?php
/* Enqueue necessary CSS and JS files for Child Theme */

add_action( 'wp_enqueue_scripts', 'fs_theme_enqueue_stuff', 999999999999 ); // set to higher priority than Divi's add_action of et_divi_replace_parent_stylesheet
function fs_theme_enqueue_stuff() {
	$parent_style = 'divi-style'; // Divi tries to enqueue our child theme style.css for us, and assigns it this handle name
	$child_version = wp_get_theme()->get('Version'); // get our child theme version
	// we check file date of child stylesheet and script, so we can append to version number string (for cache busting)
	$style_cache_buster = date("YmdHis", filemtime( get_stylesheet_directory() . '/style.css'));
	$script_cache_buster = date("YmdHis", filemtime( get_stylesheet_directory() . '/script.js'));
	// dequeue the child stylesheet that Divi tried to pull in for us, since the parent theme pulls in the child stylesheet automatically, otherwise we will have duplicate child stylesheets
	wp_dequeue_style( $parent_style );
	// get child style which is dependent on parent style, and get child version
	wp_enqueue_style( 'fs-child-style', get_stylesheet_uri(), array(), $child_version .'-'. $style_cache_buster );
	// will grab the script file from the child theme directory, and is reliant on jquery and the divi-custom-script (so it comes after that one)
	wp_enqueue_script( 'fs-child-script', get_stylesheet_directory_uri() . '/script.js', array('jquery', 'divi-custom-script'), $child_version .'-'. $script_cache_buster, true);
}

/* Divi */

// Creates shortcode to allow placing Divi Library module inside of another module's text area. Creates a shortcode to show the Library module.
// https://www.creaweb2b.com/en/how-to-add-a-divi-section-or-module-inside-another-module/
// example usage: [showmodule id="123"]
function showmodule_shortcode($moduleid) {
	extract(shortcode_atts(array('id' =>'*'),$moduleid));   
	return do_shortcode('[et_pb_section global_module="'.$id.'"][/et_pb_section]');
}
add_shortcode('showmodule', 'showmodule_shortcode');

/* Gravity Forms */

// This filter can be used to prevent the page from auto jumping to form confirmation upon form submission
// add_filter( 'gform_confirmation_anchor', '__return_false' );

// use a custom Gravity Forms AJAX spinner
add_filter( 'gform_ajax_spinner_url', 'fs_custom_gforms_spinner', 10, 2 );
function fs_custom_gforms_spinner( $image_src, $form ) {
	$upload_dir = wp_upload_dir();
	$lime_spinner_url = $upload_dir['baseurl'] . '/lime-spinner.png';
	return $lime_spinner_url;
}

/* All in One SEO Pack */

// disable the SEO menu in the admin toolbar
add_filter( 'aioseo_show_in_admin_bar', '__return_false' );

// disable the AIOSEO Details column for users that don't have a freshysites.com email address
if ( function_exists( 'aioseo' ) ) {
	// fires after WordPress has finished loading but before any headers are sent.
	add_action( 'init', function() {
		// get current User
		$user = wp_get_current_user(); 
		// get their email address
		$email = $user->user_email;
		// check the email's domain
		$domain = 'freshysites.com';
		// check if email address matches domain list
		$banned = strpos($email, $domain) === false;
		// if current user's email address doesn't match domain list
		if( $user && $banned ) {
			// remove the AIOSEO Details column for users without a particular email address domain
			remove_action( 'current_screen', [ aioseo()->admin, 'addPostColumns' ], 1 );
		}
	} );
}
