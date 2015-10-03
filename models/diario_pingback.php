<?php
	require_once(dirname(__FILE__) . "/abstract_comment.php");
	
	/**
	 *	@class DiarioPingback
	 *	@short Model class for pingbacks to Diario articles.
	 */
	class DiarioPingback extends AbstractComment
	{
		protected function init($values)
		{
			$this->created_at = date("Y-m-d H:i:s");
		}
		
		/**
		 *	@fn comment_class
		 *	@short Provides a class name that depends on the status of the comment, useful for lists.
		 */
		public function comment_class()
		{
			static $row = 0;
			$row = 1 - $row;
			return $row ? "comment-even" : "comment-odd";
		}
		
		public function relative_url()
		{
			if ($this->diario_post)
			{
				return $this->diario_post->permalink(TRUE) .
					"#pingback-{$this->id}";
			}
		}
		
		/**
		 *	@fn pretty_excerpt
		 *	@short Provides an excerpt for pingbacks.
		 */
		public function pretty_excerpt()
		{
			return "[...] {$this->excerpt} [...]";
		}
	}
?>