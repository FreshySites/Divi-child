<?php
/* Enqueue necessary CSS and JS files for Child Theme */

function fs_theme_enqueue_stuff() {
	// Divi assigns its style.css with this handle
	$parent_handle = 'divi-style'; 
	// Get the current child theme data
	$current_theme = wp_get_theme(); 
	// get the parent version number of the current child theme
	$parent_version = $current_theme->parent()->get('Version'); 
	// get the version number of the current child theme
	$child_version = $current_theme->get('Version'); 
	// we check file date of child stylesheet and script, so we can append to version number string (for cache busting)
	$style_cache_buster = date("YmdHis", filemtime( get_stylesheet_directory() . '/style.css'));
	$script_cache_buster = date("YmdHis", filemtime( get_stylesheet_directory() . '/script.js'));
	// first we pull in the parent theme styles that it needs
	wp_enqueue_style( $parent_handle, get_template_directory_uri() . '/style.css', array(), $parent_version );
	// then we get the child theme style.css file, which is dependent on the parent theme style, then append string of child version and file date
	wp_enqueue_style( 'fs-child-style', get_stylesheet_uri(), array( $parent_handle ), $child_version .'-'. $style_cache_buster );
	// will grab the script file from the child theme directory, and is reliant on jquery and the divi-custom-script (so it comes after that one)
	wp_enqueue_script( 'fs-child-script', get_stylesheet_directory_uri() . '/script.js', array('jquery', 'divi-custom-script'), $child_version .'-'. $script_cache_buster, true);
}
add_action( 'wp_enqueue_scripts', 'fs_theme_enqueue_stuff' );

/* Divi */

// Creates shortcode to allow placing Divi Library module inside of another module's text area. Creates a shortcode to show the Library module.
// https://www.creaweb2b.com/en/how-to-add-a-divi-section-or-module-inside-another-module/
// example usage: [showmodule id="123"]
function showmodule_shortcode($moduleid) {
	extract(shortcode_atts(array('id' =>'*'),$moduleid));   
	return do_shortcode('[et_pb_section global_module="'.$id.'"][/et_pb_section]');
}
add_shortcode('showmodule', 'showmodule_shortcode');

// Adds new admin column to show the shortcode ID in the Divi Library page table
function fs_create_shortcode_column( $columns ) {
	$columns['fs_shortcode_id'] = 'Library Item Shortcode';
	return $columns;
}
// Display shortcode column info on Divi Library page table
function fs_shortcode_column_content( $column, $id ) {
	if( 'fs_shortcode_id' == $column ) {
		echo '<p>[showmodule id="' . $id . '"]</p>';
	}
}
// create new shortcode column in et_pb_layout screen
add_filter( 'manage_et_pb_layout_posts_columns', 'fs_create_shortcode_column', 5 );
// add the shortcode content to the new column
add_action( 'manage_et_pb_layout_posts_custom_column', 'fs_shortcode_column_content', 5, 2 );

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

/* Plugin Notes Plus */

// Remove the Plugin Notes Plus data for all users other than the ones we approve below
// based on their user email domain, or their user ID
// using their own filter, we hide its output
add_filter( 'plugin-notes-plus_hide_notes', 'fs_remove_plugin_notes_data_for_most_users' );
function fs_remove_plugin_notes_data_for_most_users( $hide_notes ) {
	
	// get current user data
	$current_user = wp_get_current_user(); 

	// get their email address
	$email = $current_user->user_email;

	// ** SET ALLOWED EMAIL DOMAIN HERE **
	// domain to check in the email address
	$domain = 'freshysites.com';

	// check if user's email address matches the one we check against 
	// we check to see if it returns false, and if so, they are deemed a user with $banned_user_email
	// because otherwise, it would return the position of the first occurrence of the $domain string within the $email string... but if it returns FALSE, then the string was not found
	$banned_user_email = strpos($email, $domain) === false;
	
	// ** SET LIST OF ALLOWED USER IDs HERE **
	// list of allowed user IDs (add more within the array, as a comma separated list) e.g., array(3, 345, 995, 6);
	$allowed_user_ids = array();
	
	// if the current user ID is not withinout list of $allowed_user_ids, then they are deemed a user with $banned_user_id
	$banned_user_id = !in_array($current_user->ID, $allowed_user_ids);
	
	// if the current user is both a banned email and a banned user ID, then hide the plugin data output
	// otherwise, if not BOTH of these, they are at least either an allowed email or an allowed user ID, so we want to let them through
	// that's why we need to check if BOTH banned options are true, so that if only one is true, and the other is false, it will still show for that user
	if ( $banned_user_email && $banned_user_id) {

		// then hide the Plugin Notes Plus output
		$hide_notes = true;
		
	}    
	
	// return the notes (unless we are hiding them, based on above logic)
	return $hide_notes;
	
}
