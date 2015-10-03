<?php
	require_once(dirname(__FILE__) . "/diario_pingback.php");

	/**
	 *	@class SoftwarePingback
	 *	@short Model class for pingbacks to software products.
	 */
	class SoftwarePingback extends DiarioPingback
	{
		public function permalink($relative = TRUE)
		{
			if ($this->software)
			{
				return $this->software->url_to_detail('comments') .
					"?show_all=1#pingback-{$this->id}";
			}
		}
	}
?>