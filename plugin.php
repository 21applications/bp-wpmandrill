<?php
/*
Plugin Name: bp wpMandrill
Plugin URI: http://21applications.com
Description: Allows the new BuddyPress HTML email to be sent using Mandrill.
Author: Roger Coathup
Version: 1.0
Author URI: http://21applications.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 

*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;
	
define( 'BP_WPMANDRILL_IS_INSTALLED', 1 );

define( 'BP_WPMANDRILL_VERSION', '1.0' );

define( 'BP_WPMANDRILL_PLUGIN_DIR', dirname( __FILE__ ) );
	

add_action( 'init', 'bp_wpmandrill_filters' );

function bp_wpmandrill_filters() {
	
	add_filter( 'bp_email_use_wp_mail', function( $bool ) {	
		return false;
		}, 10, 1 );
	
	add_filter( 'bp_send_email_delivery_class', function( $class, $email_type, $to, $args ) {
		return 'BP_WPMandrill'; 
		}, 10, 4 );
}



class BP_WPMandrill implements BP_Email_Delivery {

	 
	var $send_as_html;
	var $content = array();
	
	public function bp_email( BP_Email $email ) {
		
		if ( $email->get( 'content_type' ) === 'html' ) {
			
			$this->send_as_html = true;
			
		} else {
			
			$this->send_as_html = false;
			
		}
		
		add_filter( 'wp_mail_content_type', array( $this, 'set_content_type' ), 100 );
		add_action( 'phpmailer_init',   array( $this, 'send_html' ) );
		
		
		$recipients = $email->get_to();
		
		$to = array();
		
		foreach ( $recipients as $recipient ) {
			$to[] = $recipient->get_address();
		}
		
		$subject = $email->get_subject( 'replace-tokens' );
		
		$this->content['plain'] = normalize_whitespace( $email->get_content_plaintext( 'replace-tokens' ) );
		
		if ( $email->get( 'content_type' ) === 'html' ) {
			
			$this->content['html'] = $email->get_template( 'add-content' );
			$message = $this->content['html'];
			
		} else {
			
			$message = $this->content['plain'];
			
		}
		

		return wp_mail( $to, $subject, $message );


	}
	
	function set_content_type( $content_type ) {
		
		if ( $content_type == 'text/plain' && $send_as_html === true ) {
			$content_type = 'text/html';
		} 
		
		return $content_type;
		
	}
	
	
	function send_html( $phpmailer ) {

		$phpmailer->AltBody = $this->content['plain'];

		if ( $this->send_as_html ) {
			$phpmailer->Body = $this->content['html'];
		}

	}

}
