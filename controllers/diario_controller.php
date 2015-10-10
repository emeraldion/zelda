<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../models/diario_post.php");
	require_once(dirname(__FILE__) . "/../models/diario_comment.php");
	require_once(dirname(__FILE__) . "/../models/diario_pingback.php");
	require_once(dirname(__FILE__) . "/../models/diario_author.php");
	require_once(dirname(__FILE__) . "/../models/tag.php");
	require_once(dirname(__FILE__) . "/../helpers/gravatar.php");
	require_once(dirname(__FILE__) . "/../helpers/time.php");
	require_once(dirname(__FILE__) . "/../helpers/antispam.php");
	require_once(dirname(__FILE__) . "/../helpers/wikipedia.php");
	require_once(dirname(__FILE__) . "/../helpers/diario_comment_email.php");

	define(PAGE_SIZE, '10');

	/**
	 *	@class DiarioController
	 *	@short Controller for the Diario blog.
	 */
	class DiarioController extends EmeController
	{
		/**
		 *	@attr mimetype
		 *	@short A MIME type for the response.
		 */
		protected $mimetype = 'text/html; charset=iso-8859-1';

		protected function init()
		{
			// Call parent's init method
			parent::init();

			//$this->caches_page(array('index', 'read'));
			$this->before_filter(array('log_visit', 'block_ip'));
			$this->before_filter('init_math_test', array('only' => array('read')));
			$this->after_filter('highlight_words', array('only' => array('search', 'live_search', 'index', 'read')));
			$this->after_filter('shrink_html');
			$this->after_filter('compress');
		}

		public function index()
		{
			if (!empty($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'read',
				'id' => $_REQUEST['id']));
			}
			// A static class method would be infinitely better...
			$article = new DiarioPost();
			$this->articles = $article->find_all(array('where_clause' => "`status` = 'pubblicato'", 'order_by' => '`created_at` DESC', 'limit' => PAGE_SIZE, 'start' => @$_REQUEST['start']));

			if (count($this->articles) <= PAGE_SIZE)
				$this->next_start = @$_REQUEST['start'] + PAGE_SIZE;

			if (isset($_REQUEST['layout']) &&
				$_REQUEST['layout'] == 'false')
			{
				$this->render(array('layout' => FALSE));
			}
		}

		/**
		 *	@fn last_posts
		 *	@short Action method that returns the latest blog posts.
		 */
		public function last_posts()
		{
			$article = new DiarioPost();
			$this->articles = $article->find_all(array('where_clause' => "`status` = 'pubblicato'", 'order_by' => '`created_at` DESC', 'limit' => '3'));
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn tag
		 *	@short Action method that returns a list of articles tagged with a particular label.
		 */
		public function tag()
		{
			if (empty($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'index'));
			}
			// A static class method would be infinitely better...
			$tag = new Tag();
			$tag->find_by_id($_REQUEST['id']);
			$tag->has_and_belongs_to_many('diario_posts', array('order_by' => '`created_at` DESC'));
			$this->articles = $tag->diario_posts;
			usort($this->articles, array($this->articles[0], 'sort_posts'));

			if (count($this->articles) > 10)
			{
				$start = limit_3(@$_REQUEST['start'], 0, count($this->articles) - 1);
				$this->articles = array_slice($this->articles, $start, 10);
			}

			$this->render(array('action' => 'index'));
		}

		/**
		 *	@fn calendar
		 *	@short Action method that creates a calendar to browse articles.
		 */
		public function calendar()
		{
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn date
		 *	@short Action method that returns a list of articles written before a particular date.
		 */
		public function date()
		{
			if (!empty($_REQUEST['day']))
			{
				$the_time = mktime(0, 0, 0, $_REQUEST['month'], $_REQUEST['day'] + 1, $_REQUEST['year']);
			}
			else
			{
				if (!empty($_REQUEST['month']))
				{
					$the_time = mktime(0, 0, 0, $_REQUEST['month'] + 1, 1, $_REQUEST['year']);
				}
				else
				{
					$the_time = mktime(0, 0, 0, 1, 1, $_REQUEST['year'] + 1);
				}
			}
			$the_date = date("Y-m-d H:i:s", $the_time);
			$article = new DiarioPost();
			$this->articles = $article->find_all(array('where_clause' => "`created_at` < '{$the_date}' AND `status` = 'pubblicato' ", 'order_by' => '`created_at` DESC', 'limit' => '10', 'start' => @$_REQUEST['start']));

			if (isset($_REQUEST['layout']) &&
				$_REQUEST['layout'] == 'false')
			{
				$this->render(array('layout' => FALSE, 'action' => 'index'));
			}
			else
			{
				$this->render(array('action' => 'index'));
			}
		}

		/**
		 *	@fn live_search
		 *	@short Action method that returns a list of articles that satisfy a search query.
		 *	@note This action does not return a full layout, and is intended to be used with AJAX calls.
		 */
		public function live_search()
		{
			if (isset($_REQUEST['term']) && !empty($_REQUEST['term']))
			{
				$conn = Db::get_connection();

				$post_factory = new DiarioPost();

				$terms = explode(' ', $_REQUEST['term']);

				$where_clause = '1';
				for ($i = 0; $i < count($terms); $i++)
				{
					$where_clause .= " AND (`title` LIKE '%{$conn->escape($terms[$i])}%' OR " .
						"`author` LIKE '%{$conn->escape($terms[$i])}%' OR " .
						"`text` LIKE '%{$conn->escape($terms[$i])}%') ";
				}

				$this->search_results = $post_factory->find_by_query("SELECT * " .
					"FROM `diario_posts` " .
					"WHERE {$where_clause} " .
					"AND `status` = 'pubblicato' LIMIT 20");

				Db::close_connection($conn);

				if (count($this->search_results) > 0)
				{
					$this->render(array('layout' => FALSE));
				}
			}
			$this->render(array('action' => 'no_results', 'layout' => FALSE));
		}

		/**
		 *	@fn search
		 *	@short Action method that returns a list of articles that satisfy a search query.
		 */
		public function search()
		{
			if (isset($_REQUEST['term']) && !empty($_REQUEST['term']))
			{
				$conn = Db::get_connection();

				$post_factory = new DiarioPost();

				$terms = explode(' ', $_REQUEST['term']);

				$where_clause = '1';
				for ($i = 0; $i < count($terms); $i++)
				{
					$where_clause .= " AND (`title` LIKE '%{$conn->escape($terms[$i])}%' OR " .
						"`author` LIKE '%{$conn->escape($terms[$i])}%' OR " .
						"`text` LIKE '%{$conn->escape($terms[$i])}%') ";
				}

				$this->articles = $post_factory->find_by_query("SELECT * " .
					"FROM `diario_posts` " .
					"WHERE {$where_clause} " .
					"AND `status` = 'pubblicato' LIMIT 20");
				if (count($this->articles) < 1)
				{
					$this->redirect_to(array('action' => 'index'));
				}

				Db::close_connection($conn);

				$this->render(array('action' => 'index'));
			}
			else
			{
				$this->redirect_to(array('action' => 'index'));
			}
		}

		/**
		 *	@fn read
		 *	@short Action method that shows an article for reading.
		 */
		public function read()
		{
			if (empty($_REQUEST['id']))
			{
				$this->redirect_to(array('action' => 'index'));
			}

			$conn = Db::get_connection();

			/*
			// THIS SUCKS!!!
			$this->article = DiarioPost::find($_REQUEST['id'], 'DiarioPost');
			*/
			$this->article = new DiarioPost();
			if ($this->article->find_by_id($_REQUEST['id']) === FALSE)
			{
				$this->flash(l('No such article'), 'error');
				$this->redirect_to(array('action' => 'index'));
			}
			if ($this->article->status != 'pubblicato')
			{
				HTTP::error(404);
			}

			// Annotates that the article has been read
			$this->article->readings++;
			$this->article->save();

			$this->render(array('layout' => 'diario_read'));

			Db::close_connection($conn);
		}

		/**
		 *	@fn comments
		 *	@short Action method that returns a list of comments for a given article ID.
		 */
		public function comments()
		{
			if (!empty($_REQUEST['id']))
			{
				$this->article = new DiarioPost();
				$this->article->find_by_id($_REQUEST['id']);

				$this->render(array('layout' => FALSE));
			}
		}

		/**
		 *	@fn go
		 *	@short Action method that redirects to an external article.
		 */
		public function go() {
			$this->article = new DiarioPost();
			if ($this->article->find_by_id($_REQUEST['id']) === FALSE)
			{
				$this->flash(l('No such article'), 'error');
				$this->redirect_to(array('action' => 'index'));
			}
			if ($this->article->status != 'pubblicato' ||
				$this->article->external_url == NULL)
			{
				HTTP::error(404);
			}

			// Annotates that the article has been read
			$this->article->readings++;
			$this->article->save();

			header(sprintf('Location: %s', $this->article->external_url));
			exit();
		}

		/**
		 *	@fn post_comment
		 *	@short Action method to receive a comment for an article.
		 */
		public function post_comment()
		{
			if (!$this->request->is_post())
			{
				$this->redirect_to(array('action' => 'index'));
			}
			$post = new DiarioPost();
			if ($post->find_by_id($_POST['post_id']) === FALSE)
			{
				$this->flash(l('No such article'), 'error');
				$this->redirect_to(array('action' => 'index'));
			}

			if (!Email::is_valid($_POST['email']))
			{
				$this->flash(l('Please enter a valid email address'), 'error');
				$this->redirect_to($post->permalink(FALSE));
			}
			if (!Antispam::check_math())
			{
				$this->flash(Antispam::random_comment(), 'error');
				$this->redirect_to($post->permalink(FALSE));
			}
			// A static class method would be infinitely better...
			$comment = new DiarioComment($_POST);
			$comment->created_at = date("Y-m-d H:i:s");
			$comment->save();

			// Send an email to notify this comment
			$email = new DiarioCommentEmail(array('comment' => $comment,
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

			// Expires the cache
			$this->expire_cached_page(array('action' => 'index'));
			$this->expire_cached_page(array('action' => 'read', 'id' => $_POST['post_id']));
			// Expires the cache of Comments feed
			$this->expire_cached_page(array('controller' => 'feed', 'action' => 'diario_comments', 'id' => $_POST['post_id']));

			$this->redirect_to(array('action' => 'read', 'id' => $_POST['post_id'], 'hash' => "comment-{$comment->id}"));
		}

		/**
		 *	@fn init_math_test
		 *	@short Filter method that initializes the Antispam math test for commenting articles.
		 */
		protected function init_math_test()
		{
			Antispam::init_math_test();
		}

		/**
		 *	@fn highlight_words
		 *	@short Filter method to highlight words that are search terms.
		 */
		protected function highlight_words()
		{
			if (isset($_REQUEST['term']) && !empty($_REQUEST['term']))
			{
				if (($pos = strpos($this->response->body, '<body')) !== FALSE)
				{
					$head = substr($this->response->body, 0, $pos);
					$tail = substr($this->response->body, $pos);

					$tail = preg_replace(
						"/>([^<]*)({$_REQUEST['term']})/ie",
						"'>\\1'.span('\\2',array('class'=>'highlighted'))",
						$tail);

					$this->response->body = $head . $tail;

				}
			}
		}
	}
?>
