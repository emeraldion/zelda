<?php
	require_once(dirname(__FILE__) . "/base.php");
	
	/**
	 *	@class GoogleGroupsEntry
	 *	@short Model class for Google Groups associated to software products.
	 */
	class GoogleGroupsEntry extends ActiveRecord
	{
		// Permalinks are x-domains for this class, overriding
		public function permalink()
		{
			return $this->url;
		}
	}
?>