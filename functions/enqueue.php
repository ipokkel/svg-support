<?php
/**
 * Enqueue scripts and styles
 * This file is to enqueue the scripts and styles both admin and front end
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue the admin CSS using screen check functions
 */
function bodhi_svgs_admin_css() {

	// check if user is on SVG Support settings page or media library page
	if ( bodhi_svgs_specific_pages_settings() || bodhi_svgs_specific_pages_media_library() ) {

		// enqueue the admin CSS
		wp_enqueue_style( 'bodhi-svgs-admin', BODHI_SVGS_PLUGIN_URL . 'css/svgs-admin.css' );

	}

	// check if user is on SVG Support settings page and not in "Advanced Mode"
	if ( bodhi_svgs_specific_pages_settings() && ! bodhi_svgs_advanced_mode() ) {

		// enqueue the simple mode admin CSS
		wp_enqueue_style( 'bodhi-svgs-admin-simple-mode', BODHI_SVGS_PLUGIN_URL . 'css/svgs-admin-simple-mode.css' );

	}

	// check if user is on an edit post page
	if ( bodhi_svgs_is_edit_page() ) {

		// enqueue the edit post CSS
		wp_enqueue_style( 'bodhi-svgs-admin-edit-post', BODHI_SVGS_PLUGIN_URL . 'css/svgs-admin-edit-post.css' );

	}

}
add_action( 'admin_enqueue_scripts', 'bodhi_svgs_admin_css' );

/**
 * Enqueue front end CSS for attachment pages
 */
function bodhi_svgs_frontend_css() {

	// check if user is on attachment page
	if ( is_attachment() ) {
		wp_enqueue_style( 'bodhi-svgs-attachment', BODHI_SVGS_PLUGIN_URL . 'css/svgs-attachment.css' );
	}

}
add_action( 'wp_enqueue_scripts', 'bodhi_svgs_frontend_css' );

/**
 * Enqueue and localize JS for IMG tag replacement
 */
function bodhi_svgs_inline() {

	if ( bodhi_svgs_advanced_mode() ) {

		// get the settings
		global $bodhi_svgs_options;

		// MODIFIED // Theuns Coetzee (ipokkel) 2017-08-10

		if (! empty($bodhi_svgs_options['power_override'])){
			// MODIFIED // Theuns Coetzee (ipokkel) 2017-08-12 
			// added variable to pass to js
			$power_override_active = 'true';
			// MODIFIED // Theuns Coetzee (ipokkel) 2017-08-10
			// set the custom class for use in JS
			if (! empty($bodhi_svgs_options['css_target'])){
				$css_target_array = array(
				'Bodhi' => 'img.'. $bodhi_svgs_options['css_target'],
				'PowerOverride' => $bodhi_svgs_options['css_target']
			);
			} else {
				$css_target_array = array(
				'Bodhi' => 'img.style-svg',
				'PowerOverride' => 'style-svg'
			);
			}
		} else {
			$bodhi_svgsjs_file = '';
			$css_target = 'img.'. $bodhi_svgs_options['css_target'];
			$css_target_array = $css_target;
			$power_override_active = 'false';
		}

		if (! empty($bodhi_svgs_options['use_expanded_js'])) {
			$bodhi_svgsjs_folder = ''; // blank
		} else {
			$bodhi_svgsjs_folder = 'min/'; // min folder 
			$bodhi_svgsjs_file = '-min'; //Removed comment so only one js file gets used 2017-08-12
		}
		
		// Set location on page for js
		if ( ! empty( $bodhi_svgs_options['js_foot_choice'] ) ) {
			$bodhi_svgsjs_footer = true;
		} else {
			$bodhi_svgsjs_footer = false;
		}

		// MODIFIED // Theuns Coetzee (ipokkel) 2017-08-10		
		$bodhi_svgsjs_path = 'js/' . $bodhi_svgsjs_folder .'svgs-inline' . $bodhi_svgsjs_file . '.js' ; // create path for the correct js file
		wp_register_script( 'bodhi_svg_inline', BODHI_SVGS_PLUGIN_URL . $bodhi_svgsjs_path, array( 'jquery' ), '1.0.0', $bodhi_svgsjs_footer );

		wp_enqueue_script( 'bodhi_svg_inline' );
		// MODIFIED // Theuns Coetzee (ipokkel) 2017-08-02
		wp_localize_script( 'bodhi_svg_inline', 'cssTarget', $css_target_array ); // Changed string passed to an array
		// MODIFIED // Theuns Coetzee (ipokkel) 2017-08-12
		wp_localize_script( 'bodhi_svg_inline', 'PowerOverrideActive', $power_override_active );

	}

}
add_action( 'wp_enqueue_scripts', 'bodhi_svgs_inline' );