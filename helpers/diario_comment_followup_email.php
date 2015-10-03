<?php
	require_once(dirname(__FILE__) . "/diario_comment_email.php");
	
	/**
	 *	@class DiarioCommentFollowupEmail
	 *	@short Helper class to send an email to the website administrator when
	 *	someone has written a comment for a diario article.
	 */
	class DiarioCommentFollowupEmail extends DiarioCommentEmail
	{
		const default_subject = '[Emeraldion Lodge] New comment on: %s';
		
		/**
		 *	@fn DiarioCommentFollowupEmail($params)
		 *	@short Creates the DiarioCommentFollowupEmail object.
		 *	@param params Parameters to initialize the email.
		 */
		public function DiarioCommentFollowupEmail($params)
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
			$this->comment->belongs_to('diario_posts');
			
			$this->name = $params['name'];
			$this->email = $params['email'];
			$this->subject = !empty($params['subject']) ?
				$params['subject'] :
				sprintf(self::default_subject, $this->comment->diario_post->title);
			$this->recipient = $params['email'];
			$this->headers = "From: Emeraldion Lodge<emeraldion@emeraldion.it>";
			$this->text = <<<EOT
Author: {$this->comment->name}
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
			$post_url = $this->comment->diario_post->permalink(FALSE);
			$comments_url = $this->comment->diario_post->comments_permalink();
			return <<<EOT
There is a new comment on the Diario post {$this->comment->diario_post->title}. 
{$port_url}

{$this->text}

See all comments here:
{$comments_url}

-- 
Emeraldion Lodge
http://www.emeraldion.it

EOT;
		}
	}

?>