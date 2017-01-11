<?php
	require_once(dirname(__FILE__) . "/base.php");

	/**
	 *	@class Talk
	 *	@short Edit this model's short description
	 *	@details Edit this actions's detailed description
	 */
	class Talk extends ActiveRecord
	{
		public function pretty_date()
		{
			return strftime("%A %e %B %Y", strtotime($this->date));
		}
	}
?>