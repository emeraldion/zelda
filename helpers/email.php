<?php

	/**
	 *	@class ContactEmail
	 *	@short Helper class to send emails.
	 */
	class Email
	{
		/**
		 *	@short A default subject for the email message.
		 */
		const default_subject = 'Message from Emeraldion Lodge';
		
		/**
		 *	@short A default recipient for the email message.
		 */
		const default_recipient = 'claudio@emeraldion.it';
		
		/**
		 *	@attr name
		 *	@short The name of the sender.
		 */
		public $name;
		
		/**
		 *	@attr email
		 *	@short The email address of the sender.
		 */
		public $email;
		
		/**
		 *	@attr subject
		 *	@short The subject of the email.
		 */
		public $subject;
		
		/**
		 *	@attr recipient
		 *	@short The email address of the recipien of the sender.
		 */
		public $recipient;
		
		/**
		 *	@attr text
		 *	@short The text of the email message.
		 */
		public $text;
		
		/**
		 *	@attr headers
		 *	@short An array of headers for the email.
		 */
		public $headers;
		
		/**
		 *	@fn Email($params)
		 *	@short Creates the Email object.
		 *	@param params Parameters to initialize the email.
		 */
		public function Email($params)
		{
			$this->name = $params['name'];
			$this->email = $params['email'];
			$this->subject = !empty($params['subject']) ?
				$params['subject'] : self::default_subject;
			$this->recipient = self::default_recipient;
			$this->headers = "From: {$params['name']}<{$params['email']}>";
			$this->text = get_magic_quotes_gpc() ? stripslashes($params['text']) : $params['text'];
			$this->date = date("d/m/Y H:i:s");
		}
		
		/**
		 *	@fn send
		 *	@short Sends the email.
		 */
		public function send()
		{
			mail($this->recipient,
				$this->subject,
				$this->make_text(),
				$this->headers);
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
IP: {$_SERVER['REMOTE_ADDR']}
User Agent: {$_SERVER['HTTP_USER_AGENT']}
Data: {$this->date}

{$this->text}

-- 
Emeraldion Lodge
http://www.emeraldion.it

EOT;
		}
		
		/**
		 *	@fn is_valid($address)
		 *	@short Validates an email address.
		 *	@param address The address to validate.
		 */
		public static function is_valid($address)
		{
			return ereg("^[_a-z0-9\-]+(\.[_a-z0-9\-]+)*@[a-z0-9-]+(\.[a-z0-9\-]+)+$",
				$address);
		}
	}
?>