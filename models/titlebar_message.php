<?php
	require_once(dirname(__FILE__) . "/base.php");
	
	/**
	 *	@class TitlebarMessage
	 *	@short Model class for messages on the title bar.
	 */
	class TitlebarMessage extends ActiveRecord
	{
		/**
		 *	@fn latest
		 *	@short Returns the latest titlebar message.
		 */
		static function latest()
		{
			$message_factory = new self();
			$messages = $message_factory->find_by_query('SELECT * ' .
					'FROM `titlebar_messages` ' .
					'ORDER BY `created_at` DESC ' .
					'LIMIT 1');
					
			return $messages[0];
		}
	}
?>