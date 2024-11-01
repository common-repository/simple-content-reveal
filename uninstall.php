<?php
/**
* Uninstaller
*
* Uninstall the plugin by removing any options from the database
*
* @package	ContentReveal
* @since	2.0
*/

// If the uninstall was not called by WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// Delete all options
delete_option( 'content_reveal_options' );
?>