<?php
	require_once(dirname(__FILE__) . "/email.php");
	require_once(dirname(__FILE__) . "/../models/diario_comment.php");
	
	/**
	 *	@class DiarioCommentEmail
	 *	@short Helper class to send an email to the website administrator when
	 *	someone has written a comment for a Diario article.
	 */
	class DiarioCommentEmail extends Email
	{
		const default_subject = '%s ha scritto un commento sul Diario';
		
		/**
		 *	@attr URL
		 *	@short The URL of the website of the sender.
		 */
		public $URL;

		/**
		 *	@attr comment
		 *	@short The comment.
		 */
		private $comment;
		
		/**
		 *	@fn DiarioCommentEmail($params)
		 *	@short Creates the DiarioCommentEmail object.
		 *	@param params Parameters to initialize the email.
		 */
		public function DiarioCommentEmail($params)
		{
			if (isset($params['comment']) &&
				$params['comment'] instanceof DiarioComment)
			{
				$this->comment = $params['comment'];
			}
			else if (isset($params['comment_id']))
			{				
				$this->comment = new DiarioComment();
				$this->comment->find_by_id($params['comment_id']);
			}
			$this->name = $params['name'];
			$this->email = $params['email'];
			$this->subject = !empty($params['subject']) ?
				$params['subject'] : sprintf(self::default_subject, $params['name']);
			$this->URL = $params['URL'];
			$this->recipient = self::default_recipient;
			$this->headers = "From: {$params['name']}<{$params['email']}>";
			$this->text = $this->comment->text;
			$this->date = date("d/m/Y H:i:s");
		}
		
		/**
		 *	@fn make_text
		 *	@short Creates the text of the email.
		 */
		public function make_text()
		{
			$moderate_url = $this->comment->moderate_url();
			$discard_url = $this->comment->discard_url();
			return <<<EOT
Da: {$this->name}
Email: {$this->email}
URL: {$this->URL}
IP: {$_SERVER['REMOTE_ADDR']}
User Agent: {$_SERVER['HTTP_USER_AGENT']}
Data: {$this->date}

{$this->text}

Approva
<{$moderate_url}>

Elimina
<{$discard_url}>

-- 
Emeraldion Lodge
http://www.emeraldion.it

EOT;
		}
	}

?>