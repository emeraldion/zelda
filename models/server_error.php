<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/dateable.php");

	/**
	 *	@class ServerError
	 *	@short Model class for server errors.
	 */
	class ServerError extends ActiveRecord implements Dateable
	{
		/**
		 *	@fn human_readable_date
		 *	@short Returns a human readable date for the creation date of the receiver.
		 */
		public function human_readable_date()
		{
			return strftime("%A %e %B %Y %H:%M:%S", strtotime($this->occurred_at));
		}
		
		/**
		 *	@fn rfc2822_date
		 *	@short Returns a RFC2822 formatted date for the creation date of the receiver, useful for feeds.
		 */
		public function rfc2822_date()
		{
			return date('r', strtotime($this->occurred_at));
		}
		
		/**
		 *	@fn iso8601_date
		 *	@short Returns a ISO8601 formatted date for the creation date of the receiver, useful for  feeds.
		 */
		public function iso8601_date()
		{
			return date('c', strtotime($this->occurred_at));
		}
	}
?>