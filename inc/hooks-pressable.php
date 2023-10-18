<?php
/**
 * Hooks used by Pressable
 *
 * @package FS_Divi_Child
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove the Pressable dashboard widget
 *
 * @return void
 */
function fs_remove_dashboard_widget() {
	remove_meta_box( 'pressable_dashboard_widget', 'dashboard', 'normal' );
}

add_action( 'wp_dashboard_setup', 'fs_remove_dashboard_widget' );
