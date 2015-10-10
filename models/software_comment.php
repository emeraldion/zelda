<?php
	require_once(dirname(__FILE__) . "/abstract_comment.php");
	
	/**
	 *	@class SoftwareComment
	 *	@short Model class for comments to software products.
	 */
	class SoftwareComment extends AbstractComment
	{
		/**
		 *	@const SOFTWARE_COMMENT_MODERATE_URL
		 *	@abstract URL format for comment moderation.
		 */
		const SOFTWARE_COMMENT_MODERATE_URL = "http://%s%sbackend/software_comment_moderate/%s";

		/**
		 *	@const SOFTWARE_COMMENT_DISCARD_URL
		 *	@abstract URL format for comment disposal.
		 */
		const SOFTWARE_COMMENT_DISCARD_URL = "http://%s%sbackend/software_comment_discard/%s";

		public function permalink($relative = TRUE)
		{
			if ($this->software)
			{
				return $this->software->comments_permalink() .
					'?show_all=1' .
					parent::permalink();
			}
		}

		/**
		 *	@fn moderate_url
		 *	@abstract Returns the URL to moderate this comment.
		 */		
		public function moderate_url()
		{
			return sprintf(self::SOFTWARE_COMMENT_MODERATE_URL,
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
			return sprintf(self::SOFTWARE_COMMENT_DISCARD_URL,
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->id);
		}
	}
?>