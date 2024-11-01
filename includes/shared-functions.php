<?php
/**
* Shared Functions
*
* Assorted shared functions
*
* @package	ContentReveal
*/

/**
* Report an error (1.4)
*
* Function to report an error
*
* @since	1.0
*
* @param	$error			string	Error message
* @param	$plugin_name	string	The name of the plugin
* @param	$echo			string	True or false, depending on whether you wish to return or echo the results
* @return					string	True
*/

function report_acr_error( $error, $plugin_name, $echo = true ) {

	$output = '<p style="color: #f00; font-weight: bold;">' . $plugin_name . ': ' . $error . "</p>\n";

	if ( $echo ) {
		echo $output;
		return true;
	} else {
		return $output;
	}

}

/**
* Is Do Not Track active?
*
* Function to return whether Do Not Track is active in the current
* browser
*
* @since	2.1
*
* @return			    string	True or false
*/

function acr_do_not_track() {    // 1.0

	if ( isset( $_SERVER[ 'HTTP_DNT' ] ) ) {
		if ( $_SERVER[ 'HTTP_DNT' ] == 1 ) { return true; }
    } else {
        if ( function_exists( 'getallheaders' ) ) {
            foreach ( getallheaders() as $key => $value ) {
                if ( ( strtolower( $key ) === 'dnt' ) && ( $value == 1 ) ) { return true; }
            }
        }
    }
	return false;
}
?>