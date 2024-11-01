<?php
/**
* Shortcodes
*
* Content Reveal shortcode functions
*
* @package	ContentReveal
*/

/**
* Content Reveal Shortcode
*
* Shortcode to add reveal functionality in posts/pages
*
* @since	2.0
*
* @param	string	$paras		Shortcode parameters
* @param	string	$content	Page content
* @return	string				Page content
*/

function sc_content_reveal( $paras = '', $content = '' ) {

	extract( shortcode_atts( array( 'heading' => '', 'id' => '', 'default' => '', 'img_url' => '', 'ext' => '', 'cookie' => '', 'title1' => '', 'title2' => '', 'folder' => '' ), $paras ) );
	
	if ( $img_url == '') { $img_url = $folder; }

    if ( $content == '' ) {

		// If no content used, default to old method of requiring 2 shortcode calls

        if ( $heading . $id . $default . $img_url . $ext . $cookie == "") {
            return do_shortcode( acr_end() );
        } else {
            return do_shortcode( acr_start( $heading, $id, $default, $img_url, $ext, $cookie, '', $title1, $title2 ) );
        }

    } else {

		// If content specified, wrap start and end of content reveal code around it

		return do_shortcode( acr_start( $heading, $id, $default, $img_url, $ext, $cookie, '', $title1, $title2 ) . $content . acr_end() );
    }
}

add_shortcode( 'reveal', 'sc_content_reveal' );

/**
* Content Reveal Link Shortcode
*
* Shortcode to add link to hide/reveal section
*
* @since	2.0
*
* @param	string	$paras		Shortcode parameters
* @param	string	$content	Not used
* @return	string				Page content
*/

function sc_content_link( $paras = '', $content = '' ) {

	extract( shortcode_atts( array( 'heading' => '', 'id' => '', 'default' => '', 'img_url' => '', 'ext' => '', 'cookie' => '' ), $paras ) );

    return do_shortcode( acr_start( $heading, $id, $default, $img_url, $ext, $cookie, true ) );
}

add_shortcode( 'reveal_link', 'sc_content_link' );

/**
* Cookie Length Shortcode
*
* Shortcode to output length of time cookie is stored for
*
* @since	1.2
*
* @param	string	$paras		Shortcode parameters
* @param	string	$content	Not used
* @return	string				Page content
*/

function acr_get_cookie_details( $paras = '', $content = '' ) {

    $options = acr_get_options();

    $content = $options[ 'time' ];
    if ( $content != '' ) {
        if ( $options[ 'period' ] == 'h' ) {
            $content .= ' ' . __( 'hours', 'simple-content-reveal' );
        } else {
            $content .= ' ' . __( 'days', 'simple-content-reveal' );
        }
    }

    if ( $content == '' ) { $content = __( 'an unknown period of time', 'simple-content-reveal' ); }

    return $content;
}

add_shortcode( 'acr_cookies', 'acr_get_cookie_details' );
?>