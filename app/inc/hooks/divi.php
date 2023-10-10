<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Creates shortcode to allow placing Divi Library module inside another module's text area. Creates a shortcode to show the Library module.
 *
 * @see https://www.creaweb2b.com/en/how-to-add-a-divi-section-or-module-inside-another-module/
 * Usage: [showmodule id="123"]
 */
add_shortcode( 'showmodule', function ( $module_id ) {
	extract( shortcode_atts( [ 'id' => '*' ], $module_id ) );

	return do_shortcode( '[et_pb_section global_module="' . $id . '"][/et_pb_section]' );
} );

// Adds new admin column to show the shortcode ID in the Divi Library page table
function fs_create_shortcode_column( $columns ) {
	$columns['fs_shortcode_id'] = 'Library Item Shortcode';

	return $columns;
}

// Display shortcode column info on Divi Library page table
function fs_shortcode_column_content( $column, $id ) {
	if ( 'fs_shortcode_id' == $column ) {
		echo '<p>[showmodule id="' . $id . '"]</p>';
	}
}

// create new shortcode column in et_pb_layout screen
add_filter( 'manage_et_pb_layout_posts_columns', 'fs_create_shortcode_column', 5 );
// add the shortcode content to the new column
add_action( 'manage_et_pb_layout_posts_custom_column', 'fs_shortcode_column_content', 5, 2 );