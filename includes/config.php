<?php
/**
* Admin Menu Functions
*
* Various functions relating to the various administration screens
*
* @package	ContentReveal
*/

/**
* Add Settings link to plugin list
*
* Add a Settings link to the options listed against this plugin
*
* @since	2.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function acr_add_settings_link( $links, $file ) {

	static $this_plugin;

	if ( !$this_plugin ) { $this_plugin = plugin_basename( __FILE__ ); }

	if ( strpos( $file, 'content-reveal.php' ) !== false ) {
		$settings_link = '<a href="options-general.php?page=content-reveal-options">' . __( 'Settings', 'simple-content-reveal' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}

add_filter( 'plugin_action_links', 'acr_add_settings_link', 10, 2 );

/**
* Add meta to plugin details
*
* Add options to plugin meta line
*
* @since	2.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function acr_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'content-reveal.php' ) !== false ) { $links = array_merge( $links, array( '<a href="https://wordpress.org/support/plugin/simple-content-reveal">' . __( 'Support', 'simple-content-reveal' ) . '</a>' ) ); }

	return $links;
}
add_filter( 'plugin_row_meta', 'acr_set_plugin_meta', 10, 2 );

/**
* Administration Menu
*
* Add a new option to the Admin menu and context menu
*
* @since	2.1
*
* @uses acr_help		Return help text
*/

function acr_menu() {

    // Add options sub-menu

    global $acr_options_hook;

	$acr_options_hook = add_submenu_page( 'options-general.php', __( 'Content Reveal Options', 'content-reveal' ), __( 'Content Reveal', 'simple-content-reveal' ), 'edit_posts', 'content-reveal-options', 'acr_options' );

    add_action( 'load-' . $acr_options_hook, 'acr_add_options_help' );

}
add_action( 'admin_menu','acr_menu' );

/**
* Add Options Help
*
* Add help tab to options screen
*
* @since	2.1
*
* @uses     acr_options_help    Return help text
*/

function acr_add_options_help() {

    global $acr_options_hook;
    $screen = get_current_screen();

    if ( $screen->id != $acr_options_hook ) { return; }

    $screen -> add_help_tab( array( 'id' => 'acr-options-help-tab', 'title'	=> __( 'Help', 'simple-content-reveal' ), 'content' => acr_options_help() ) );
}

/**
* Options screen
*
* Define an option screen
*
* @since	2.1
*/

function acr_options() {

	include_once( 'content-reveal-options.php' );

}

/**
* Options Help
*
* Return help text for options screen
*
* @since	2.1
*
* @return	string	Help Text
*/

function acr_options_help() {

	$help_text = '<p>' . __( 'This screen allows you to set default options for Content Reveal. Simply change the require options and then click the Save Changes button at the bottom of the screen for the new settings to take effect.', 'simple-content-reveal' ) . '</p>';

	return $help_text;
}

/**
* Photon exception
*
* Prevent Photon from attempting to display the toggle images
*
* @since	2.3
*
* @param	string	$val	Value
* @param	string	$src	Source
* @param	string	$tag	Tag
* @return	string			Value
*/

function acr_photon_exception( $val, $src, $tag ) {

	$url = plugins_url( 'images/', dirname(__FILE__) );
	if ( substr( $src, 0, strlen( $url ) ) == $url ) {
		return true;
	}

	$url = content_url( 'uploads/content-reveal/' );
	if ( substr( $src, 0, strlen( $url ) ) == $url ) {
		return true;
	}

	return $val;
}

add_filter( 'jetpack_photon_skip_image', 'acr_photon_exception', 10, 3 );

/**
* Add URL Parameter
*
* Add a filter to WordPress to allow a new URL parameter
*
* @since	2.0
*
* @param	string	$url_vars	Array of allowed parameters
* @return	string				Array of allowed parameter - new parameter added
*/

function acr_add_url_para( $url_vars ) {
	$url_vars[] = 'acr_state';
	$url_vars[] = 'acr_cookies';
	return $url_vars;
}

add_filter( 'query_vars', 'acr_add_url_para' );

/**
* Add CSS files
*
* Add stylesheets to the admin screen
*
* @since	2.0
*/

function acr_menu_css() {

	wp_enqueue_style( 'tinymce_button', plugins_url( 'css/tinymce-button.min.css', dirname(__FILE__) ) );

}

add_action( 'admin_print_styles', 'acr_menu_css' );

/**
* Set up TinyMCE button
*
* Add filters (assuming user is editing) for TinyMCE
*
* @since 	2.0
*/

function content_reveal_button() {

	// Ensure user is in rich editor and button option is switched on

	if ( get_user_option( 'rich_editing' ) == 'true' ) {

		$options = acr_get_options();
		if ( $options[ 'editor_button' ] != '' ) {

			// Add filters

			add_filter( 'mce_external_plugins', 'add_content_reveal_mce_plugin' );
			add_filter( 'mce_buttons', 'register_content_reveal_button' );
		}
	}
}

add_action( 'init', 'content_reveal_button' );

/**
* Register new TinyMCE button
*
* Register details of new TinyMCE button
*
* @since	2.0
*
* @param	string	$buttons	TinyMCE button data
* @return	string				TinyMCE button data, but with new YouTube button added
*/

function register_content_reveal_button( $buttons ) {

	array_push( $buttons, 'mce_content_reveal' );

	return $buttons;
}

/**
* Register TinyMCE Script
*
* Register JavaScript that will be actioned when the new TinyMCE button is used
*
* @since	2.0
*
* @param	string	$plugin_array	Array of MCE plugin data
* @return	string					Array of MCE plugin data, now with URL of MCE script
*/

function add_content_reveal_mce_plugin( $plugin_array ) {

	$plugin_array[ 'mce_content_reveal' ] = plugins_url( 'js/mcebutton.min.js', dirname(__FILE__) );

	return $plugin_array;
}
?>