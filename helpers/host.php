<?php
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../models/blocked_ip.php");

	/**
	 *	@class Host
	 *	@short Helper object for representing network hosts.
	 */
	class Host
	{
		/**
		 *	@attr ip_addr
		 *	@short The IP address of the host.
		 */
		public $ip_addr;
		
		/**
		 *	@attr real_ip_addr
		 *	@short The real IP address of the host.
		 *	@details This variable contains the real IP address as inferred by the server parameters.
		 */
		public $real_ip_addr;
		
		/**
		 *	@attr hostname
		 *	@short The name of the host.
		 */
		public $hostname;

		/**
		 *	@fn by_ip_addr($ip_addr, $params)
		 *	@short Creates a Host object for the given IP address.
		 *	@param ip_addr The IP address.
		 *	@param params Parameters to initialize the receiver.
		 */
		public static function by_ip_addr($ip_addr, $params = NULL)
		{
			$host = new self();
			$host->ip_addr = $ip_addr;
			$host->real_ip_addr = self::real_ip_addr_from_params($ip_addr, $params);
			$host->hostname = self::lookup_host_and_cache($host->real_ip_addr);
			//$host->blocked = BlockedIp::is_blocked($host->real_ip_addr);
			
			return $host;
		}
		
		/**
		 *	@fn real_ip_addr_from_params($ip_addr, $params)
		 *	@short Obtains the real IP address using server parameters as a backup.
		 *	@details If the IP address is private, server parameters are used to obtain the real public IP address.
		 *	@param ip_addr The IP address.
		 *	@param params Parameters to initialize the receiver.
		 */
		private static function real_ip_addr_from_params($ip_addr, $params = NULL)
		{
			if ($ip_addr == "unknown" ||
				preg_match("/^10\./", $ip_addr) || // 10.0.0.0 -> 10.255.255.255
				preg_match("/^192\.168\./", $ip_addr) || // 192.168.0.0 -> 192.168.255.255
				preg_match("/^172\.(1[6-9]|2[0-9]|31)\./", $ip_addr)) // 172.16.0.0 => 172.31.255.255
			{
				if (!empty($params))
				{
					eval("\$params = $params;");
					if (isset($params["Apache"]))
					{
						preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/",
							$params["Apache"],
							$matches);
						if ($matches)
						{
							return $matches[0];
						}
					}
				}
			}
			return $ip_addr;
		}
		
		/**
		 *	@fn lookup_host_and_cache($ip_addr)
		 *	@short Obtains the hostname for the given IP address.
		 *	@param ip_addr The IP address.
		 */
		private static function lookup_host_and_cache($ip_addr)
		{
			global $db;
			
			$hostname = $ip_addr;

			// Attempt to retrieve the hostname from the lookup table...
			$db->prepare("SELECT `hostname` " .
				"FROM `hosts` " .
				"WHERE `ip_addr` = '{1}' " .
				"LIMIT 1",
				$ip_addr);
			$lookup_result = $db->exec();
			if ($db->num_rows() > 0)
			{
				// Got it
				$hostname = $db->result(0);
			}
			else
			{
				// Resolve the host name with a call to gethostbyaddr
				$hostname = gethostbyaddr($ip_addr);
				// Store it in the lookup table for later
				$db->prepare("INSERT INTO `hosts` (`ip_addr`,`hostname`,`last_update`) " .
					"VALUES ('{1}', '{2}', NOW())",
					$ip_addr,
					$hostname);
				$db->exec();
			}

			return $hostname;
		}
	}

?>