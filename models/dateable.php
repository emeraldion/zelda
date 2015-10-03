<?php

	/**
	 *	@interface Dateable
	 *	@short Defines methods that are useful for objects that can be dated.
	 */
	interface Dateable
	{
		/**
		 *	@fn human_readable_date
		 *	@short Returns a formatted date, suitable to be read by humans.
		 */
		public function human_readable_date();

		/**
		 *	@fn rfc2822_date
		 *	@short Returns a RFC2822 formatted date for the creation date of the receiver, useful for  feeds.
		 */
		public function rfc2822_date();
		
		/**
		 *	@fn iso8601_date
		 *	@short Returns a ISO8601 formatted date for the creation date of the receiver, useful for  feeds.
		 */
		public function iso8601_date();
	}

?>