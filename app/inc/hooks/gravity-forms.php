<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/* -- Gravity Forms -- */

// This filter can be used to prevent the page from auto jumping to form confirmation upon form submission
// add_filter( 'gform_confirmation_anchor', '__return_false' );

// use a custom Gravity Forms AJAX spinner
add_filter( 'gform_ajax_spinner_url', 'fs_custom_gforms_spinner', 10, 2 );
function fs_custom_gforms_spinner( $image_src, $form ) {
	$upload_dir = wp_upload_dir();

	return $upload_dir['baseurl'] . '/lime-spinner-rotate.svg';
}
