<?php
	require_once(dirname(__FILE__) . "/base.php");
	
	/**
	 *	@class IusethisEntry
	 *	@short Model object for software entries in the IUseThis website.
	 */
	class IusethisEntry extends ActiveRecord
	{
		const IUSETHIS_URL_FORMAT = "http://osx.iusethis.com/app/%s";
		
		// Permalinks are x-domains for this class, overriding
		public function permalink()
		{
			return sprintf(self::IUSETHIS_URL_FORMAT, $this->iusethis_name);
		}
	}
?>