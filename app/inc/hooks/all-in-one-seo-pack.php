<?php

/**
 * Disable the SEO menu item in the admin toolbar
 */
add_filter( 'aioseo_show_in_admin_bar', '__return_false' );

// disable the AIOSEO Details column for users that don't have a certain email address
// https://wordpress.org/support/topic/remove-aioseo-details-via-remove_action/#post-16434394
add_action( 'current_screen', 'fs_remove_aioseo_column', 0 );
function fs_remove_aioseo_column() {
	// get current User
	$user = wp_get_current_user();
	// get their email address
	$email = $user->user_email;
	// check the email's domain
	$domains = FS_DOMAINS_WHITELIST;
	// check if email address matches domain list
	$banned = strpos( $email, $domains[0] ) === false || strpos( $email, $domains[1] ) === false;

	// get all the actions and filters
	global $wp_filter;

	// if it's current screen isn't set, then get out of the function
	if ( empty( $wp_filter['current_screen'][1] ) ) {
		return;
	}

	// go through each current screen details
	foreach ( $wp_filter['current_screen'][1] as $actionName => $params ) {
		if (
			empty( $params['function'][0] ) ||
			! is_object( $params['function'][0] ) ||
			stripos( get_class( $params['function'][0] ), 'aioseo' ) === false
		) {
			continue;
		}
		// if user is banned (without a particular email address domain), then hide the AIOSEO Details screen option (and thus the AIOSEO column)
		if ( $user && $banned ) {
			remove_action( 'current_screen', $params['function'], 1 );
		}
	}
}