<?php
	require_once(dirname(__FILE__) . "/base.php");
	
	/**
	 *	@class Outbound
	 *	@short Model class for clicks to external URLs on the pages of website.
	 *	@details Objects of class Outbound model the event of a click on an external URL
	 *	from a hyperlink located in the pages of the website.
	 *	Those events are logged to database for statistical purposes.
	 */
	class Outbound extends ActiveRecord implements Dateable
	{
		protected function init($values = NULL)
		{
			if (!isset($this->occurred_at))
			{
				$this->occurred_at = date("Y-m-d H:i:s");
			}
		}
		
		/**
		 *	@fn human_readable_date
		 *	@short Returns a human readable date for the occurrence date of the receiver.
		 */
		public function human_readable_date()
		{
			return strftime("%A %e %B %Y %H:%M:%S", strtotime($this->occurred_at));
		}
		
		/**
		 *	@fn rfc2822_date
		 *	@short Returns a RFC2822 formatted date for the occurrence date of the receiver, useful for feeds.
		 */
		public function rfc2822_date()
		{
			return date('r', strtotime($this->occurred_at));
		}
		
		/**
		 *	@fn iso8601_date
		 *	@short Returns a ISO8601 formatted date for the occurrence date of the receiver, useful for  feeds.
		 */
		public function iso8601_date()
		{
			return date('c', strtotime($this->occurred_at));
		}
	}
?>