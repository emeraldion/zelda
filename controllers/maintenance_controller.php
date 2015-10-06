<?php
	require_once('eme_controller.php');
	require_once(dirname(__FILE__) . '/../include/db.inc.php');
	require_once(dirname(__FILE__) . '/../models/software.php');
	require_once(dirname(__FILE__) . '/../models/macupdate_entry.php');
	require_once(dirname(__FILE__) . '/../models/version_tracker_entry.php');
	require_once(dirname(__FILE__) . '/../helpers/MURatingsParser.php');
	require_once(dirname(__FILE__) . '/../helpers/VTRatingsParser.php');

	/**
	 *	@class MaintenanceController
	 *	@short Controller for maintenance tasks.
	 */
	class MaintenanceController extends EmeController
	{
		/**
		 *	@fn kill_claudio
		 *	@short Action method to remove claudio's evidence from the DB.
		 */
		public function kill_claudio()
		{
			$conn = Db::get_connection();

			$conn->prepare('DELETE FROM `visits` ' .
				'WHERE `params` LIKE "%\'_u\' => \'claudio\'%" ' .
				'OR `params` LIKE "%\'email\' => \'claudio@emeraldion.it\'%"');
			$conn->exec();

			$conn->prepare('OPTIMIZE TABLE `visits`');
			$conn->exec();

			$this->render(NULL);

			Db::close_connection($conn);
		}

		/**
		 *	@fn update_macupdate_ratings
		 *	@short Action method that updates the MacUpdate ratings for software products.
		 */
		public function update_macupdate_ratings()
		{
			$conn = Db::get_connection();

			error_reporting(E_ALL | E_STRICT);

			// assume the definition of $theParser (a MURatingsParser object) as in the listing above
			$RSS_PATH = 'http://www.macupdate.com/rss/ratings.php?id=2184:4f54cfceed571943d59ac7a951fc19e0';
			// create the object, including the path to your RSS file
			$theParser = new MURatingsParser($RSS_PATH);
			// this may also be done in two steps, omitting the constructer argument:
			// $theParser = new MURatingsParser();
			// $theParser->file = $RSS_PATH;

			// process the RSS file specified above (when the object was created)
			$theParser->parseFile();

			// get all the items from $theParser
			$itemList = $theParser->ratingsList();

			$mu_factory = new MacupdateEntry();
			foreach ($itemList as $item)
			{
				$results = $mu_factory->find_all(array('where_clause' => '`mu_title` = \'' . $conn->escape($item['title']) . '\''));
				if (count($results) > 0)
				{
					$mu_entry = $results[0];
					$mu_entry->rating = $item['description'];
					$mu_entry->url = $item['link'];
					$mu_entry->save();
				}
			}
			$this->render(NULL);

			Db::close_connection($conn);
		}

		/**
		 *	@fn update_mu_ratings
		 *	@short Shorthand for MaintenanceController::update_macupdate_ratings().
		 */
		public function update_mu_ratings()
		{
			$this->update_macupdate_ratings();
		}

		/**
		 *	@fn update_versiontracker_ratings
		 *	@short Action method that updates the VersionTracker ratings for software products.
		 */
		public function update_versiontracker_ratings()
		{
			$conn = Db::get_connection();

			error_reporting(E_ALL | E_STRICT);

			$sw = new Software();
			$softwares = $sw->find_all();

			foreach ($softwares as $software)
			{
				$software->has_one('version_tracker_entries');

				if ($software->version_tracker_entry &&
					$software->version_tracker_entry->vt_id != 0)
				{
					$vt = new VTRatingsParser($software->version_tracker_entry->vt_id);
					$vt->parse();

					$software->version_tracker_entry->rating = $vt->rating;
					$software->version_tracker_entry->save();
				}
			}
			$this->render(NULL);

			Db::close_connection($conn);
		}

		/**
		 *	@fn update_vt_ratings
		 *	@short Shorthand for MaintenanceController::update_versiontracker_ratings().
		 */
		public function update_vt_ratings()
		{
			$this->update_versiontracker_ratings();
		}
	}
?>
