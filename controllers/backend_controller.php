<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../models/diario_post.php");
	require_once(dirname(__FILE__) . "/../models/diario_comment.php");
	require_once(dirname(__FILE__) . "/../models/software_comment.php");
	require_once(dirname(__FILE__) . "/../models/software_quote.php");
	require_once(dirname(__FILE__) . "/../models/diario_author.php");
	require_once(dirname(__FILE__) . "/../models/server_error.php");
	require_once(dirname(__FILE__) . "/../models/software.php");
	require_once(dirname(__FILE__) . "/../models/tag.php");
	require_once(dirname(__FILE__) . "/../models/software_release.php");
	require_once(dirname(__FILE__) . "/../models/software_artifact.php");
	require_once(dirname(__FILE__) . "/../models/software_pingback.php");
	require_once(dirname(__FILE__) . "/../models/user.php");
	require_once(dirname(__FILE__) . "/../helpers/antispam.php");
	require_once(dirname(__FILE__) . "/../helpers/gravatar.php");
	require_once(dirname(__FILE__) . "/../helpers/login.php");
	require_once(dirname(__FILE__) . "/../helpers/gate.php");
	require_once(dirname(__FILE__) . "/../helpers/software_comment_followup_email.php");
	require_once(dirname(__FILE__) . "/../helpers/diario_comment_followup_email.php");

	/**
	 *	@class BackendController
	 *	@short Controller class for Backend maintenance and website administration functions.
	 */
	class BackendController extends EmeController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->before_filter('check_auth');
			//$this->before_filter('log_visit');
			$this->after_filter(array('shrink_html', 'compress'));
		}
		
		public function index()
		{
			$this->redirect_to(array('action' => 'software_moderation_queue'));
		}
		
		/**
		 *	Diario administration actions
		 */

		/**
		 *	Diario comments actions
		 */

		/**
		 *	@fn diario_moderation_queue
		 *	@short Action method that shows the queue of comments awaiting moderation.
		 */
		public function diario_moderation_queue()
		{
			$comment = new DiarioComment();
			$this->comments = $comment->find_unapproved();
		}
		
		/**
		 *	@fn diario_comment_moderate
		 *	@short Action method that moderates a comment.
		 */
		public function diario_comment_moderate()
		{
			global $db;
			
			$this->_batch_moderate('diario_comments');
			
			if (isset($_POST['moderate-selected']))
			{
				$comment_ids = is_array($_POST['id']) ? $_POST['id'] : array($_POST['id']);
				foreach ($comment_ids as $comment_id)
				{
					$comment = new DiarioComment();
					$comment->find_by_id($comment_id);
					$comment->belongs_to('diario_posts');
					
					// Notify previous commenters of the followup comment
					$comment_factory = new DiarioComment();
					// Obtain previous comments with followup notify set to true
					$previous_comments = $comment_factory->find_all(array('where_clause' => "`post_id` = '{$db->escape($comment->post_id)}' AND `followup_email_notify` = '1'"));
					// Include comment author in previous recipients to avoid auto-notifications
					$previous_comments_recipients = array($comment->email);
					foreach ($previous_comments as $previous_comment)
					{
						if (in_array($previous_comment->email, $previous_comments_recipients) ||
							!Email::is_valid($previous_comment->email))
						{
							continue;
						}
						$email = new DiarioCommentFollowupEmail(array('comment' => $comment,
							'name' => $previous_comment->author,
							'email' => $previous_comment->email));
						$email->send();
						// Append so it won't receive duplicate notifications
						$previous_comments_recipients[] = $previous_comment->email;
					}
				}
			}
			
			$this->redirect_to(array('action' => 'diario_moderation_queue'));
		}
		
		/**
		 *	@fn diario_comment_discard
		 *	@short Action method that discards a comment or a group of comments.
		 */
		public function diario_comment_discard()
		{
			if ($this->request->is_get())
			{
				if (!empty($_GET['id']))
				{
					$this->comment = new DiarioComment();
					$this->comment->find_by_id($_GET['id']);
				}
			}
			else
			{
				if (!empty($_POST['id']))
				{
					if (is_array($_POST['id']))
					{
						foreach ($_POST['id'] as $id)
						{
							$comment = new DiarioComment();
							$comment->find_by_id($id);
							$comment->delete();
						}
					}
					else
					{
						$comment = new DiarioComment();
						$comment->find_by_id($_POST['id']);
						$comment->delete();
					}
				}
				$this->redirect_to(array('action' => 'diario_moderation_queue'));
			}
		}
		
		/**
		 *	Diario articles actions
		 */

		/**
		 *	@fn diario_post_compose
		 *	@short Action method to compose a new article.
		 */
		public function diario_post_compose()
		{
			$this->post = new DiarioPost();
			$this->render(array('action' => 'diario_post_edit'));
		}

		/**
		 *	@fn diario_post_add
		 *	@short Action method to save a newly composed article.
		 */		
		public function diario_post_add()
		{
			global $db;
			
			if (isset($_POST))
			{
				$post = new DiarioPost($_POST);
				$post->author = $_COOKIE['_u'];
				$post->save();
				
				// Delete old tags (if any)
				$db->prepare('DELETE FROM `diario_posts_tags` ' .
						"WHERE `post_id` = '{1}'",
						$post->id);
				$db->exec();
				
				// Save tags
				$tag_tokens = explode(',', $_POST['tag']);
				$tag_tokens = array_map('trim', $tag_tokens);
				$tag_factory = new Tag();
				foreach ($tag_tokens as $tag_token)
				{
					if (empty($tag_token))
					{
						continue;
					}
					$tag_results = $tag_factory->find_all(array('where_clause' => "`tag` = '{$tag_token}'"));
					if (count($tag_results) > 0)
					{
						$tag = $tag_results[0];
					}
					else
					{
						$tag = new Tag();
						$tag->tag = $tag_token;
						$tag->save();
					}
					$db->prepare('INSERT IGNORE INTO `diario_posts_tags` ' .
						'(`post_id`, `tag_id`) ' .
						"VALUES ('{1}', '{2}')",
						$post->id,
						$tag->id);
					$db->exec();
				}
				
				// Expires the cache of Diario
				$this->expire_cached_page(array('controller' => 'diario', 'action' => 'index'));
				$this->expire_cached_page(array('controller' => 'diario', 'action' => 'last_posts'));
				$this->expire_cached_page(array('controller' => 'diario', 'action' => 'read', 'id' => $post->id));
				// Expires the cache of Diario feed
				$this->expire_cached_page(array('controller' => 'feed', 'action' => 'diario'));
			}
			$this->redirect_to(array('action' => 'diario_post_list'));
		}

		/**
		 *	@fn diario_post_edit
		 *	@short Action method to edit an existing article.
		 */
		public function diario_post_edit()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'diario_post_list'));
			}
			$this->post = new DiarioPost();
			$this->post->find_by_id($_REQUEST['id']);
			
			$this->post->has_and_belongs_to_many('tags');
		}
		
		/**
		 *	@fn diario_post_list
		 *	@short Action method to show the list of articles.
		 */
		public function diario_post_list()
		{
			$post_factory = new DiarioPost();
			$this->posts = $post_factory->find_all(array('order_by' => '`id` DESC',
				'start' => isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? (20 * ($_REQUEST['page'] - 1)) : 0,
				'limit' => 20));
		}

		/**
		 *	@fn diario_pingback_list
		 *	@short Action method to show the list of Pingbacks issued for Blog posts.
		 */
		public function diario_pingback_list()
		{
			$pb_factory = new DiarioPingback();
			$this->pingbacks = $pb_factory->find_all(array('order_by' => '`created_at` DESC'));
		}
		
		/**
		 *	@fn diario_pingback_moderate
		 *	@short Action method that moderates Pingbacks issued for Blog posts.
		 */
		public function diario_pingback_moderate()
		{
			$this->_batch_moderate('diario_pingbacks');
			$this->redirect_to(array('action' => 'diario_pingback_list'));
		}

		/**
		 *	Software administration actions
		 */
		
		/**
		 *	@fn software_moderation_queue
		 *	@short Action method to manage the queue of software comments.
		 */
		public function software_moderation_queue()
		{
			$comment = new SoftwareComment();
			$this->comments = $comment->find_unapproved();
		}

		/**
		 *	@fn software_comment_moderate
		 *	@short Action method to moderate a software comment.
		 */
		public function software_comment_moderate()
		{
			global $db;
			
			$this->_batch_moderate('software_comments');
			
			if (isset($_POST['moderate-selected']))
			{
				$comment_ids = is_array($_POST['id']) ? $_POST['id'] : array($_POST['id']);
				foreach ($comment_ids as $comment_id)
				{
					$comment = new SoftwareComment();
					$comment->find_by_id($comment_id);
					$comment->belongs_to('softwares');
					
					// Notify previous commenters of the followup comment
					$comment_factory = new SoftwareComment();
					// Obtain previous comments with followup notify set to true
					$previous_comments = $comment_factory->find_all(array('where_clause' => "`software_id` = '{$db->escape($comment->software_id)}' AND `followup_email_notify` = '1'"));
					// Include comment author in previous recipients to avoid auto-notifications
					$previous_comments_recipients = array($comment->email);
					foreach ($previous_comments as $previous_comment)
					{
						if (!in_array($previous_comment->email, $previous_comments_recipients) &&
							Email::is_valid($previous_comment->email))
						{
							$email = new SoftwareCommentFollowupEmail(array('comment' => $comment,
								'name' => $previous_comment->author,
								'email' => $previous_comment->email));
							$email->send();
							// Add notifiee to previous recipients to avoid sending multiple messages
							$previous_comments_recipients[] = $previous_comment->email;
						}
					}
				}
			}
				
			$this->redirect_to(array('action' => 'software_moderation_queue'));
		}

		/**
		 *	@fn software_comment_list
		 *	@short Action method to show the list of software comments.
		 */
		public function software_comment_list()
		{
			global $db;
			
			if (empty($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}			
			$comment = new SoftwareComment();
			$this->comments = $comment->find_all(array('where_clause' => "`software_id` = '{$db->escape($_REQUEST['id'])}'"));
		}

		/**
		 *	@fn software_comment_discard
		 *	@short Action method to delete a software comments.
		 */	
		public function software_comment_discard()
		{
			if ($this->request->is_get())
			{
				if (!empty($_GET['id']))
				{
					$this->comment = new SoftwareComment();
					$this->comment->find_by_id($_REQUEST['id']);
					$this->comment->belongs_to('softwares');
				}
			}
			else
			{
				if (!empty($_POST['id']))
				{
					$comment = new SoftwareComment();
					$comment->find_by_id($_REQUEST['id']);
					$comment->delete();
				}
				$this->redirect_to(array('action' => 'software_moderation_queue'));
			}
		}

		/**
		 *	@fn software_comment_mark_as_spam
		 *	@short Action method to mark a software comment as spam.
		 */
		public function software_comment_mark_as_spam()
		{
			if ($this->request->is_post())
			{
				if (!empty($_POST['id']))
				{
					$comment = new SoftwareComment();
					$comment->find_by_id($_REQUEST['id']);

					if (!Antispam::check_spam_signature($comment->text))
					{
						Antispam::store_spam_signature($comment->text);
					}
				}
				$this->render(NULL);
			}
		}

		/**
		 *	@fn software_list
		 *	@short Action method to show the list of software products.
		 */
		public function software_list()
		{
			$software_factory = new Software();
			$this->softwares = $software_factory->find_all(array('order_by' => '`type` ASC, `title` ASC', 'limit' => 100));
		}

		/**
		 *	@fn software_edit
		 *	@short Action method to edit a software product.
		 */
		public function software_edit()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->software = new Software();
			$this->software->find_by_id($_REQUEST['id']);
		}

		/**
		 *	@fn software_create
		 *	@short Action method to create a new software product.
		 */		
		public function software_create()
		{
			$this->software = new Software();
			$this->software->type = 'macosx';
			$this->software->title = '';
			$this->software->description = '';
			$this->render(array('action' => 'software_edit'));
		}

		/**
		 *	@fn software_delete
		 *	@short Action method to delete a software product.
		 *	@warning This method has potentially destructive consquences.
		 *	Do not use it without a really good reason.
		 */
		public function software_delete()
		{
			if (isset($_GET['id']))
			{
				$this->software = new Software();
				$this->software->find_by_id($_GET['id']);
			}
			else
			{
				if (isset($_POST['id']))
				{
					$software = new Software();
					$software->find_by_id($_POST['id']);
					$software->delete();
					
					// Expires the cache of Software & Sparkle feeds
					$this->expire_cached_software_pages();
				}
				$this->redirect_to(array('action' => 'software_list'));				
			}
		}

		/**
		 *	@fn software_release_list
		 *	@short Action method to show a list of software releases.
		 */
		public function software_release_list()
		{
			global $db;

			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$release_factory = new SoftwareRelease();
			$this->releases = $release_factory->find_all(array('where_clause' => "`software_id` = '{$db->escape($_REQUEST['id'])}'", 'order_by' => '`date` DESC'));
		}

		/**
		 *	@fn software_release_edit
		 *	@short Action method to edit a software release.
		 */
		public function software_release_edit()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->release = new SoftwareRelease();
			$this->release->find_by_id($_REQUEST['id']);
			$this->release->belongs_to('softwares');
		}

		/**
		 *	@fn software_release_create
		 *	@short Action method to create a software release.
		 */
		public function software_release_create()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->release = new SoftwareRelease();
			$this->release->software_id = $_REQUEST['id'];
			$this->release->belongs_to('softwares');
			$this->render(array('action' => 'software_release_edit'));
		}
		
		/**
		 *	@fn software_release_add
		 *	@short Action method to save a software release.
		 */
		public function software_release_add()
		{
			if (!isset($_POST))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$release = new SoftwareRelease($_POST);
			if (!isset($_POST['released']))
			{
				$release->released = '0';
			}
			$release->save();
			
			// Expires the cache of Software & Sparkle feeds
			$this->expire_cached_software_pages();
			
			$this->redirect_to(array('action' => 'software_release_list', 'id' => $_POST['software_id']));
		}

		/**
		 *	@fn software_artifact_list
		 *	@short Action method to show a list of software artifacts.
		 */
		public function software_artifact_list()
		{
			global $db;

			$artifact_factory = new SoftwareArtifact();
			if (!isset($_REQUEST['id']))
			{
				$_REQUEST['id'] = 0;
				$this->artifacts = $artifact_factory->find_all(array('order_by' => '`file` ASC, `priority` DESC'));
			}
			else
			{
				$this->release = new SoftwareRelease();
				if ($this->release->find_by_id($_REQUEST['id']) === FALSE)
				{
					$this->redirect_to(array('action' => 'software_list'));
				}
				$this->artifacts = $artifact_factory->find_all(array('where_clause' => "`release_id` = '{$db->escape($_REQUEST['id'])}'", 'order_by' => '`priority` DESC'));
			}
		}

		/**
		 *	@fn software_artifact_edit
		 *	@short Action method to edit a software artifact.
		 */
		public function software_artifact_edit()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->artifact = new SoftwareArtifact();
			$this->artifact->find_by_id($_REQUEST['id']);
			$this->artifact->belongs_to('softwares');
			$this->artifact->belongs_to('software_releases');
			$this->artifact->release = $this->artifact->software_release;
		}

		/**
		 *	@fn software_artifact_create
		 *	@short Action method to create a software artifact.
		 */
		public function software_artifact_create()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->artifact = new SoftwareArtifact();
			$this->artifact->release_id = $_REQUEST['id'];
			$this->artifact->belongs_to('software_releases');
			$this->artifact->software_id = $this->artifact->software_release->software_id;
			$this->artifact->belongs_to('softwares');
			$this->artifact->release = $this->artifact->software_release;
			$this->render(array('action' => 'software_artifact_edit'));
		}

		/**
		 *	@fn software_artifact_add
		 *	@short Action method to save a software artifact.
		 */
		public function software_artifact_add()
		{
			if (!isset($_POST))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$artifact = new SoftwareArtifact($_POST);
			if (!isset($_POST['enabled']))
			{
				$artifact->enabled = '0';
			}
			if (!isset($_POST['visible']))
			{
				$artifact->visible = '0';
			}
			$artifact->save();
			
			// Expires the cache of Software & Sparkle feeds
			$this->expire_cached_software_pages();
			
			$this->redirect_to(array('action' => 'software_artifact_list', 'id' => $_POST['release_id']));
		}
	
		/**
		 *	@fn software_quote_list
		 *	@short Action method that shows the list of quotes for a software product.
		 */				
		public function software_quote_list()
		{
			global $db;

			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$quote_factory = new SoftwareQuote();
			$this->quotes = $quote_factory->find_all(array('where_clause' => "`software_id` = '{$db->escape($_REQUEST['id'])}'", 'order_by' => '`author` ASC, `quote` ASC'));
		}

		/**
		 *	@fn software_quote_create
		 *	@short Action method that creates a software quote entry.
		 */				
		public function software_quote_create()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->quote = new SoftwareQuote();
			$this->quote->software_id = $_REQUEST['id'];
			$this->render(array('action' => 'software_quote_edit'));
		}

		/**
		 *	@fn software_quote_edit
		 *	@short Action method that modifies a software quote entry.
		 */				
		public function software_quote_edit()
		{
			global $db;

			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->quote = new SoftwareQuote();
			$this->quote->find_by_id($_REQUEST['id']);
		}

		/**
		 *	@fn software_quote_add
		 *	@short Action method that saves a software quote entry.
		 */				
		public function software_quote_add()
		{
			if (!$this->request->is_post())
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$quote = new SoftwareQuote($_POST);
			$quote->save();
			
			$this->redirect_to(array('action' => 'software_quote_list', 'id' => $_POST['software_id']));
		}

		/**
		 *	@fn software_quote_delete
		 *	@short Action method that deletes a software quote entry.
		 */				
		public function software_quote_delete()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->quote = new SoftwareQuote();
			$this->quote->find_by_id($_REQUEST['id']);
		}

		/**
		 *	@fn software_downloads
		 *	@short Action method that shows statistics on software downloads grouped by
		 *	software product.
		 */				
		public function software_downloads()
		{
			$software_factory = new Software();
			$this->softwares = $software_factory->find_all(array('order_by' => '`title` DESC'));
		}
		
		/**
		 *	@fn software_downloads_by_release
		 *	@short Action method that shows statistics on software downloads grouped by release
		 *	for a particular software product.
		 */		
		public function software_downloads_by_release()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$software = new Software();
			if ($software->find_by_id($_REQUEST['id']) === FALSE)
			{
				$this->flash(l('No such software'), 'error');
				$this->redirect_to(array('action' => 'software_list'));
			}
			$software->has_many('software_releases', array('order_by' => '`date` DESC'));
			$this->releases = $software->software_releases;
		}

		/**
		 *	@fn software_downloads_by_artifact
		 *	@short Action method that shows statistics on software artifact downloads
		 *	for a particular release.
		 */		
		public function software_downloads_by_artifact()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->release = new SoftwareRelease();
			if ($this->release->find_by_id($_REQUEST['id']) === FALSE)
			{
				$this->flash(l('No such release'), 'error');
				$this->redirect_to(array('action' => 'software_list'));
			}
			$this->release->has_many('software_artifacts', array('order_by' => '`title` DESC'));
			$this->artifacts = $this->release->software_artifacts;
		}
		
		/**
		 *	@fn software_pingback_list
		 *	@short Action method that shows the list of Pingbacks issued for Software items.
		 */
		public function software_pingback_list()
		{
			if (isset($_REQUEST['id']))
			{
				$this->software = new Software();
				$this->software->find_by_id($_GET['id']);
				$this->software->has_many('software_pingbacks');
				$this->pingbacks = $this->software->pingbacks;
			}
			else
			{
				$pb_factory = new SoftwarePingback();
				$this->pingbacks = $pb_factory->find_all(array('order_by' => '`created_at` ASC'));
			}
		}
		
		/**
		 *	@fn software_pingback_moderate
		 *	@short Action method that moderates Pingbacks issued for software products.
		 */
		public function software_pingback_moderate()
		{
			$this->_batch_moderate('software_pingbacks');
			$this->redirect_to(array('action' => 'software_pingback_list'));
		}
		
		/**
		 *	@fn server_error_list
		 *	@short Action method that shows the list of server errors.
		 */
		public function server_error_list()
		{
			$error_factory = new ServerError();
			$this->errors = $error_factory->find_all(array('order_by' => '`occurred_at` DESC'));
		}
		
		/**
		 *	@fn server_error_read	
		 *	@short Action method that shows individual server error items.
		 */
		public function server_error_read()
		{
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'server_error_list'));
			}
			$this->error = new ServerError();
			if ($this->error->find_by_id($_REQUEST['id']) === FALSE)
			{
				$this->flash(l('No such element!'), 'error');
				$this->redirect_to(array('action' => 'server_error_list'));
			}
		}
		
		/**
		 *	@fn server_error_next
		 *	@short Action method that shows the next server error.
		 */
		public function server_error_next()
		{
			global $db;
			
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'server_error_list'));
			}
			$err = new ServerError();
			$errors = $err->find_all(array('where_clause' => "`id` >= '{$_REQUEST['id']}'",
				'limit' => 1));
			if (count($errors) < 1)
			{
				$this->redirect_to(array('action' => 'server_error_list'));
			}
			$this->error = $errors[0];
			$this->render(array('action' => 'server_error_read'));
		}
		
		/**
		 *	@fn server_error_previous
		 *	@short Action method that shows the previous server error.
		 */
		public function server_error_previous()
		{
			global $db;
			
			if (!isset($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'server_error_list'));
			}
			$err = new ServerError();
			$errors = $err->find_all(array('where_clause' => "`id` <= '{$_REQUEST['id']}'",
				'limit' => 1));
			if (count($errors) < 1)
			{
				$this->redirect_to(array('action' => 'server_error_list'));
			}
			$this->error = $errors[0];
			$this->render(array('action' => 'server_error_read'));
		}

		/**
		 *	@fn server_error_delete
		 *	@short Action method that deletes server error items.
		 */
		public function server_error_delete()
		{
			global $db;
			
			if (!empty($_GET['id']))
			{
				$this->redirect_to(array('action' => 'server_error_read', 'id' => $_GET['id']));
			}
			else
			{
				if (!empty($_POST['id']))
				{
					if (is_array($_POST['id']))
					{
						$db->prepare('DELETE FROM `server_errors` ' .
							"WHERE FIND_IN_SET(`id`, '{1}') " .
							'LIMIT {2}',
							implode(',', $_POST['id']),
							count($_POST['id'])
							);
						$db->exec();
					}
					else
					{
						$error = new ServerError();
						$error->find_by_id($_REQUEST['id']);
						$error->delete();
					}
				}
				$this->redirect_to(array('action' => 'server_error_list'));
			}
		}
		
		/**
		 *	@fn expire_cached_software_pages
		 *	@short Deletes all cached software pages.
		 */
		private function expire_cached_software_pages()
		{
			// Expires the cache of Software & Sparkle feeds
			$this->expire_cached_page(array('controller' => 'feed', 'action' => 'software'));
			$this->expire_cached_page(array('controller' => 'sparkle', 'action' => 'index', 'id' => $_POST['software_id']));
			$this->expire_cached_page(array('controller' => 'software', 'action' => 'widgets_versioncheck', 'id' => $_POST['software_id']));
			$this->expire_cached_page(array('controller' => 'software', 'action' => 'changelog', 'id' => $_POST['software_id']));
			$this->expire_cached_page(array('controller' => 'software', 'action' => 'releasenotes', 'id' => $_POST['software_id']));
		}
		
		/**
		 *	@fn _batch_moderate($table_name)
		 *	@short Performs batch moderation operations on one or more items.
		 *	@param table_name The name of the table we want to operate on.
		 */
		private function _batch_moderate($table_name)
		{
			global $db;
			$has_deleted = FALSE;
			
			if ($this->request->is_post())
			{
				$query_preamble = 'SELECT 1 ';
				if (isset($_POST['delete-selected']))
				{
					$query_preamble = "DELETE FROM `{$table_name}` ";
					$has_deleted = TRUE;
				}
				else if (isset($_POST['moderate-selected']))
				{
					$query_preamble = "UPDATE `{$table_name}` SET `approved` = 1 ";
				}
				
				if (is_array($_POST['id']))
				{
					$db->prepare($query_preamble .
						"WHERE FIND_IN_SET(`id`, '{1}') " .
						'LIMIT {2}',
						implode(',', $_POST['id']),
						count($_POST['id'])
						);
					$db->exec();
				}
				else if (isset($_POST['id']))
				{
					$db->prepare($query_preamble .
						"WHERE `id` = '{1}' " .
						'LIMIT 1'
						);
					$db->exec();
				}
				if ($has_deleted)
				{
					$db->prepare("OPTIMIZE TABLE `{$table_name}`");
					$db->exec();
				}
			}
		}
	}
?>