<?php
	require_once(dirname(__FILE__) . "/abstract_comment.php");
	
	/**
	 *	@class DiarioComment
	 *	@short Model object for comments to diario blog articles.
	 */
	class DiarioComment extends AbstractComment
	{
		/**
		 *	@const DIARIO_COMMENT_MODERATE_URL
		 *	@abstract URL format for comment moderation.
		 */
		const DIARIO_COMMENT_MODERATE_URL = "http://%s%sbackend/diario_comment_moderate/%s";

		/**
		 *	@const DIARIO_COMMENT_DISCARD_URL
		 *	@abstract URL format for comment disposal.
		 */
		const DIARIO_COMMENT_DISCARD_URL = "http://%s%sbackend/diario_comment_discard/%s";

		public function relative_url()
		{
			if ($this->diario_post)
			{
				return substr($this->diario_post->permalink(TRUE), 1) .
					parent::relative_url();
			}
		}
		
		/**
		 *	@fn moderate_url
		 *	@abstract Returns the URL to moderate this comment.
		 */		
		public function moderate_url()
		{
			return sprintf(self::DIARIO_COMMENT_MODERATE_URL,
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->id);
		}

		/**
		 *	@fn discard_url
		 *	@abstract Returns the URL to discard this comment.
		 */		
		public function discard_url()
		{
			return sprintf(self::DIARIO_COMMENT_DISCARD_URL,
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->id);
		}
	}
?>