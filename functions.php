<?php
/**
 * Set up the DIVI Child Theme functions
 *
 * @author Freshy <freshysites.com>
 * @package FS_Divi_Child
 * @since 1.0.0
 */

const FS_DOMAINS_WHITELIST = [
	'freshysites.com',
	'freshy.press',
];

add_action( 'after_setup_theme', 'fs_divi_child_setup' );

function fs_divi_child_setup() {
	// Load our fs-divi-setup!
	require_once get_stylesheet_directory() . '/app/fs-divi-setup.php';

	// Instantiate our class and load our default hooks.
	new FS_Divi_Setup();
}

/**
 * ==============================================
 * Below load in any additional functions that you want to add to the child theme.
 * ==============================================
 */