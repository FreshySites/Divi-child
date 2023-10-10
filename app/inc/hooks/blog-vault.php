<?php

namespace FS\App\Hooks;

// Hide Blogvault from non @freshysites.com users
function fs_check_blogvault_is_active() {
	// Check if Blogvault plugin is active
	if ( is_plugin_active( 'blogvault-real-time-backup/blogvault.php' ) ) {
		// hide it from the Plugins list table
		add_filter( 'all_plugins', 'fs_remove_blogvault_admin_plugin_list' );
		function fs_remove_blogvault_admin_plugin_list( $plugins ) {
			// get current User
			$user = wp_get_current_user();
			// get their email address
			$email = $user->user_email;
			// check the email's domain
			$domain = FS_DOMAINS_WHITELIST;
			// check if email address matches domain list
			$banned = strpos( $email, $domain[0] ) === false || strpos( $email, $domain[1] ) === false;
			// if current user's email addess doesn't match domain list, then hide the plugin in the list
			if ( $user && $banned ) {
				unset( $plugins['blogvault-real-time-backup/blogvault.php'] );
			}

			return $plugins;
		}

		// hide it from the Admin sidebar menu
		add_action( 'admin_menu', 'fs_remove_blogvault_admin_menu_links', 999 );
		function fs_remove_blogvault_admin_menu_links() {
			// get current User
			$user = wp_get_current_user();
			// get their email address
			$email = $user->user_email;
			// check the email's domain
			$domain = FS_DOMAINS_WHITELIST;
			// check if email address matches domain list
			$banned = strpos( $email, $domain[0] ) === false || strpos( $email, $domain[1] ) === false;
			// if current user's email address doesn't match domain list, then hide the menu items
			if ( $user && $banned ) {
				remove_menu_page( 'bvbackup' );
			}
		}
	}
}

add_action( 'admin_init', 'fs_check_blogvault_is_active' );

