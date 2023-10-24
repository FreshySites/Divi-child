<?php

/**
 * Gravity Forms hooks
 *
 * @package FS_Divi_Child
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This filter can be used to prevent the page from auto jumping to form confirmation upon form submission
 */
add_filter( 'gform_confirmation_anchor', '__return_false' );

/**
 * Use a custom Gravity Forms AJAX spinner
 */
add_filter( 'gform_ajax_spinner_url', 'fs_custom_gforms_spinner', 10, 2 );

/**
 * This filter can be used to prevent the page from auto jumping to form confirmation upon form submission
 *
 * @param $image_src
 * @param $form
 *
 * @return string
 */
function fs_custom_gforms_spinner( $image_src, $form ) {
	$upload_dir = wp_upload_dir();

	return $upload_dir['baseurl'] . '/lime-spinner-rotate.svg';
}
