//
// The following code is a modified version of that provided by http://www.quirksmode.org/js/cookies.html
// Kudos to them for their assistance
//

// Create a cookie

function acr_createCookie(name, value, hours) {
    if (hours) {
        var date = new Date();
        date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

// Read a cookie

function acr_readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Delete a cookie

function acr_eraseCookie(name) {
	acr_createCookie(name,"",-1);
}

//
// The following is my own code
//

// Set initial CSS & heading text

function acr_set_initial_css(swap_id, css_default, title_default) {

    //console.log('test message');

    var cookie_content = acr_readCookie('content_reveal_' + swap_id);

    if (cookie_content) {

        // Split out cookie into an array

        cookie_content=unescape(cookie_content);
        var cookieArray = new Array();
        cookieArray=cookie_content.split(',');

        // Set the title

        var title = cookieArray[2];
        if (title) {
            document.getElementById('scrtit_' + swap_id).innerHTML = title;
        } else {
            if (title_default) {document.getElementById('scrtit_' + swap_id).innerHTML = title_default;}
        }

        // Set the CSS

        var state = cookieArray[3];
        if (state) {return state;} else {return css_default;}

    } else {

        if (title_default) {document.getElementById('scrtit_' + swap_id).innerHTML = title_default;}
        return css_default;
    }
}

// Set initial image state

function acr_set_initial_img(swap_id, img_default) {

    var cookie_content = acr_readCookie('content_reveal_' + swap_id);
    if (cookie_content) {

        // Split out cookie into an array

        cookie_content=unescape(cookie_content);
        var cookieArray = new Array();
        cookieArray=cookie_content.split(',');

        var state = cookieArray[0];
        if (state) {return state;}
    }
    return img_default;
}

// Set initial ALT & TITLE for image

function acr_set_initial_alt(swap_id, alt_default) {

    var cookie_content = acr_readCookie('content_reveal_' + swap_id);
    if (cookie_content) {

        // Split out cookie into an array

        cookie_content=unescape(cookie_content);
        var cookieArray = new Array();
        cookieArray=cookie_content.split(',');

        var state = cookieArray[1];
        if (state) {return state;}
    }
    return alt_default;
}

// Swap the images and CSS between 2 states

function acr_swap_display(swap_id, cookie, heading1, heading2) {

    var id_text = "scrdiv_" + swap_id;
    var id_image = "scrimg_" + swap_id;
	var id_title = "scrtit_" + swap_id;

    // Swap the display element of the named ID

    var state = document.getElementById(id_text).style.display;
    if (state == "none") {
        var new_display = "block";
    } else {
        var new_display = "none";
    }
    document.getElementById(id_text).style.display = new_display;

    // Swap the image URL and title

    var el = document.getElementById(id_image);
    var state = undefined;
    if (el != null) state = el.src;

    if (state != undefined) {
        var src_name = state.substr(state.length - 10, 6);
        var src_ext = state.substr(state.length - 3, 3);
        var src_path = state.substr(0, state.length - src_name.length - src_ext.length - 1);

        if (src_name == "image1") {
            var src_name = "image2";
            var alt_name = "Hide content";
        } else {
            var src_name = "image1";
            var alt_name = "Reveal content";
        }

        document.getElementById(id_image).src = src_path + src_name + "." + src_ext;
        document.getElementById(id_image).alt = alt_name;
        document.getElementById(id_image).title = alt_name;
    }

    // Swap the heading text

    var el = document.getElementById(id_title);
    var state = undefined;
    if (el != null) state = el.innerHTML;

    if (state != undefined) {
        if (state == heading2) {
            var new_title = heading1;
        } else {
            var new_title = heading2;
        }
        document.getElementById(id_title).innerHTML = new_title;
    }

	// Update the cookie or, if switched off, delete it

    if (cookie != "0") {
        var cookieArray = new Array();
        cookieArray[0] = src_name;
        cookieArray[1] = alt_name;
        cookieArray[2] = new_title;
        cookieArray[3] = new_display;

        acr_createCookie("content_reveal_" + swap_id, escape(cookieArray.join(',')), cookie);
	} else {
		acr_eraseCookie("content_reveal_" + swap_id);

        // These are the old cookie names and retained here to ensure they
        // are deleted

        acr_eraseCookie("acrIMGcookie_" + swap_id);
		acr_eraseCookie("acrALTcookie_" + swap_id);
		acr_eraseCookie("acrTITcookie_" + swap_id);
		acr_eraseCookie("acrCSScookie_" + swap_id);
    }
}