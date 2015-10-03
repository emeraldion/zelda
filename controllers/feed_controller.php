<?php
	require_once('eme_controller.php');
	require_once(dirname(__FILE__) . '/../models/software.php');
	require_once(dirname(__FILE__) . '/../models/software_release.php');
	require_once(dirname(__FILE__) . '/../models/software_artifact.php');
	require_once(dirname(__FILE__) . '/../models/software_comment.php');
	require_once(dirname(__FILE__) . '/../models/diario_post.php');
	require_once(dirname(__FILE__) . '/../models/diario_comment.php');

	/**
	 *	@class FeedController
	 *	@short Controller for RSS and Atom feeds generation.
	 */
	class FeedController extends EmeController
	{
		protected $mimetype = 'text/xml; charset=utf-8';
		protected $type = 'rss';
		
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$cached_pages = array('software', 'software_comments', 'diario');
			//$this->before_filter(array('log_visit', 'block_ip'));
			$this->before_filter('block_ip');
			$this->caches_page($cached_pages);
			$this->after_filter('compress', array('only' => $cached_pages));
		}
		
		/**
		 *	@fn software
		 *	@short Action method that generates the feed of software releases.
		 */
		public function software()
		{
			global $db;
			
			$release_factory = new SoftwareRelease();
			if (isset($_GET['id']) && is_numeric($_GET['id']))
			{
				$this->releases = $release_factory->find_all(array('where_clause' => '`released` = 1 ' .
					'AND `software_id` = \'' . $db->escape($_GET['id']) . '\' ',
					'order_by' => '`date` DESC '));
			}
			else
			{
				$this->releases = $release_factory->find_by_query('SELECT MAX(`software_releases`.`id`) AS `id`, `software_releases`.`software_id`, MAX(`software_releases`.`version`) AS `version`, MAX(`software_releases`.`date`) AS `date` ' .
					'FROM `softwares` ' .
					'LEFT JOIN `software_releases` ON `softwares`.`id` = `software_releases`.`software_id` ' .
					'WHERE `software_releases`.`released` = 1 ' .
					'GROUP BY `softwares`.`id` ' .
					'ORDER BY `date` DESC ');
			}
		}

		/**
		 *	@fn software_comments
		 *	@short Action method that generates the feed of software comments.
		 */
		public function software_comments()
		{
			$this->software = new Software();
			$this->software->find_by_id($_REQUEST['id']);
			$this->software->has_many('software_comments', array('where_clause' => '`approved` = 1'));
			$this->comments = $this->software->software_comments;
		}

		/**
		 *	@fn diario
		 *	@short Action method that generates the feed of Diario articles.
		 */		
		public function diario()
		{
			$post_factory = new DiarioPost();
			$this->posts = $post_factory->find_by_query('SELECT * ' .
				'FROM `diario_posts` ' .
				'WHERE `status` = \'pubblicato\' ' .
				'ORDER BY `created_at` DESC ' .
				'LIMIT 10');
		}

		/**
		 *	@fn diario_comments
		 *	@short Action method that generates the feed of Diario comments.
		 */
		public function diario_comments()
		{
			$this->article = new DiarioPost();
			$this->article->find_by_id($_REQUEST['id']);
			$this->article->has_many('diario_comments', array('where_clause' => '`approved` = 1'));
			$this->comments = $this->article->diario_comments;
		}

		/**
		 *	@fn feeds_list
		 *	@short Action method that generates a list of available feeds.
		 */	
		public function feeds_list()
		{
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn feed_permalink
		 *	@short Returns the permalink URL for the current feed.
		 */		
		public function feed_permalink()
		{
			return sprintf('http://%s%s',
				$_SERVER['HTTP_HOST'],
				$this->url_to_myself());
		}
	}
?>