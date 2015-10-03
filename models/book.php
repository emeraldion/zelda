<?php
	require_once(dirname(__FILE__) . '/base.php');
	require_once(dirname(__FILE__) . '/../include/tag_support.inc.php');
	
	/**
	 *	@class Book
	 *	@short Model object for books.
	 *	@details Book objects represent printed publications that I have read.
	 */
	class Book extends ActiveRecord
	{
		/**
		 *	@fn permalink
		 *	@short Creates a permalink anchor for this book.
		 *	@details This method should be refactored to make use of the canonical relative_url / permalink pair.
		 */
		public function permalink()
		{
			if (empty($this->bol_id) || empty($this->bol_category))
			{
				echo $this->long_description();
			}
			else
			{
				print a($this->long_description(), array('href' => $this->bol_url(), 'class' => 'external'));
			}
		}
		
		/**
		 *	@fn bol_url
		 *	@short Returns the URL of the bol.it book page for the receiver.
		 */
		public function bol_url()
		{
			return 'http://www.bol.it/' . $this->bol_category . '/scheda/' . $this->bol_id . '.html';
		}
		
		/**
		 *	@fn long_description
		 *	@short Returns a detailed description of the receiver.
		 */
		public function long_description()
		{
			return $this->author . '&mdash; <em>' . $this->title . '</em>, ' . $this->editor;
		}
	}
?>