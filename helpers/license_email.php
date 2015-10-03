<?php
	require_once(dirname(__FILE__) . "/email.php");
	require_once(dirname(__FILE__) . "/license.php");
	require_once(dirname(__FILE__) . "/../models/software.php");
	
	/**
	 *	@class LicenseEmail
	 *	@short Helper class to send license emails to software users.
	 */
	class LicenseEmail extends Email
	{
		const default_subject = 'Messaggio dal sito Emeraldion.it da parte di ';
		
		/**
		 *	@attr license
		 *	@short The license that you want to send.
		 */
		public $license;
		
		/**
		 *	@attr software
		 *	@short The software the license is related to.
		 */
		public $software;
		
		/**
		 *	@fn LicenseEmail($params)
		 *	@short Creates the LicenseEmail object.
		 *	@param params Parameters to initialize the email.
		 */
		public function LicenseEmail($params)
		{
			$this->name = $params['name'];
			$this->email = $params['email'];
			$this->subject = !empty($params['subject']) ?
				$params['subject'] : (self::default_subject . $params['name']);
			$this->recipient = self::default_recipient;
			$this->headers = "From: {$params['name']}<{$params['email']}>";
			if (!empty($params['text']))
			{
				$this->text = get_magic_quotes_gpc() ? stripslashes($params['text']) : $params['text'];
			}
			$this->date = date("d/m/Y H:i:s");
		}
		
		/**
		 *	@fn make_text
		 *	@short Creates the text of the email.
		 */
		public function make_text()
		{
			$activation_url = $this->license->activation_url();
			return <<<EOT

Thank you for registering {$this->software->title}!

Your registration codes:

Name:
{$this->license->username}
Registration Key:
{$this->license->key}

To activate the application, show the registration sheet clicking on the
"Registration..." menu item under the "{$this->software->title}" menu,
then enter your registration codes.

Or, you can simply click on the following link:
<{$activation_url}>

As a registered user you will receive periodic updates on software releases.
If you do not want to receive further mailings, just reply to this email.

For any question, feedback or feature request, feel free to use this email address.

Best regards,

-- 
Emeraldion Lodge
http://www.emeraldion.it

EOT;
		}
	}

?>