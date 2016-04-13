<?php
/**
 * Simple BuddyPress email template based on Mandrill
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<p>{{{content}}}</p>
<br/>
<small><a href="{{{unsubscribe}}}"><?php _ex( 'unsubscribe', 'email', 'buddypress' ); ?></a></small>
