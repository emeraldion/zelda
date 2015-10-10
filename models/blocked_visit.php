<?php
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/visit.php");

	/**
	 *	@class BlockedVisit
	 *	@short Model class that represents individual visits from blocked IP addresses.
	 *	@details You may wonder why having visits from blocked IPs logged at all?
	 *	We will use those to evaluate the 'conduct' of a blocked IP and eventually decide
	 *	to remove it from the blacklist.
	 */
	class BlockedVisit extends Visit
	{
		/**
		 *	@fn count_by_ip($the_ip)
		 *	@short Returns the count of blocked visits for the desired IP address.
		 *	@the_ip An IP address.
		 */
		public static function count_by_ip($the_ip)
		{
			$conn = Db::get_connection();

			$conn->prepare("SELECT COUNT(*) FROM `{1}` WHERE `ip_addr` = '{2}'",
				$this->get_table_name(),
				$the_ip);
			$conn->exec();
			$ret = $conn->result(0);
			Db::close_connection($conn);
			return $ret;
		}
	}
?>
