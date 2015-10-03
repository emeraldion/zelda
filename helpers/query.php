<?php
	require_once(dirname(__FILE__) . "/../models/dateable.php");
	
	/**
	 *	@class Query
	 *	@short Helper class that represents queries on search engines.
	 */
	class Query implements Dateable
	{
		/**
		 *	@attr id
		 *	@short Identifier of the query.
		 */
		public $id;
		
		/**
		 *	@attr date
		 *	@short Date when the query was executed.
		 */
		public $date;
		
		/**
		 *	@attr term
		 *	@short Term used in the query.
		 */
		public $term;
		
		/**
		 *	@attr count
		 *	@short Counter of unique queries that contain the same term.
		 *	@note This attribute is only used when considering grouped queries.
		 */
		public $count;
		
		/**
		 *	@fn Query($params)
		 *	@short Constructor of Query objects.
		 *	@param params Details to initialize the Query object.
		 */
		public function Query($params)
		{
			$vars = get_class_vars(get_class($this));
			foreach ($vars as $var_name => $var_value)
			{
				if (isset($params[$var_name]))
				{
					$this->$var_name = $params[$var_name];
				}
			}
		}
		
		/**
		 *	@fn human_readable_date
		 *	@short Returns a formatted date for the receiver, suitable to be read by humans.
		 */
		public function human_readable_date()
		{
			return strftime("%A %e %B %Y %H:%M:%S", strtotime($this->date));
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
	}
?>