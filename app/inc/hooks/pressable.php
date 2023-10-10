<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Remove certain widgets from the backend WP Dashboard page
function fs_remove_dashboard_widget() {
	// Pressable widget
	remove_meta_box( 'pressable_dashboard_widget', 'dashboard', 'normal' );
}

add_action( 'wp_dashboard_setup', 'fs_remove_dashboard_widget' );

