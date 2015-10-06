<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../helpers/host.php");
	require_once(dirname(__FILE__) . "/../helpers/query.php");
	require_once(dirname(__FILE__) . "/../helpers/time.php");
	require_once(dirname(__FILE__) . "/../helpers/gate.php");
	require_once(dirname(__FILE__) . "/../models/visit.php");
	require_once(dirname(__FILE__) . "/../models/person.php");
	require_once(dirname(__FILE__) . "/../models/outbound.php");
	require_once(dirname(__FILE__) . "/../models/blocked_ip.php");

	/**
	 *	@class MetaController
	 *	@short Controller for the Meta section.
	 *	@details Meta refers to all those diagnostic and introspectional functions
	 *	that allow visit monitoring, traffic shaping etc.
	 */
	class MetaController extends EmeController
	{
		/**
		 *	@fn init
		 *	@short Initialization method for the Controller.
		 *	@details Here you can define custom filters, caching strategies etc.
		 */
		protected function init()
		{
			// Call parent's init method
			parent::init();

			$this->before_filter('check_auth');
			$this->after_filter('compress');
		}

		/**
		 *	@fn index
		 *	@short Default action method.
		 *	@details This method handles the default action.
		 */
		public function index()
		{
			$this->redirect_to(array('action' => 'queries'));
		}

		/**
		 *	@fn referrers
		 *	@short Action method that shows the referrer URLs of the visits.
		 *	@details By analyzing referrers, you can easily understand what websites
		 *	contain links to your website.
		 */
		public function referrers()
		{
		}

		/**
		 *	@fn referrers_list
		 *	@short Action method that builds the list of referrers.
		 *	@details This method is invoked with AJAX calls to update the list
		 *	of referrers in a dynamic fashion.
		 */
		public function referrers_list()
		{
			$conn = Db::get_connection();

			if (isset($_REQUEST['g']) && !empty($_REQUEST['g']))
			{
				$conn->prepare("SELECT `referrer`, COUNT(`referrer`) AS `count` " .
						"FROM `visits` " .
						"WHERE (`referrer` NOT LIKE 'http://{1}%' " .
							"AND `referrer` LIKE '%{2}%' " .
							"AND `referrer` != '') " .
						"GROUP BY `referrer` " .
						"ORDER BY `count` DESC " .
						"LIMIT {3}",
						$_SERVER['HTTP_HOST'],
						isset($_REQUEST['f']) ? $_REQUEST['f'] : '',
						isset($_REQUEST['l']) && is_numeric($_REQUEST['l']) ? $_REQUEST['l'] : 50);
			}
			else
			{
				$conn->prepare("SELECT DISTINCT `id`, `date`, `referrer` " .
						"FROM `visits` " .
						"WHERE (`referrer` NOT LIKE 'http://{1}%' " .
							"AND `referrer` LIKE '%{2}%' " .
							"AND `referrer` != '') " .
						"ORDER BY `date` DESC " .
						"LIMIT {3}",
						$_SERVER['HTTP_HOST'],
						isset($_REQUEST['f']) ? $_REQUEST['f'] : '',
						isset($_REQUEST['l']) && is_numeric($_REQUEST['l']) ? $_REQUEST['l'] : 50);
			}
			$conn->exec();

			$this->referrers = array();
			if ($conn->num_rows() > 0)
			{
				while ($referrer = $conn->fetch_assoc())
				{
					$this->referrers[] = $referrer;
				}
			}
			$conn->free_result();
			Db::close_connection($conn);
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn visits
		 *	@short Action method that shows the last visits.
		 */
		public function visits()
		{
		}

		/**
		 *	@fn visits_list
		 *	@short Action method that builds the list of visits.
		 *	@details This method is invoked with AJAX calls to update the list
		 *	of visits in a dynamic fashion.
		 */
		public function visits_list()
		{
			$conn = Db::get_connection();

			$conn->prepare("SELECT * " .
					"FROM `visits` " .
					"WHERE (`ip_addr` LIKE '%{1}%' " .
						"OR `gate` LIKE '%{1}%' " .
						"OR `referrer` LIKE '%{1}%' " .
						"OR `user_agent` LIKE '%{1}%') " .
					"ORDER BY `date` DESC " .
					"LIMIT {2}, {3}",
					isset($_REQUEST['f']) ? $_REQUEST['f'] : '',
					isset($_REQUEST['s']) && is_numeric($_REQUEST['s']) ? $_REQUEST['s'] : 0,
					isset($_REQUEST['l']) && is_numeric($_REQUEST['l']) ? $_REQUEST['l'] : 50);
			$conn->exec();

			$this->visits = array();
			if ($conn->num_rows() > 0)
			{
				while ($item = $conn->fetch_assoc())
				{
					$this->visits[] = new Visit($item);
				}
			}
			$conn->free_result();
			Db::close_connection($conn);
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn queries
		 *	@short Action method that shows the queries that brought visitors on the website.
		 *	@details By analyzing queries, you can easily understand what keywords lead visitors
		 *	to your website.
		 */
		public function queries()
		{
		}

		/**
		 *	@fn queries_list
		 *	@short Action method that builds the list of queries.
		 *	@details This method is invoked with AJAX calls to update the list
		 *	of queries in a dynamic fashion.
		 */
		public function queries_list()
		{
			$conn = Db::get_connection();

			if (isset($_REQUEST['g']) && $_REQUEST['g'] == 'true')
			{
				$conn->prepare("SELECT `referrer`, COUNT(`referrer`) AS `count` " .
						"FROM `visits` " .
						"WHERE (`referrer` LIKE 'http://www.google%q=%' " .
							"OR `referrer` LIKE 'http://%yahoo.com%p=%' " .
							"OR `referrer` LIKE 'http://search.live.com/results.aspx?q=%') " .
						"AND `referrer` LIKE '%{1}%' " .
						"GROUP BY `referrer` " .
						"ORDER BY `count` DESC " .
						"LIMIT {2}, {3}",
						isset($_REQUEST['q']) ? $_REQUEST['q'] : '',
						isset($_REQUEST['s']) && is_numeric($_REQUEST['s']) ? $_REQUEST['s'] : 0,
						isset($_REQUEST['l']) && is_numeric($_REQUEST['l']) ? $_REQUEST['l'] : 50);
			}
			else
			{
				$conn->prepare("SELECT `id`, `date`, `referrer` " .
						"FROM `visits` " .
						"WHERE (`referrer` LIKE 'http://www.google%q=%' " .
							"OR `referrer` LIKE 'http://%yahoo.com%p=%' " .
							"OR `referrer` LIKE 'http://search.live.com/results.aspx?q=%') " .
						"AND `referrer` LIKE '%{1}%' " .
						"ORDER BY `date` DESC " .
						"LIMIT {2}, {3}",
						isset($_REQUEST['q']) ? $_REQUEST['q'] : '',
						isset($_REQUEST['s']) && is_numeric($_REQUEST['s']) ? $_REQUEST['s'] : 0,
						isset($_REQUEST['l']) && is_numeric($_REQUEST['l']) ? $_REQUEST['l'] : 50);
			}
			$conn->exec();

			$this->queries = array();
			if ($conn->num_rows() > 0)
			{
				while ($search = $conn->fetch_assoc())
				{
					preg_match("/(\&|\?)(p|q|as_q)=([^\&]+)/", $search['referrer'], $matches);
					$term = utf8_decode(urldecode($matches[3]));
					if (!empty($_REQUEST["q"]) && stristr($term, $_REQUEST["q"]) === FALSE)
					{
						continue;
					}
					$this->queries[] = new Query(array_merge(array('term' => $term), $search));
				}
			}
			$conn->free_result();
			Db::close_connection($conn);
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn outbounds
		 *	@short Action method that shows the outbound links that have been followed on the website.
		 */
		public function outbounds()
		{
		}

		/**
		 *	@fn outbounds_list
		 *	@short Action method that builds the list of outbounds.
		 *	@details This method is invoked with AJAX calls to update the list
		 *	of queries in a dynamic fashion.
		 */
		public function outbounds_list()
		{
			$conn = Db::get_connection();

			if (isset($_REQUEST['g']))
			{
				$conn->prepare("SELECT `url`, COUNT(`url`) AS `count` " .
						"FROM `outbounds` " .
						"WHERE `url` LIKE '%{1}%' " .
						"GROUP BY `url` " .
						"ORDER BY `count` DESC " .
						"LIMIT {2}, {3}",
						isset($_REQUEST['f']) ? $_REQUEST['f'] : '',
						isset($_REQUEST['s']) && is_numeric($_REQUEST['s']) ? $_REQUEST['s'] : 0,
						isset($_REQUEST['l']) && is_numeric($_REQUEST['l']) ? $_REQUEST['l'] : 50);
			}
			else
			{
				$conn->prepare("SELECT `id`, `occurred_at`, `url` " .
						"FROM `outbounds` " .
						"WHERE `url` LIKE '%{1}%' " .
						"ORDER BY `occurred_at` DESC " .
						"LIMIT {2}, {3}",
						isset($_REQUEST['f']) ? $_REQUEST['f'] : '',
						isset($_REQUEST['s']) && is_numeric($_REQUEST['s']) ? $_REQUEST['s'] : 0,
						isset($_REQUEST['l']) && is_numeric($_REQUEST['l']) ? $_REQUEST['l'] : 50);
			}
			$conn->exec();

			$this->outbounds = array();
			if ($conn->num_rows() > 0)
			{
				while ($item = $conn->fetch_assoc())
				{
					$out = new Outbound($item);
					if (isset($item['count']))
					{
						$out->count = $item['count'];
					}
					$this->outbounds[] = $out;
				}
			}
			$conn->free_result();
			Db::close_connection($conn);
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn hits_by_host
		 *	@short Action method that shows the list of visitors' hosts.
		 *	@details By analyzing visitors' hosts, you can easily understand who visited your website.
		 */
		public function hits_by_host()
		{
		}

		/**
		 *	@fn hits_by_host_list
		 *	@short Action method that builds the list of hits by host.
		 *	@details This method is invoked with AJAX calls to update the list
		 *	of hits by host in a dynamic fashion.
		 */
		public function hits_by_host_list()
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
					$host = Host::by_ip_addr($line['ip_addr'], $line['params']);
					$host->weight = $line['weight'];
					$this->hosts[] = $host;
				}
			}
			$conn->free_result();
			Db::close_connection($conn);
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn ip
		 *	@short Action method that returns all visits made from an IP address.
		 */
		public function ip()
		{
			$visit_factory = new Visit();
			$this->visits = $visit_factory->find_by_query('SELECT * ' .
				'FROM `visits` ' .
				"WHERE `ip_addr` = '{$_REQUEST['ip']}' " .
				'ORDER BY `date` DESC');
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn unblock_ip
		 *	@short Action method to remove an IP address from the black list.
		 */
		public function unblock_ip()
		{
			if (isset($_GET['id']))
			{
				$blocked_ip = new BlockedIp();
				$blocked_ip->find_by_id($_GET['id']);
				$blocked_ip->delete();
				die(l('IP address unblocked.'));
			}
			die(l('You must provide an id in order to unblock an IP address.'));
		}

		/**
		 *	@fn block_ip
		 *	@short Action method to add an IP address to the black list.
		 */
		public function block_ip()
		{
			$blocked_ip = new BlockedIp();
			$blocked_ip->ip_addr = $_REQUEST['ip'];
			$blocked_ip->save();
			die(sprintf(l('IP address %s correctly blocked.'), $_REQUEST['ip']));
		}

		/**
		 *	@fn blocked_ips
		 *	@short Action method to list the blacklisted IP addresses.
		 */
		public function blocked_ips()
		{
		}

		/**
		 *	@fn blocked_ips_list
		 *	@short Action method that creates a list of the blacklisted IP addresses.
		 *	@details This method is invoked with AJAX calls to update the list
		 *	of blocked IPs in a dynamic fashion.
		 */
		public function blocked_ips_list()
		{
			$conn = Db::get_connection();

			$bip_factory = new BlockedIp();
			$this->blocked_ips = $bip_factory->find_all(array(
				'where_clause' => "`ip_addr` LIKE '%{$conn->escape(@$_REQUEST['q'])}%'",
				'order_by' => '`blocked_at` DESC'));

			Db::close_connection($conn);

			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn id
		 *	@short Action method to get a single visit by its id.
		 */
		public function id()
		{
			$this->visit = new Visit();
			$this->visit->find_by_id($_REQUEST['id']);
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn attribute_chooser
		 *	@short Action method to get an attribute chooser.
		 *	@details This method is designed to be called as an AJAX update. It provides a select box control
		 *	to choose a person whom attribute something to.
		 */
		public function attribute_chooser()
		{
			$person_factory = new Person();
			$this->people = $person_factory->find_all();
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn attribute_visits
		 *	@short Action method to attribute a visit to a person.
		 *	@details This method is designed to be called with AJAX, and does not render anything.
		 *	It assigns a visit object to a person object.
		 */
		public function attribute_visits()
		{
			$conn = Db::get_connection();

			$visit_factory = new Visit();
			$visits = $visit_factory->find_all(array('where_clause' => "`date` >= '{$conn->escape(date("Y-m-d H:i:s", Time::ago(@$_REQUEST['t'])))}' " .
					"AND (`ip_addr` = '{$conn->escape(@$_REQUEST['ip'])}' " .
					"OR `params` LIKE '%Apache'' => ''{$conn->escape(@$_REQUEST['ip'])}%')"));
			if (count($visits) > 0)
			{
				foreach ($visits as $visit)
				{
					$visit->person_id = @$_REQUEST['person_id'];
					$visit->save();
				}
			}

			Db::close_connection($conn);

			$this->render(NULL);
		}
	}
?>
