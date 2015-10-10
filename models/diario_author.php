<?php
	require_once(dirname(__FILE__) . "/user.php");
	
	/**
	 *	@class DiarioAuthor
	 *	@short Model object for blog posts authors.
	 */
	class DiarioAuthor extends User
	{
		protected $table_name = 'users';
		protected $foreign_key_name = 'author';
		protected $primary_key = 'username';
		
		/**
		 *	@fn relative_url
		 *	@short Relative URL for the receiver.
		 */
		public function relative_url()
		{
			return sprintf("about/%s.html",
				$this->username);
		}
	}
?>