<?php

/**
 * Remove the Plugin Notes Plus data for all users other than the ones we approve below
 * based on their user email domain, or their user ID
 * using their own filter, we hide its output
 *
 * @package FS_Divi_Child
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'plugin-notes-plus_hide_notes', 'fs_remove_plugin_notes_data_for_most_users' );

/**
 * Hide the Plugin Notes Plus data for all users other than the ones we approve below
 *
 * @param $hide_notes
 *
 * @return mixed|true
 */
function fs_remove_plugin_notes_data_for_most_users($hide_notes) {
	// Get current user data
	$current_user = wp_get_current_user();

	// Get the user's email address
	$email = $current_user->user_email;

	// Set a list of banned email domains
	$banned_domains = FS_DOMAINS_WHITELIST;

	// Check if the user's email address matches any of the banned domains
	$is_email_banned = false;
	foreach ($banned_domains as $domain) {
		if (strpos($email, $domain) === false) {
			$is_email_banned = true;
			break;
		}
	}

	// Set a list of allowed user IDs
	$allowed_user_ids = array();

	// Check if the current user's ID is within the list of allowed user IDs
	$is_user_id_banned = !in_array($current_user->ID, $allowed_user_ids);

	// If both the email and user ID are banned, hide the plugin data output
	if ($is_email_banned && $is_user_id_banned) {
		$hide_notes = true;
	}

	// Return the notes (unless we are hiding them, based on the above logic)
	return $hide_notes;
}
