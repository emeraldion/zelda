<?php

	/**
	 *	@interface Sortable
	 *	@short Defines methods that are useful for objects that can be sorted and ordered.
	 */
	interface Sortable
	{
		/**
		 *	@fn previous
		 *	@short Returns the item that precedes the receiver in the order.
		 */
		public function previous();

		/**
		 *	@fn next
		 *	@short Returns the item that succeeds the receiver in the order.
		 */
		public function next();
	}

?>