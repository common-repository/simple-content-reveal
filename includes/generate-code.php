<?php
/**
* Generate Content Reveal Code
*
* Functions to generate the content reveal code
*
* @package	ContentReveal
*/

/**
* Content Reveal Start
*
* Function to write out initial script around content
*
* @since	2.0
*
* @param	string	$heading	Content heading
* @param	string	$id			Unique ID
* @param	string	$default	Default state
* @param	string	$img_url	Image folder URL
* @param	string	$ext		Image extension
* @param	string	$cookie		Time to retain cookies
* @param	string	$link		Whether to just display link or not
* @return	string				Code to output
*/

function acr_start( $heading = '', $id = '', $default = '', $img_url = '', $ext = '', $cookie = '', $link = false, $title1 = '', $title2 = '' ) {

	$plugin = 'Content Reveal';
	$error = false;

	global $wp_query;
	if ( isset( $wp_query -> query_vars[ 'acr_state' ] ) ) { $page_default = strtolower( $wp_query -> query_vars[ 'acr_state' ] ); } else { $page_default = ''; }
	if ( isset( $wp_query -> query_vars[ 'acr_cookies' ] ) ) { $cookie = strtolower( $wp_query -> query_vars[ 'acr_cookies' ] ); }

	$options = get_option( 'content_reveal_options' );

	// Get cookie details

	if ( $cookie == '' ) {
		if ( ( $options[ 'cookies' ] == 1 ) or ( $options[ 'cookies' ] == 2 ) ) {
            if ( ( $options[ 'cookies' ] == 1 ) && ( acr_do_not_track() ) ) {
                $cookie = 0;
            } else {
                $cookie = $options[ 'time' ];
                if ( $options[ 'period' ] == 'd' ) { $cookie = $options[ 'time' ] * 24; }
			}
		} else {
			$cookie = 0;
		}
	}
	if ( !is_numeric( $cookie ) ) { $error = report_acr_error( __( 'The cookie length was not numeric - it should be a number of hours', 'simple-content-reveal' ), $plugin );  }

    // Validate ID and heading

    if ( $id == '' ) { $id = uniqid( 'ran_' ); } else { $id = str_replace( ' ', '_', $id ); }
    if ( $heading == '' ) { $error = report_acr_error( __( 'No heading was specified', 'simple-content-reveal' ), $plugin ); }
	if ( $title2 == '' ) { $title2 = $title1; }

    // Set up and validate image extension

    $ext = strtolower( $ext );
    if ( $ext == '' ) { $ext = 'gif'; }
    if ( ( $ext != 'gif' ) && ( $ext != 'png' ) ) { $error = report_acr_error( __( 'Invalid image extension - must be PNG or GIF', 'simple-content-reveal' ), $plugin ); }

    // Set image folder

    if ( $img_url == '' ) {
		$img_url = plugins_url( 'images/', dirname(__FILE__) );
	} else {
		if ( ( substr( $img_url, 0, 7 ) != 'http://' ) && ( substr( $img_url, 0, 8 ) != 'https://' ) ) {
			if ( substr( $img_url, 0, 1 ) == '/' ) { $img_url = substr( $img_url, 1 ); }
			$img_url = content_url( 'uploads/content-reveal/' . $img_url );
		}
	}
	if ( substr( $img_url, -1, 1 ) != '/' ) { $img_url .= '/'; }

    // Set up the default - hide or show

	if ( ( $page_default == '' ) or ( $page_default == 'off') ) {
		$default = strtolower( $default );
		if ( $default == '' ) {
			$default = $options[ 'default' ];
		}
	} else {
		$default = $page_default;
	}

	if ( ( $default == 'hide' ) or ( $default == '' ) or ( $page_default == 'hide' ) ) {
		$default = 'none';
		$image_num = 1;
		$the_title = $title1;
		$alt_text = 'Reveal content';
	} else {
		if ( ( $default == 'show' ) or ( $page_default == 'show' ) ) {
			$default = 'block';
			$image_num = 2;
			$the_title = $title2;
			$alt_text = 'Hide content';
		} else {
			$error = report_acr_error( __( "Invalid default - must be blank, 'show' or 'hide'", 'simple-content-reveal' ), $plugin );
		}
	}

    if ( !$error ) {

        // Add image to heading, if required - it is enclosed in JavaScript, so that it doesn't appear if JS is turned off

		if ( $page_default == 'off' ) {
			$img_code = '';
		} else {
			$img_code = "<script type=\"text/javascript\">document.writeln('<img src=\"" . $img_url;
			if ( ( $page_default == 'hide' ) or ( $page_default == 'show' ) or ( $cookie == 0 ) ) {
				$img_code .= 'image' . $image_num;
			} else {
				$img_code .= "'+acr_set_initial_img('" . $id . "','image" . $image_num . "')+'";
			}
			$img_code .= "." . $ext . "\" class=\"scrimg\" id=\"scrimg_" . $id . "\" ";
			if ( ( $page_default == 'hide' ) or ( $page_default == 'show' ) or ( $cookie == 0 ) ) {
				$img_code .= "alt=\"" . $alt_text . "\" title=\"" . $alt_text;
			} else {
				$img_code .= "alt=\"'+acr_set_initial_alt('" . $id . "','" . $alt_text . "')+'\" title=\"'+acr_set_initial_alt('" . $id . "','" . $alt_text . "')+'";
			}
			$img_code .= "\"/>');</script>";
		}
        $heading = str_replace( '%image%', $img_code, $heading );

		// Set title text

		$title_code = "<span id=\"scrtit_" . $id . "\">" . $the_title . "</span>";
        $heading = str_replace( '%title%', $title_code , $heading );

        // Output JavaScript to content

        $output = "<!-- " . $plugin . " v" . content_reveal_version . " -->\n";

		// Out the image information

		if ( $heading != 'noheading' ) {
			$output .= "<div class=\"scrhead\"";
			if ( $page_default  != 'off' ) {
				$output .= " onmouseover=\"document.body.style.cursor='pointer'\" onmouseout=\"document.body.style.cursor='default'\" onclick=\"acr_swap_display('" . $id . "','" . $cookie . "','" . $title1 . "','" . $title2 . "')\"";
			}
			$output .= ">\n" . $heading . "\n";
			$output .= "</div>\n";
		}

		// Output the DIV information

		if ( !$link ) {
			if ( $page_default != 'off' ) {
				$output .= "<script type=\"text/javascript\">document.writeln('<div style=\"display: ";
				if ( ( $page_default == 'hide' ) or ( $page_default == 'show' )  or ( $cookie == 0 ) ) {
					$output .= $default;
				} else {
					$output .= "'+acr_set_initial_css('" . $id . "','" . $default . "','" . $the_title . "')+'";
				}
				$output .= "\" class=\"scrdiv\" id=\"scrdiv_" . $id . "\">');</script>\n";
			} else {
				$output .= "<div class=\"scrdiv\" id=\"scrdiv_" . $id . "\">\n";
			}
		}

        return $output;
    }
}

/**
* Content Reveal End
*
* Function to write out final bit of script around content
*
* @since	2.0
*
* @return	string				Code to output
*/

function acr_end() {

	global $wp_query;

	if ( isset( $wp_query -> query_vars[ 'acr' ] ) ) { $page_default = strtolower( $wp_query -> query_vars[ 'acr' ] ); } else { $page_default = ''; }

	if ($page_default == 'off') {
		$output = "</div>\n";
	} else {
		$output = "<script type=\"text/javascript\">document.writeln('</div>');</script>\n";
	}
    $output .= '<!-- ' . __( 'End of Content Reveal' , 'simple-content-reveal' ) . " -->\n";

    return $output;
}
?>