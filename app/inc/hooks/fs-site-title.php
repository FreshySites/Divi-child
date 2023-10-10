<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Creates shortcode to allow automatically pulling in the Site Title (from General Settings)
// This is used by default in the copyright text within the Code module of the Global Footer in the Divi Theme Builder
function fs_site_title_shortcode() {
	return get_bloginfo( 'name' );
}
add_shortcode( 'fs_site_title','fs_site_title_shortcode' );
