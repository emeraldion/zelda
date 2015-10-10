<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/dateable.php");
	require_once(dirname(__FILE__) . "/approvable.php");
	require_once(dirname(__FILE__) . "/../helpers/markdown.php");
	
	/**
	 *	@class AbstractComment
	 *	@short Abstract superclass for comment model objects.
	 *	@details AbstractComment is an abstract ancestor for every comment-like
	 *	model class.
	 *	Comment objects contain a small text, are linked to an author (not necessarily
	 *	another model object) and can be permalinked.
	 */
	abstract class AbstractComment extends ActiveRecord implements Dateable, Approvable
	{
		protected function init($values)
		{
			if (isset($values['URL']) &&
				!empty($values['URL']) &&
				strpos($values['URL'], 'http://') !== 0)
			{
				$this->URL = 'http://' . $values['URL'];
			}
		}
		
		/**
		 *	@fn relative_url
		 *	@short Provides a relative URL for the comment object.
		 */
		public function relative_url()
		{
			return "#comment-{$this->id}";
		}
		
		/**
		 *	@fn comment_class
		 *	@short Provides a class name that depends on the status of the comment, useful for lists.
		 */
		public function comment_class()
		{
			static $row = 0;
			if (!$this->approved)
			{
				return "comment-pending";
			}
			$row = 1 - $row;
			return $row ? "comment-even" : "comment-odd";
		}
		
		/**
		 *	@fn pretty_text
		 *	@short Provides very basic markup modification to display text in HTML views.
		 *	@details Subclassers will likely improve this method to parse textile, markdown etc.
		 */
		public function pretty_text()
		{
			return Markdown($this->text);
		}
		
		/**
		 *	@fn human_readable_date
		 *	@short Returns a human readable date for the creation date of the receiver.
		 */
		public function human_readable_date()
		{
			return strftime("%A %e %B %Y %H:%M:%S", strtotime($this->created_at));
		}
		
		/**
		 *	@fn rfc2822_date
		 *	@short Returns a RFC2822 formatted date for the creation date of the receiver, useful for feeds.
		 */
		public function rfc2822_date()
		{
			return date('r', strtotime($this->created_at));
		}
		
		/**
		 *	@fn iso8601_date
		 *	@short Returns a ISO8601 formatted date for the creation date of the receiver, useful for  feeds.
		 */
		public function iso8601_date()
		{
			return date('c', strtotime($this->created_at));
		}
		
		/**
		 *	@fn sort_comments($a, $b)
		 *	@short Static function used to compare releases
		 */
		public static function sort_comments($a, $b)
		{
			return (strtotime($a->created_at) < strtotime($b->created_at)) ? -1 : 1;
		}
		
		/**
		 *	@fn approve
		 *	@short Sets the approved status.
		 */
		public function approve()
		{
			$this->approved = 1;
		}

		/**
		 *	@fn reject
		 *	@short Unsets the approved status.
		 */
		public function reject()
		{
			$this->approved = 0;
		}
		
		/**
		 *	@fn find_unapproved
		 *	@short Finds all elements whose approved status is false.
		 */
		public function find_unapproved()
		{
			return $this->find_all(array('where_clause' => "`approved` = '0'"));
		}
		
		/**
		 *	@fn find_approved
		 *	@short Finds all elements whose approved status is true.
		 */
		public function find_approved()
		{
			return $this->find_all(array('where_clause' => "`approved` = '1'"));
		}
	}
	
?>