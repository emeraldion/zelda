<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/dateable.php");
	
	/**
	 *	@class Visit
	 *	@short Model class that represents individual visits (i.e. page requests).
	 */
	class Visit extends ActiveRecord implements Dateable
	{
		/**
		 *	@attr row
		 *	@short Binary row identifier used for class name assignment.
		 */
		static $row = 1;
		
		protected function init($values)
		{
			if (empty($values))
			{
				$this->ip_addr = @$_SERVER['REMOTE_ADDR'];
				$this->user_agent = @$_SERVER['HTTP_USER_AGENT'];
				$this->referrer = @$_SERVER['HTTP_REFERER'];
				$this->gate = @$_SERVER['REQUEST_URI'];
				$this->date = date("Y-m-d H:i:s");
				$this->params = var_export($_REQUEST, true);
			}
		}
		
		/**
		 *	@fn classname
		 *	@short Returns an alternate CSS style class to be used in lists.
		 */
		public function classname()
		{
			self::$row = 1 - self::$row;
			return 'row' . self::$row;
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