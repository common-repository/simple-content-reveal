<?php
/*
Plugin Name: Content Reveal
Plugin URI: https://wordpress.org/plugins/simple-content-reveal/
Description: Easily hide and reveal WordPress content, whether it's in the sidebar or in a post or page.
Version: 2.3.3
Author: David Artiss
Author URI: https://artiss.blog
Text Domain: simple-content-reveal
*/

/**
* Content Reveal
*
* Main code - include various functions
*
* @package	ContentReveal
*/

define( 'content_reveal_version', '2.3.3' );

/**
* Plugin initialisation
*
* Loads the plugin's JavaScript
*
* @since	2.1
*/

function acr_plugin_init() {

	wp_enqueue_script( 'swap_display', plugin_dir_url( __FILE__ ) . 'js/swap-display.min.js' );

}

add_action( 'init', 'acr_plugin_init' );

/**
* Main Includes
*
* Include all the plugin's functions
*
* @since	2.0
*/

$functions_dir = plugin_dir_path( __FILE__) . 'includes/';

// Include all the various functions

include_once( $functions_dir . 'set-defaults.php' );						        // Set default options

include_once( $functions_dir . 'config.php' );					   			    	// Administration menus

include_once( $functions_dir . 'shared-functions.php' );                            // Shared functions

include_once( $functions_dir . 'generate-code.php' );        		        		// Generate the code

include_once( $functions_dir . 'shortcodes.php' );					        		// Shortcodes
?>