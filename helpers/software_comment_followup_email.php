<?php
	require_once(dirname(__FILE__) . "/software_comment_email.php");
	
	/**
	 *	@class SoftwareCommentFollowupEmail
	 *	@short Helper class to send an email to the website administrator when
	 *	someone has written a comment for a software product.
	 */
	class SoftwareCommentFollowupEmail extends SoftwareCommentEmail
	{
		const default_subject = '[Emeraldion Lodge] New comment on: %s';
		
		/**
		 *	@fn SoftwareCommentFollowupEmail($params)
		 *	@short Creates the SoftwareCommentFollowupEmail object.
		 *	@param params Parameters to initialize the email.
		 */
		public function SoftwareCommentFollowupEmail($params)
		{
			if (isset($params['comment']) &&
				$params['comment'] instanceof SoftwareComment)
			{
				$this->comment = $params['comment'];
			}
			else if (isset($params['comment_id']))
			{				
				$this->comment = new SoftwareComment();
				$this->comment->find_by_id($params['comment_id']);
			}
			$this->comment->belongs_to('softwares');
			
			$this->name = $params['name'];
			$this->email = $params['email'];
			$this->subject = !empty($params['subject']) ?
				$params['subject'] :
				sprintf(self::default_subject, $this->comment->software->title);
			$this->recipient = $params['email'];
			$this->headers = "From: Emeraldion Lodge<emeraldion@emeraldion.it>";
			$this->text = <<<EOT
Author: {$this->comment->author}
Comment:
{$this->comment->text}
EOT;
			$this->date = date("d/m/Y H:i:s");
		}
		
		/**
		 *	@fn make_text
		 *	@short Creates the text of the email.
		 */
		public function make_text()
		{
			$software_url = $this->comment->software->permalink(FALSE);
			$comments_url = $this->comment->software->comments_permalink();
			return <<<EOT
There is a new comment on the software {$this->comment->software->title}. 
{$software_url}

{$this->text}

See all comments here:
{$comments_url}

Unsubscribe from email notifications for this thread:
{$comments_unsubscribe_thread_url}
Unsubscribe from all email notifications:
{$comments_unsubscribe_all_url}

-- 
Emeraldion Lodge
http://www.emeraldion.it

EOT;
		}
	}

?>