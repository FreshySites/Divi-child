<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove the Plugin Notes Plus data for all users other than the ones we approve below
 * based on their user email domain, or their user ID
 * using their own filter, we hide its output
 */
add_filter( 'plugin-notes-plus_hide_notes', 'fs_remove_plugin_notes_data_for_most_users' );

function fs_remove_plugin_notes_data_for_most_users( $hide_notes ) {
	// get current user data
	$current_user = wp_get_current_user();

	// get their email address
	$email = $current_user->user_email;

	// ** SET ALLOWED EMAIL DOMAIN HERE **
	// domain to check in the email address
	$domains = FS_DOMAINS_WHITELIST;

	// check if user's email address matches the one we check against
	// we check to see if it returns false, and if so, they are deemed a user with $banned_user_email
	// because otherwise, it would return the position of the first occurrence of the $domain string within the $email string... but if it returns FALSE, then the string was not found
	$banned_user_email = strpos( $email, $domains[0] ) === false || strpos( $email, $domains[1] ) === false;

	// ** SET LIST OF ALLOWED USER IDs HERE **
	// list of allowed user IDs (add more within the array, as a comma separated list) e.g., array(3, 345, 995, 6);
	$allowed_user_ids = [];

	// if the current user ID is not withinout list of $allowed_user_ids, then they are deemed a user with $banned_user_id
	$banned_user_id = ! in_array( $current_user->ID, $allowed_user_ids );

	// if the current user is both a banned email and a banned user ID, then hide the plugin data output
	// otherwise, if not BOTH of these, they are at least either an allowed email or an allowed user ID, so we want to let them through
	// that's why we need to check if BOTH banned options are true, so that if only one is true, and the other is false, it will still show for that user
	if ( $banned_user_email && $banned_user_id ) {
		// then hide the Plugin Notes Plus output
		$hide_notes = true;
	}

	// return the notes (unless we are hiding them, based on above logic)
	return $hide_notes;
}