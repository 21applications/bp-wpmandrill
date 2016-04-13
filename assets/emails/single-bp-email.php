<?php
/**
 * Simple BuddyPress email template based on Mandrill
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$settings = bp_email_get_appearance_settings();


?>
<p>{{{content}}}</p>
<br/>
<small><a href="{{{unsubscribe}}}"><?php _ex( 'unsubscribe', 'email', 'buddypress' ); ?></a></small>
