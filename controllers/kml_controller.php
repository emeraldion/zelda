<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../helpers/host.php");
	require_once(dirname(__FILE__) . "/../helpers/geoip.php");
	require_once(dirname(__FILE__) . "/../helpers/time.php");

	/**
	 *	@class KmlController
	 *	@short Controller for the generation of KML Google Earth plugins.
	 */
	class KmlController extends EmeController
	{
		protected $mimetype = 'application/vnd.google-earth.kml+xml';

		/**
		 *	@fn init
		 *	@short Initialization method for the Controller.
		 *	@details Here you can define custom filters, caching strategies etc.
		 */
		protected function init()
		{
			// Call parent's init method
			parent::init();

			$this->after_filter('compress');
		}

		/**
		 *	@fn index
		 *	@short Default action method.
		 *	@details This method handles the default action.
		 */
		public function index()
		{
			$this->geoips = array(Geoip::by_ip_addr('147.163.1.5'),
				Geoip::by_ip_addr('194.242.202.173'));
		}

		/**
		 *	@fn hits_by_host
		 *	@short Action method that shows the list of hosts that have visited the website.
		 */
		public function hits_by_host()
		{
			$conn = Db::get_connection();

			$conn->prepare("SELECT `ip_addr`, `params`, COUNT(*) AS `weight` " .
					"FROM `visits` " .
					"WHERE `gate` LIKE '%{1}%' " .
					"AND `date` >= '{2}' " .
					"AND (`ip_addr` LIKE '%{3}%' " .
					"OR `params` LIKE '%Apache'' => ''%{3}%') " .
					"AND `referrer` LIKE '%{4}%' " .
					"AND `user_agent` LIKE '%{5}%' " .
					"GROUP BY CONCAT(`ip_addr`, `user_agent`) " .
					"HAVING `weight` >= '{6}' AND `weight` <= '{7}' " .
					"ORDER BY `weight` DESC " .
					"LIMIT {8}",
					@$_REQUEST['p'],
					date("Y-m-d H:i:s", Time::ago(@$_REQUEST['t'])),
					@$_REQUEST['f'],
					@$_REQUEST['r'],
					@$_REQUEST['u'],
					@$_REQUEST['l'],
					@$_REQUEST['h'],
					9999);
			$conn->exec();

			$this->hosts = array();
			if ($conn->num_rows() > 0)
			{
				while ($line = $conn->fetch_assoc())
				{
					$host = Geoip::by_ip_addr($line['ip_addr'], $line['params']);
					$host->weight = $line['weight'];
					$this->hosts[] = $host;
				}
			}

			Db::close_connection($conn);
		}

		/**
		 *	@fn last_5_visits
		 *	@short Action method that shows the last 5 hosts that have visited the website.
		 */
		public function last_5_visits()
		{
			$this->last_n_visits(5);
		}

		/**
		 *	@fn last_10_visits
		 *	@short Action method that shows the last 10 hosts that have visited the website.
		 */
		public function last_10_visits()
		{
			$this->last_n_visits(10);
		}

		/**
		 *	@fn last_50_visits
		 *	@short Action method that shows the last 50 hosts that have visited the website.
		 */
		public function last_50_visits()
		{
			$this->last_n_visits(50);
		}

		/**
		 *	@fn last_n_visits
		 *	@short Action method that shows the last <em>N</em> hosts that have visited the website.
		 */
		public function last_n_visits($n)
		{
			$conn = Db::get_connection();

			$conn->prepare("SELECT `ip_addr`, `params`, COUNT(*) AS `weight` " .
					"FROM `visits` " .
					"GROUP BY CONCAT(`ip_addr`, `user_agent`) " .
					"ORDER BY `date` DESC " .
					"LIMIT {1}",
					$n * 3);
			$conn->exec();

			$this->hosts = array();
			if ($conn->num_rows() > 0)
			{
				$i = 0;
				while ($line = $conn->fetch_assoc())
				{
					$host = Geoip::by_ip_addr($line['ip_addr'], $line['params']);
					$host->weight = $line['weight'];
					if (!(empty($host->latitude) && empty($host->longitude)))
					{
						$this->hosts[] = $host;
						$i++;
					}
					if ($i >= $n)
					{
						break;
					}
				}
			}
			Db::close_connection($conn);

			$this->render(array('action' => 'hits_by_host'));
		}
	}
?>
