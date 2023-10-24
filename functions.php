<?php
/**
 * Set up the DIVI Child Theme functions
 *
 * @author Freshy <freshysites.com>
 * @package FS_Divi_Child
 * @since 1.0.0
 */

/**
 * FreshySites domains whitelist
 */
const FS_DOMAINS_WHITELIST = array(
	'freshysites.com',
	'freshy.press',
);

add_action( 'after_setup_theme', 'fs_divi_child_setup' );

/**
 * Set up the DIVI Child Theme functions
 * This is where we load our class-fs-divi-setup.php file
 * @return void
 */
function fs_divi_child_setup() {
	require_once get_stylesheet_directory() . '/class-fs-divi-setup.php';
	new FS_Divi_Setup();
}