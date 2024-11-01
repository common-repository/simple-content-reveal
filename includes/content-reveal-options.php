<?php
/**
* Content Reveal Options Page
*
* Screen for Content Reveal options
*
* @package	ContentReveal
* @since	2.0
*/
?>
<div class="wrap">
<h1><?php _e( 'Content Reveal Options', 'simple-content-reveal' ); ?></h1>

<?php

// If options have been updated on screen, update the database

if ( ( !empty( $_POST ) ) && ( check_admin_referer( 'content-reveal-options', 'content_reveal_options_nonce' ) ) ) {

	if ( isset( $_POST[ 'content_reveal_editor_button' ] ) ) { $options[ 'editor_button' ] = $_POST[ 'content_reveal_editor_button' ]; } else { $options[ 'editor_button' ] = ''; }
	if ( ( $_POST[ 'content_reveal_cookies' ] == '' ) or ( $_POST[ 'content_reveal_cookies' ] == '1' ) or ( $_POST[ 'content_reveal_cookies' ] == '2' ) ) { $options[ 'cookies' ] = $_POST[ 'content_reveal_cookies' ]; } else { $options[ 'cookies' ] = ''; }
	if ( ( $_POST[ 'content_reveal_period' ] == 'h' ) or ( $_POST[ 'content_reveal_period' ] == 'd' ) ) { $options[ 'period' ] = $_POST[ 'content_reveal_period' ]; } else { $options[ 'period' ] = 'h'; }
	if ( ( $_POST[ 'content_reveal_default' ] == '' ) or ( $_POST[ 'content_reveal_default' ] == 'show' ) ) { $options[ 'default' ] = $_POST[ 'content_reveal_default' ]; } else { $options[ 'default' ] = ''; }

	if ( ( $_POST[ 'content_reveal_time' ] < 0 ) or ( $_POST[ 'content_reveal_time' ] > 999 ) ) {

		echo '<div class="error"><p><strong>' . __( 'Invalid time specified. Must be between 0 and 999.', 'simple-content-reveal' ) . "</strong></p></div>\n";

	} else {

		$options[ 'time' ] = $_POST[ 'content_reveal_time' ];

		// Update the options

		update_option( 'content_reveal_options', $options );

		echo '<div class="updated"><p><strong>' . __( 'Settings Saved.', 'simple-content-reveal' ) . "</strong></p></div>\n";
	}

} else {

	// Get options

	$options = acr_get_options();
}
?>

<p><?php _e( 'These are the general settings for Content Reveal.', 'simple-content-reveal' ); ?></p>

<form method="post" action="<?php echo site_url( '/wp-admin/options-general.php?page=content-reveal-options' ); ?>">

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'Show Editor Button', 'simple-content-reveal' ); ?></th>
<td><label for="content_reveal_editor_button"><input type="checkbox" name="content_reveal_editor_button" value="1"<?php if ( $options[ 'editor_button' ] == "1" ) { echo ' checked="checked"'; } ?>/>
<?php _e( 'Show the Content Reveal button on the post editor', 'simple-content-reveal' ); ?></label></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Default State', 'simple-content-reveal' ); ?></th>
<td><label for="content_reveal_default"><select name="content_reveal_default">
<option value=""<?php if ( $options[ 'default' ] == '' ) { echo " selected='selected'"; } ?>><?php _e ( 'Hide content', 'simple-content-reveal' ); ?></option>
<option value="show"<?php if ( $options[ 'default' ] == 'show' ) { echo " selected='selected'"; } ?>><?php _e ( 'Show content', 'simple-content-reveal' ); ?></option>
</select></label>
<p class="description"><?php _e( 'The default state for content to appear as - either being shown or hidden.', 'simple-content-reveal' ); ?></p></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Cookie Use', 'simple-content-reveal' ); ?></th>
<td><label for="content_reveal_cookies"><select name="content_reveal_cookies">
<option value=""<?php if ( $options[ 'cookies' ] == '' ) { echo " selected='selected'"; } ?>><?php _e ( 'Do not store cookies', 'simple-content-reveal' ); ?></option>
<option value="1"<?php if ( $options[ 'cookies' ] == '1' ) { echo " selected='selected'"; } ?>><?php _e ( 'Use cookies unless Do Not Track is active', 'simple-content-reveal' ); ?></option>
<option value="2"<?php if ( $options[ 'cookies' ] == '2' ) { echo " selected='selected'"; } ?>><?php _e ( 'Use cookies and ignore Do Not Track', 'simple-content-reveal' ); ?></option>
</select><?php _e( 'Cookies are used to store the state of content', 'simple-content-reveal' ); ?></label>
<p class="description"><?php _e( '<a href="http://donottrack.us/">Do Not Track</a> is a browser option that requests that information is not stored about that user.', 'simple-content-reveal' ); ?></p></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Cookie Retention', 'simple-content-reveal' ); ?></th>
<td><label for="content_reveal_time"><input type="text" size="3" maxlen="3" max="999" min="0" name="content_reveal_time" value="<?php echo $options[ 'time' ]; ?>"/></label>&nbsp;
<label for="content_reveal_period"><select name="content_reveal_period">
<option value="h"<?php if ( $options[ 'period' ] == "h" ) { echo " selected='selected'"; } ?>><?php _e ( 'Hours', 'simple-content-reveal' ); ?></option>
<option value="d"<?php if ( $options[ 'period' ] == "d" ) { echo " selected='selected'"; } ?>><?php _e ( 'Days', 'simple-content-reveal' ); ?></option>
</select><?php _e( 'How long to retain the cookies for', 'simple-content-reveal' ); ?></label></td>
</tr>

</table>

<?php wp_nonce_field( 'content-reveal-options', 'content_reveal_options_nonce', true, true ); ?>

<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'simple-content-reveal' ); ?>"/></p>

</form>

</div>