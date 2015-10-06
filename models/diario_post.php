<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/tag.php");
	require_once(dirname(__FILE__) . "/dateable.php");
	require_once(dirname(__FILE__) . "/sortable.php");
	require_once(dirname(__FILE__) . "/approvable.php");
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../include/common.inc.php");
	require_once(dirname(__FILE__) . "/../include/tag_support.inc.php");

	/**
	 *	@class DiarioPost
	 *	@short Model object for Diario articles.
	 */
	class DiarioPost extends ActiveRecord implements Dateable, Approvable, Sortable
	{
		protected $foreign_key_name = 'post_id';

		function relative_url()
		{
			return $this->is_external() ?
				sprintf("diario/go/%s", $this->id) :
				sprintf("diario/read/%s", $this->id);
		}

		/**
		 *	@fn is_external
		 *	@short Returns true if the post is external
		 */
		function is_external()
		{
			return $this->external_url != NULL;
		}

		/**
		 *	@fn approve
		 *	@short Sets the approved status.
		 */
		public function approve()
		{
			$this->status = 'approvato';
		}

		/**
		 *	@fn reject
		 *	@short Unsets the approved status.
		 */
		public function reject()
		{
			$this->status = 'rimosso';
		}

		/**
		 *	@fn find_unapproved
		 *	@short Finds all elements whose approved status is false.
		 */
		public function find_unapproved()
		{
			return $this->find_all(array('where_clause' => "`status` != 'approvato'"));
		}

		/**
		 *	@fn find_approved
		 *	@short Finds all elements whose approved status is true.
		 */
		public function find_approved()
		{
			return $this->find_all(array('where_clause' => "`status` = 'approvato'"));
		}

		/**
		 *	@fn trackback_url
		 *	@short URL for trackback for this article.
		 *	@note This URL is absolute.
		 */
		public function trackback_url()
		{
			return sprintf("http://%s%strackback/diario/%s",
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->id);
		}

		/**
		 *	@fn comments_permalink()
		 *	@short URL for the comments for this article.
		 *	@note This URL is absolute.
		 */
		public function comments_permalink()
		{
			return $this->permalink(FALSE) . '#comments';
		}

		/**
		 *	@fn rfc2822_date
		 *	@short Returns a RFC2822 formatted date for the date of the receiver, useful for feeds.
		 */
		public function rfc2822_date()
		{
			return date('r', strtotime($this->created_at));
		}

		/**
		 *	@fn iso8601_date
		 *	@short Returns a ISO8601 formatted date for the date of the receiver, useful for  feeds.
		 */
		public function iso8601_date()
		{
			return date('c', strtotime($this->created_at));
		}

		/**
		 *	@fn human_readable_date
		 *	@short Returns a human readable date for the date of the receiver.
		 */
		public function human_readable_date()
		{
			return strftime("%A %e %B %Y %H:%M", strtotime($this->created_at));
		}

		/**
		 *	@fn get_stripped_text
		 *	@short Strips HTML tags from the article text.
		 */
		public function get_stripped_text()
		{
			return strip_tags($this->text);
		}

		/**
		 *	@fn summary
		 *	@short Returns a plain text summary for the article, with a link to the full version.
		 *	@details This method returns a summary of the article text, truncated to
		 *	a maximum length, with a trailing link to the full article.
		 *	@param relative Set to <tt>TRUE</tt> if you want a relative URL, <tt>FALSE</tt> if you want a full URL.
		 */
		public function summary($relative = TRUE)
		{
			$stripped = $this->get_stripped_text();
			$off = strpos($stripped, " ", min(250, strlen($stripped)));
			if ($off !== FALSE)
			{
				return substr($stripped, 0, $off) . "&hellip; " .
					a(l('Read more'), array('href' => $this->permalink($relative)));
			}
			return $stripped;
		}

		/**
		 *	@fn comma_separated_tags
		 *	@short Returns the list of tags for the receiver, separated by commas.
		 */
		public function comma_separated_tags()
		{
			$tags = $this->tags;
			return Tag::join($tags);
		}

		/**
		 *	@fn sort_posts($a, $b)
		 *	@short Static function used to compare releases.
		 */
		public static function sort_posts($a, $b)
		{
			return (strtotime($a->created_at) > strtotime($b->created_at)) ? -1 : 1;
		}

		/**
		 *	@fn previous
		 *	@short Returns the item that precedes the receiver in the order.
		 */
		public function previous()
		{
			$conn = Db::get_connection();
			$factory = new self();
			$results = $factory->find_all(array('where_clause' => "`created_at` < '{$conn->escape($this->created_at)}' " .
				"AND `status` = 'pubblicato'",
				'order_by' => '`created_at` DESC',
				'limit' => 1));
			$ret = count($results) > 0 ? $results[0] : NULL;
			Db::close_connection($conn);
			return $ret;
		}

		/**
		 *	@fn next
		 *	@short Returns the item that succeeds the receiver in the order.
		 */
		public function next()
		{
			$conn = Db::get_connection();
			$factory = new self();
			$results = $factory->find_all(array('where_clause' => "`created_at` > '{$conn->escape($this->created_at)}' " .
				"AND `status` = 'pubblicato'",
				'order_by' => '`created_at` ASC',
				'limit' => 1));
			$ret = count($results) > 0 ? $results[0] : NULL;
			Db::close_connection($conn);
			return $ret;
		}
	}
?>
