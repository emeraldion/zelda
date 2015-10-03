<?php
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/host.php");

	define("GEOIP_LOOKUP", "http://api.hostip.info/rough.php?ip=%s&position=true");

	/**
	 *	@class Geoip
	 *	@short Helper object for geolocation of IP addresses.
	 *	@details Geolocation information is obtained by querying the hostip.info web service.
	 */
	class Geoip extends Host
	{
		/**
		 *	@attr latitude
		 *	@short The value of the latitude coordinate.
		 */
		public $latitude;

		/**
		 *	@attr longitude
		 *	@short The value of the longitude coordinate.
		 */
		public $longitude;
		
		/**
		 *	@attr altitude
		 *	@short The value of the altitude on the level of sea.
		 */
		public $altitude = 0;
		
		/**
		 *	@attr country
		 *	@short The name of the country of the IP address.
		 */
		public $country;
		
		/**
		 *	@attr country_code
		 *	@short The country code of the IP address.
		 */
		public $country_code;
		
		/**
		 *	@attr city
		 *	@short The name of the city of the IP address.
		 */
		public $city;
		
		/**
		 *	@attr guessed
		 *	@short Tells whether the geographical location has been inferred or is a certain value.
		 *	@return <tt>TRUE</tt> if the geographical location has been guessed, <tt>FALSE</tt> otherwise.
		 */
		public $guessed;
		
		/**
		 *	@fn by_ip_addr($ip_addr, $params)
		 *	@short Creates a Geoip object for the given IP address.
		 *	@param ip_addr The IP address.
		 *	@param params Parameters to initialize the IP address.
		 */
		public static function by_ip_addr($ip_addr, $params = NULL)
		{
			// Get GEOIP data from web service
			$rough = file_get_contents(sprintf(GEOIP_LOOKUP, $ip_addr));
			
			// Split response in key-value lines
			$pairs = explode("\n", $rough);

			$geoip = parent::by_ip_addr($ip_addr, $params);
			$geoip->ip_addr = $ip_addr;
			$geoip->altitude = 0;
			foreach ($pairs as $pair)
			{
				// Create an element with given key-value association
				list($key, $value) = explode(":", $pair);
				$key = strtolower(str_replace(' ', '_', $key));
				$geoip->$key = trim($value);
			}

			return $geoip;
		}
	}
?>