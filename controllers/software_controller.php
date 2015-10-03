<?php
	require_once('eme_controller.php');
	require_once(dirname(__FILE__) . '/../models/software.php');
	require_once(dirname(__FILE__) . '/../models/software_release.php');
	require_once(dirname(__FILE__) . '/../models/software_download.php');
	require_once(dirname(__FILE__) . '/../models/software_artifact.php');
	require_once(dirname(__FILE__) . '/../models/software_comment.php');
	require_once(dirname(__FILE__) . '/../models/software_quote.php');
	require_once(dirname(__FILE__) . '/../models/iusethis_entry.php');
	require_once(dirname(__FILE__) . '/../models/macupdate_entry.php');
	require_once(dirname(__FILE__) . '/../models/version_tracker_entry.php');
	require_once(dirname(__FILE__) . '/../models/google_groups_entry.php');
	require_once(dirname(__FILE__) . '/../models/softpedia_clean_award.php');
	require_once(dirname(__FILE__) . '/../helpers/antispam.php');
	require_once(dirname(__FILE__) . '/../helpers/http.php');
	require_once(dirname(__FILE__) . '/../helpers/gravatar.php');
	require_once(dirname(__FILE__) . '/../helpers/wikipedia.php');
	require_once(dirname(__FILE__) . '/../helpers/download_manager.php');
	require_once(dirname(__FILE__) . '/../helpers/software_comment_email.php');

	/**
	 *	@class SoftwareController
	 *	@short Controller for Software sections.
	 *	@details The SoftwareController is a controller class for actions that present the software products published on the Emeraldion Lodge,
	 *	provides commenting support, detailed informations for individual software products, and tracks the number of downloads.
	 */
	class SoftwareController extends EmeController
	{
		/**
		 *	@short Flag that determines if downloads should be logged.
		 */
		const SOFTWARE_SAVE_DOWNLOADS = FALSE;
		
		/**
		 *	@attr mimetype
		 *	@short The MIME type of the response.
		 */
		protected $mimetype = 'text/html; charset=iso-8859-1';
		
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->caches_page(array('download_stats', 'widgets_versioncheck', 'releasenotes', 'changelog'));
			$this->before_filter('block_ip');
			$this->before_filter('log_visit', array('except' => array('widgets_versioncheck', 'download', 'download_stats', 'user_quotes')));
			$this->after_filter('shrink_html', array('except' => array('widgets_versioncheck', 'download', 'download_stats', 'user_quotes')));
			$this->after_filter('compress');
		}
		
		public function index()
		{
			$release_factory = new SoftwareRelease();
			$this->releases = $release_factory->find_by_query('SELECT MAX(`software_releases`.`id`) AS `id`, `software_releases`.`software_id`, MAX(`software_releases`.`version`) AS `version`, MAX(`software_releases`.`date`) AS `date` ' .
				'FROM `softwares` ' .
				'LEFT JOIN `software_releases` ON `softwares`.`id` = `software_releases`.`software_id` ' .
				'GROUP BY `softwares`.`id` ' .
				'ORDER BY `date` DESC ');
		}
		
		/**
		 *	@fn ratings
		 *	@short Action method that shows a list of ratings for software products.
		 *	@details This method shows a list of ratings offered by external software sites like MacUpdate, IUseThis etc.
		 */
		public function ratings()
		{
			$this->index();
		}
		
		/**
		 *	@fn macosx
		 *	@short Convenience action method.
		 *	@details This method redirects legacy URLs to Mac OS X software to the main software index page.
		 */
		public function macosx()
		{
			$this->redirect_to(array('action' => 'index'));
		}
		
		/**
		 *	@fn widgets_versioncheck
		 *	@short Action method that shows the latest version available for a widget.
		 */
		public function widgets_versioncheck()
		{
			global $db;
			
			if (!isset($_REQUEST['id']))
			{
				if (!isset($_GET['software_name']) &&
					isset($_GET['name']))
				{
					$_GET['software_name'] = $_GET['name'];
				}
				
				$software_factory = new Software();
				$softwares = $software_factory->find_by_query('SELECT `id` ' .
					'FROM `softwares` ' .
					'WHERE `name` = \'' . $db->escape($_GET['software_name']) . '\' ' .
					'AND `type` = \'widgets\' ' .
					'LIMIT 1');

				if (count($softwares) > 0)
				{
					$_REQUEST['id'] = $softwares[0]->id;
				}
				else 
				{
					$softwares = $software_factory->find_by_query('SELECT `softwares`.`id` ' .
						'FROM `softwares` ' .
						'LEFT JOIN `software_typos` ON `softwares`.`id` = `software_typos`.`software_id` ' .
						'WHERE `software_typos`.`typo` = \'' . $db->escape($_GET['software_name']) . '\' ' .
						'AND `softwares`.`type` = \'widgets\' ' .
						'LIMIT 1');
					if (count($softwares) > 0)
					{
						$_REQUEST['id'] = $softwares[0]->id;
					}
					else 
					{
						HTTP::error(404);
					}
				}
			}
			$release_factory = new SoftwareRelease();
			$releases = $release_factory->find_by_query('SELECT  MAX(`software_releases`.`id`) AS `id`, MAX(`software_releases`.`version`) AS `version` ' .
				'FROM `software_releases` ' .
				'LEFT JOIN `softwares` ON `software_releases`.`software_id` = `softwares`.`id` ' .
				'WHERE `softwares`.`id` = \'' . $db->escape($_REQUEST['id']) . '\' ' .
				'AND `softwares`.`type` = \'widgets\' ' .
				'AND `software_releases`.`released` = 1 ' .
				'GROUP BY `software_releases`.`software_id` ' .
				'LIMIT 1');
			if (count($releases) > 0)
			{
				$this->output = $releases[0]->version;
			}
			else
			{
				$this->output = l('No such widget');
			}
			$this->render(array('layout' => FALSE, 'final' => TRUE));
		}
		
		/**
		 *	@fn last_releases
		 *	@short Action method that shows a list of the last software product releases.
		 */
		public function last_releases()
		{
			$release_factory = new SoftwareRelease();
			$this->releases = $release_factory->find_by_query('SELECT MAX(`software_releases`.`id`) AS `id`, `software_releases`.`software_id`, MAX(`software_releases`.`version`) AS `version`, MAX(`software_releases`.`date`) AS `date` ' .
				'FROM `softwares` ' .
				'LEFT JOIN `software_releases` ON `softwares`.`id` = `software_releases`.`software_id` ' .
				'GROUP BY `softwares`.`id` ' .
				'ORDER BY `date` DESC ' .
				'LIMIT 5');
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn main
		 *	@short Action method that shows the principal page for a software product.
		 */
		public function main()
		{
			$this->_init_software();
			
			$this->render(array('layout' => FALSE));
		}
		
		/**
		 *	@fn instructions
		 *	@short Action method that shows the instructions page for a software product.
		 */
		public function instructions()
		{
			$this->_init_software();
			
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn development
		 *	@short Action method that shows the development information page for a software product.
		 *	@details This page is only available for open source projects that are hosted on a project hosting website.
		 */
		public function development()
		{
			$this->_init_software();
			
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn donate
		 *	@short Action method that shows the donation page for a software product.
		 *	@details This page is only available for freeware or open source software products.
		 */
		public function donate()
		{
			$this->redirect_to(array('controller' => 'donate'));
		}

		/**
		 *	@fn register
		 *	@short Action method that shows the registration page for a software product.
		 *	@details This page is only available for shareware or commercial software products.
		 */
		public function register()
		{
			$this->_init_software();
			
			if (isset($_POST))
			{
				// Handle registration requests...
			}
			
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn license
		 *	@short Action method that shows the licensing information page for a software product.
		 */
		public function license()
		{
			$this->_init_software();
			
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn changelog
		 *	@short Action method that shows the changelog page for a software product.
		 */
		public function changelog()
		{
			$this->_init_software();
			
			$this->render(array('layout' => FALSE));
		}
		
		/**
		 *	@fn comments
		 *	@short Action method that shows the comments page for a software product.
		 */
		public function comments()
		{
			$this->_init_software();
			
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn post_comment
		 *	@short Action method that receives a comment for a software product.
		 */
		public function post_comment()
		{
			global $db;
			
			if (!$this->request->is_post())
			{
				$this->redirect_to(array('action' => 'index'));
			}
			$software = new Software();
			if ($software->find_by_id($_POST['software_id']) === FALSE)
			{
				$this->flash(l('No such software'), 'error');
				$this->redirect_to(array('action' => 'index'));
			}
			
			if (!Email::is_valid($_POST['email']))
			{
				$this->flash(l('Please enter a valid email address'), 'error');
				$this->redirect_to($software->comments_permalink());
			}
			if (!Antispam::check_math())
			{
				$this->flash(Antispam::random_comment(), 'error');
				$this->redirect_to($software->comments_permalink());
			}
			
			// A static class method would be infinitely better...
			$comment = new SoftwareComment($_POST);
			$comment->created_at = date('Y-m-d H:i:s');
			$comment->save();

			// Send an email to notify this comment
			$email = new SoftwareCommentEmail(array('comment' => $comment,
				'name' => $_POST['author'],
				'email' => $_POST['email'],
				'URL' => $_POST['URL']));
			$email->send();

			if (isset($_POST['remember_me']))
			{
				$this->set_credentials($_POST['author'],
					$_POST['email'],
					$_POST['URL']);
			}
			
			// Expires the cache of Comments feed
			$this->expire_cached_page(array('controller' => 'feed', 'action' => 'software_comments', 'id' => $_POST['software_id']));
			
			$this->redirect_to_software_page(array('id' => $_POST['software_id'], 'subview' => 'comments', 'hash' => ('comment-' . $comment->id)));
		}
		
		/**
		 *	@fn show
		 *	@short Action method that shows the individual page for a software product.
		 */
		public function show()
		{
			$this->_init_software();
			$this->software->has_many('software_quotes');
			
			$this->description = $this->software->description;
			
			if (!isset($_REQUEST['subview']))
			{
				$_REQUEST['subview'] = 'main';
			}
			
			$this->render(array('layout' => 'software_show'));
		}
		
		/**
		 *	@fn releasenotes
		 *	@short Action method that shows the changes in the last release of the requested software.
		 *	@note This action is designed to be called by Sparkle application updater.
		 */
		public function releasenotes()
		{
			if (!empty($_REQUEST['id']))
			{
				$release_factory = new SoftwareRelease();
				$releases = $release_factory->find_by_query('SELECT * FROM `software_releases` ' .
					'WHERE `software_id` = \'' . $_REQUEST['id'] . '\' ' .
					'AND `released` = 1 ' .
					'ORDER BY `date` DESC ' .
					'LIMIT 1');
				if (count($releases) < 1)
				{
					HTTP::error(404);
				}
				$this->release = $releases[0];
				$this->release->belongs_to('softwares');
				$this->render(array('layout' => 'software_releasenotes'));
			}
			else
			{
				$this->redirect_to(array('action' => 'index'));
			}
		}
		
		/**
		 *	@fn user_quotes
		 *	@short Action method that shows a collection of user testimonials for software products.
		 *	@note This action is intented to be called from AJAX and does not show a full page layout.
		 */
		public function user_quotes()
		{
			if (!empty($_GET['id']))
			{
				$software = new Software();
				if ($software->find_by_id($_GET['id']) === FALSE)
				{
					$this->flash(l('No such software product!'), 'error');
					$this->redirect_to(array('action' => 'index'));
				}
				$software->has_many('software_quotes');
				$quotes = $software->software_quotes;
				if (count($quotes) > 0)
				{
					$this->quotes = $quotes;
					$this->render(array('layout' => FALSE));
				}
				else
				{
					$this->render(NULL);
				}
			}
			else
			{
				$this->redirect_to(array('action' => 'index'));
			}
		}
		
		/**
		 *	@fn download
		 *	@short Action method that performs the download of a software artifact.
		 *	@details For software artifacts that are locally hosted, a DownloadManager is instantiated and the download
		 *	is automatically started. For externally hosted artifacts, the client is redirected to the appropriate URL.
		 */
		public function download()
		{
			if (!empty($_REQUEST['id']))
			{
				$artifact = new SoftwareArtifact();
				if ($artifact->find_by_id($_REQUEST['id']) === FALSE)
				{
					HTTP::error(404);
				}
				$artifact->downloads++;
				$artifact->save();
				
				if (self::SOFTWARE_SAVE_DOWNLOADS)
				{
					// Logs the download
					$download = new SoftwareDownload();
					$download->artifact_id = $_REQUEST['id'];
					$download->save();
				}
				
				// Expires the cache of Download Stats
				// Remember: Download Stats are cached by release_id
				$this->expire_cached_page(array('action' => 'download_stats', 'id' => $artifact->release_id));
				
				if ($artifact->URL)
				{
					$this->redirect_to($artifact->URL);
				}
				else
				{
					$filename = $artifact->local_file();
					if ($filename)
					{
						$dl_mgr = new DownloadManager($filename);
						$dl_mgr->start_download();
					}
				}
			}
			$this->redirect_to(array('action' => 'index'));
		}
	
		/**
		 *	@fn download_stats
		 *	@short Action method that shows the download statistics for a software release.
		 *	@note This action is intented to be called from AJAX and does not show a full page layout.
		 */
		public function download_stats()
		{
			global $db;
			
			$release = new SoftwareRelease();
			if ($release->find_by_id($_GET['id']) === FALSE)
			{
				$this->flash(l('No such software release!'), 'error');
				$this->redirect_to(array('action' => 'index'));
			}
			$release->belongs_to('softwares');
			
			$db->prepare('SELECT SUM(`downloads`) FROM `software_artifacts` WHERE `release_id` = \'{1}\'',
				$release->id);
			$db->exec();
			$this->partial = $db->result(0);
			
			$db->prepare('SELECT SUM(`downloads`) FROM `software_artifacts` WHERE `software_id` = \'{1}\'',
				$release->software->id);
			$db->exec();
			$this->total = $db->result(0);
			
			$this->render(array('layout' => FALSE));
		}
		
		/**
		 *	@fn redirect_to_software_page($params)
		 *	@short Redirects the request to a detailed page for a software product.
		 *	@param params An array of parameters that determine the software and the page for the redirection.
		 */
		public function redirect_to_software_page($params)
		{
			$software = new Software();
			$software->find_by_id($params['id']);
			$URL = sprintf('http://%s/%s/%s/%s/%s.html',
				$_SERVER['HTTP_HOST'],
				$this->name,
				$software->type,
				$software->name,
				$params['subview']);
			if (isset($params['hash']))
			{
				$URL .= '#' . $params['hash'];
			}
			$this->redirect_to($URL);
		}
		
		/**
		 *	@fn _init_software
		 *	@short Private method that initializes repetitive members of software product page actions.
		 */
		private function _init_software()
		{
			global $db;
			
			if (isset($_REQUEST['software_name']))
			{
				$software_factory = new Software();
				$softwares = $software_factory->find_all(array('where_clause' => ('`name` = \'' . $db->escape($_REQUEST['software_name']) . '\' AND `type` = \'' . $db->escape($_REQUEST['software_type']) . '\''),
					'limit' => 1));
				if (count($softwares) > 0)
				{
					$this->software = $softwares[0];
				}
				else 
				{
					$softwares = $software_factory->find_by_query('SELECT `softwares`.`id` ' .
						'FROM `softwares` ' .
						'LEFT JOIN `software_typos` ON `softwares`.`id` = `software_typos`.`software_id` ' .
						'WHERE `software_typos`.`typo` = \'' . $db->escape($_REQUEST['software_name']) . '\' ' .
						'LIMIT 1');
					if (count($softwares) > 0)
					{
						$this->software = $softwares[0];
						header(sprintf('Location: http://%s%s',
							$_SERVER['HTTP_HOST'],
							$this->software->url_to_detail($_REQUEST['subview'])));
						exit();
					}
					else 
					{
						HTTP::error(404);
					}
				}
				$_REQUEST['id'] = $this->software->id;
			}
			else if (isset($_GET['id']))
			{
				$this->software = new Software();
				if ($this->software->find_by_id($_GET['id']) === FALSE)
				{
					$this->flash(l('No such software product!'), 'error');
					$this->redirect_to(array('action' => 'index'));
				}
			}
			else
			{
				HTTP::error(404);
			}
			$this->software->has_many('software_releases', array('where_clause' => '`released` = \'1\''));
			$releases = $this->software->software_releases;
			usort($releases, array($releases[0], 'sort_releases'));
			$this->release = $releases[0];
			$this->software->software_releases = $releases;
		}
	}
?>