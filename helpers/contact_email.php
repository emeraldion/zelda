<?php
	require_once(dirname(__FILE__) . "/email.php");
	
	/**
	 *	@class ContactEmail
	 *	@short Helper class to send contact emails to the website administrator.
	 */
	class ContactEmail extends Email
	{
		const default_subject = 'Messaggio dal sito Emeraldion.it da parte di ';
		
		/**
		 *	@attr URL
		 *	@short The URL of the website of the sender.
		 */
		public $URL;
		
		/**
		 *	@fn ContactEmail($params)
		 *	@short Creates the ContactEmail object.
		 *	@param params Parameters to initialize the email.
		 */
		public function ContactEmail($params)
		{
			$this->name = $params['name'];
			$this->email = $params['email'];
			$this->subject = !empty($params['subject']) ?
				$params['subject'] : (self::default_subject . $params['name']);
			$this->URL = $params['URL'];
			$this->recipient = self::default_recipient;
			$this->headers = "From: {$params['name']}<{$params['email']}>";
			$this->text = get_magic_quotes_gpc() ? stripslashes($params['text']) : $params['text'];
			$this->date = date("d/m/Y H:i:s");
		}
		
		/**
		 *	@fn make_text
		 *	@short Creates the text of the email.
		 */
		public function make_text()
		{
			return <<<EOT
Da: {$this->name}
Email: {$this->email}
URL: {$this->URL}
IP: {$_SERVER['REMOTE_ADDR']}
User Agent: {$_SERVER['HTTP_USER_AGENT']}
Data: {$this->date}

{$this->text}

-- 
Emeraldion Lodge
http://www.emeraldion.it

EOT;
		}
	}

?>