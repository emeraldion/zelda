<?php

	/**
	 *	@interface Approvable
	 *	@short Defines methods that are useful for objects that can be approved (e.g. user comments).
	 */
	interface Approvable
	{
		/**
		 *	@fn approve
		 *	@short Sets the approved status.
		 */
		public function approve();

		/**
		 *	@fn reject
		 *	@short Unsets the approved status.
		 */
		public function reject();
		
		/**
		 *	@fn find_unapproved
		 *	@short Finds all elements whose approved status is false.
		 */
		public function find_unapproved();
		
		/**
		 *	@fn find_approved
		 *	@short Finds all elements whose approved status is true.
		 */
		public function find_approved();
	}

?>