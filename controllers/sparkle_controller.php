<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../models/software.php");
	require_once(dirname(__FILE__) . "/../models/software_release.php");
	require_once(dirname(__FILE__) . "/../models/software_artifact.php");

	/**
	 *	@class SparkleController
	 *	@short Controller for Sparkle feeds.
	 *	@details Sparkle (http://sparkle.andymatuschak.org) is a widely adopted
	 *	application update tracking framework for Mac OS X.
	 */
	class SparkleController extends EmeController
	{
		/**
		 *	@attr mimetype
		 *	@short The MIME type for the response.
		 */
		protected $mimetype = 'text/xml; charset=utf-8';

		function init()
		{
			// Call parent's init method
			parent::init();

			$this->caches_page(array('index'));
			//$this->before_filter(array('log_visit', 'block_ip'));
			$this->after_filter('compress');
		}

		function index()
		{
			$conn = Db::get_connection();

			if (isset($_GET['software_name']))
			{
				$software_factory = new Software();
				$softwares = $software_factory->find_all(array('where_clause' => "`name` = '{$conn->escape($_GET['software_name'])}' AND (`name` != 'guidatv' OR `type` = 'macosx')",
					'limit' => 1));
				if (count($softwares) > 0)
				{
					$this->software = $softwares[0];
					$this->software->has_many('software_releases');
					// Sort releases
					$releases = $this->software->software_releases;
					usort($releases, array($releases[0], 'sort_releases'));
					$this->software->release = $releases[0];
					$this->software->release->has_many('software_artifacts');

					// Horrible hack to enable per-software caching.
					$_REQUEST['id'] = $this->software->id;
				}
			}
			else if (isset($_GET['id']))
			{
				$this->software = new Software();
				$this->software->find_by_id($_GET['id']);
				$this->software->has_many('software_releases');
				// Sort releases
				$releases = $this->software->software_releases;

				usort($releases, array($releases[0], 'sort_releases'));
				$this->software->release = $releases[0];
				$this->software->release->has_many('software_artifacts');
			}
			else
			{
				$this->render_error();
			}
			
			Db::close_connection($conn);
		}
	}
?>
