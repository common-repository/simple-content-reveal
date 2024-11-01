<?php
/**
* Set Default Options
*
* Set up default option values
*
* @package	ContentReveal
* @since	2.0
*
* @return   string				Options array
*/

function acr_get_options() {

	$options = get_option( 'content_reveal_options' );
	$changed = false;

	// Because of upgrading, check each option - if not set, apply default

	if ( !array_key_exists( 'editor_button', $options ) ) { $options[ 'editor_button' ] = 1; $changed = true; }
	if ( !array_key_exists( 'cookies', $options ) ) { $options[ 'cookies' ] = ''; $changed = true; }
	if ( !array_key_exists( 'time', $options ) ) { $options[ 'time' ] = 24; $changed = true; }
	if ( !array_key_exists( 'period', $options ) ) { $options[ 'period' ] = 'h'; $changed = true; }
	if ( !array_key_exists( 'default', $options ) ) { $options[ 'default' ] = ''; $changed = true; }	

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'content_reveal_options', $options ); }
	return $options;
}
?>