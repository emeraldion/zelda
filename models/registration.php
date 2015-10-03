<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/dateable.php");
	require_once(dirname(__FILE__) . "/../helpers/license.php");
	
	/**
	 *	@class Registration
	 *	@short Model object for software registrations.
	 *	@details Object of class Registration represent the event of a user registering a software.
	 *	A license object for the user is automatically created and carried along.
	 */
	class Registration extends ActiveRecord implements Dateable
	{
		/**
		 *	@short A license linked to this registration.
		 */
		public $license;
		
		/**
		 *	@short A class name used for licenses.
		 */
		protected $license_class = 'License';
		
		protected function init($values)
		{
			$this->license = new $this->license_class($values['username'],
				$values['email']);
		}
		
		/**
		 *	@fn rfc2822_date
		 *	@short Returns a RFC2822 formatted date for the date of the receiver, useful for feeds.
		 */
		public function rfc2822_date()
		{
			return date('r', strtotime($this->registered_on));
		}

		/**
		 *	@fn iso8601_date
		 *	@short Returns a ISO8601 formatted date for the date of the receiver, useful for  feeds.
		 */
		public function iso8601_date()
		{
			return date('c', strtotime($this->registered_on));
		}

		/**
		 *	@fn human_readable_date
		 *	@short Returns a human readable date for the date of the receiver.
		 */
		public function human_readable_date()
		{
			return strftime("%A %e %B %Y %H:%M:%S", strtotime($this->registered_on));
		}
	}
?>