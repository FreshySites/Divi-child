<?php

class FS_Divi_Setup {

	/**
	 *
	 * Maybe follow Understrap's directory structure and move /inc/ up out of /app/
	 * Consider simplifying and including everything in /inc/ and using file prefixes to organize the hooks, eg: /inc/hooks-pressable.php - and then it makes sense for things that aren't exactly hooks to live in that folder
	 * Maybe add a custom.php in /inc/ for custom functions instead of appending to functions.php
	 * Use /assets/css/ and /assets/js/ to organize JS and CSS
	 * Consider a SCSS style sheet that uses variables, and minifies on build process
	 * Make sure all functions are snake_case not camelCase
	 * Use PHPCS to validate against WordPress coding standards
	 */

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueueAdminScripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueFrontendScripts' ) );

		$this->registerHooks();
	}

	/**
	 * Loop through all files in the hooks directory and require them.
	 * This allows us to keep the hooks organized in separate files.
	 *
	 * @return void
	 */
	public function registerHooks() {
		$path = get_stylesheet_directory_uri() . '/inc/*.php';
		foreach ( glob( $path ) as $file ) {
			require_once $file;
		}
	}

	public function enqueueAdminScripts() {
		// Get the current child theme data
		$current_theme = wp_get_theme();
		// get the version number of the current child theme
		$child_version = $current_theme->get( 'Version' );
		// we check file date of WP backend stylesheet, so we can append to version number string (for cache busting)
		$style_cache_buster = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/wp-admin.css' ) );
		// Begin enqueue for CSS file that loads in WP backend
		wp_enqueue_style( 'fs-child-style-admin', get_stylesheet_directory_uri() . '/wp-admin.css', array(), $child_version . '-' . $style_cache_buster );
	}

	public function enqueueFrontendScripts() {
		// Divi assigns its style.css with this handle
		$parent_handle = 'divi-style';
		// Get the current child theme data
		$current_theme = wp_get_theme();
		// get the parent version number of the current child theme
		$parent_version = $current_theme->parent()->get( 'Version' );
		// get the version number of the current child theme
		$child_version = $current_theme->get( 'Version' );
		// we check file date of child stylesheet and script, so we can append to version number string (for cache busting)
		$style_cache_buster  = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/assets/css/style.css' ) );
		$script_cache_buster = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/assets/js/script.js' ) );
		// first we pull in the parent theme styles that it needs
		wp_enqueue_style( $parent_handle, get_template_directory_uri() . '/style.css', array(), $parent_version );
		// then we get the child theme style.css file, which is dependent on the parent theme style, then append string of child version and file date
		wp_enqueue_style( 'fs-child-style', get_stylesheet_uri() . '/assets/css/style.css', array( $parent_handle ), $child_version . '-' . $style_cache_buster );
		// will grab the script file from the child theme directory, and is reliant on jquery and the divi-custom-script (so it comes after that one)
		wp_enqueue_script(
			'fs-child-script',
			get_stylesheet_directory_uri() . '/assets/js/script.js',
			array( 'jquery', 'divi-custom-script' ),
			$child_version . '-' . $script_cache_buster,
			true
		);
	}
}
