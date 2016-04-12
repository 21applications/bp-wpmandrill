# bp-wpmandrill
Allows the new BuddyPress HTML email to be sent using Mandrill.

BuddyPress 2.5 introduced a new stylised HTML email system.  By default the HTML system doesn't work if a 3rd party transactional 
email plugin is active (e.g. wpMandrill or SendGrid), and reverts to sending plain text emails.

This plugin allows the stylised BuddyPress HTML emails to be sent using Mandrill.  It does this by sending the email through wp_mail() rather than directly with PHPMailer, and sets a few relevant filters.

Requires the wpMandrill plugin to be installed and active.

This is a working proof of concept rather than a robust solution.

Doesn't currently support Mandrill templates.
