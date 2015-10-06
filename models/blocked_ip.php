<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/dateable.php");

	/**
	 *	@class BlockedIp
	 *	@short Model object for blacklisted IP addresses.
	 *	@details Blocked IPs are inhibited from accessing the website.
	 *	The blacklisted status is inflicted to spammers, leechers, bots and other
	 *	treacherous visitor classes.
	 */
	class BlockedIp extends ActiveRecord implements Dateable
	{
		protected function init($values)
		{
			if (!isset($this->blocked_at))
			{
				$this->blocked_at = date("Y-m-d H:i:s");
			}
		}

		/**
		 *	@fn rfc2822_date
		 *	@short Returns a RFC2822 formatted date for the date of the receiver, useful for feeds.
		 */
		public function rfc2822_date()
		{
			return date('r', strtotime($this->blocked_at));
		}

		/**
		 *	@fn iso8601_date
		 *	@short Returns a ISO8601 formatted date for the date of the receiver, useful for  feeds.
		 */
		public function iso8601_date()
		{
			return date('c', strtotime($this->blocked_at));
		}

		/**
		 *	@fn human_readable_date
		 *	@short Returns a human readable date for the date of the receiver.
		 */
		public function human_readable_date()
		{
			return strftime("%A %e %B %Y %H:%M:%S", strtotime($this->blocked_at));
		}

		/**
		 *	@fn is_blocked($ip_addr)
		 *	@short Returns <tt>TRUE</tt> if <tt>ip_addr</tt> is in the blacklist,
		 *	<tt>FALSE</tt> otherwise.
		 *	@param ip_addr The IP address to test.
		 */
		public static function is_blocked($ip_addr)
		{
			$conn = Db::get_connection();

			$bip_factory = new self();
			$ret = $bip_factory->find_all(array('where_clause' => "`ip_addr` = '{$conn->escape($ip_addr)}'"));

			Db::close_connection($conn);

			return count($ret) > 0;
		}
	}
?>
