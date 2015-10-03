<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/dateable.php");
	
	/**
	 *	@class SoftwareRelease
	 *	@short Model class for software release objects.
	 */
	class SoftwareRelease extends ActiveRecord implements Dateable
	{		
		protected $foreign_key_name = 'release_id';

		/**
		 *	@fn sort_releases
		 *	@short Static function used to compare releases
		 */
		public static function sort_releases($a, $b)
		{
			return (strtotime($a->date) > strtotime($b->date)) ? -1 : 1;
		}

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