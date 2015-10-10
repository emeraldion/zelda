<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/dateable.php");
	
	/**
	 *	@class Download
	 *	@short Model object for generic downloads.
	 */
	class Download extends ActiveRecord implements Dateable
	{
		/**
		 *	@fn rfc2822_date
		 *	@short Returns a RFC2822 formatted date for the date of the receiver, useful for feeds.
		 */
		public function rfc2822_date()
		{
			return date('r', strtotime($this->date));
		}

		/**
		 *	@fn iso8601_date
		 *	@short Returns a ISO8601 formatted date for the date of the receiver, useful for  feeds.
		 */
		public function iso8601_date()
		{
			return date('c', strtotime($this->date));
		}

		/**
		 *	@fn human_readable_date
		 *	@short Returns a human readable date for the date of the receiver.
		 */
		public function human_readable_date()
		{
			return strftime("%A %e %B %Y %H:%M:%S", strtotime($this->date));
		}
	}
?>