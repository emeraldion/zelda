<?php
	require_once(dirname(__FILE__) . "/download.php");
	
	/**
	 *	@class SoftwareDownload
	 *	@short Model class for downloads of software artifacts.
	 */
	class SoftwareDownload extends Download
	{
		protected function init($values)
		{
			if (!isset($values['date']))
			{
				$this->date = date('Y-m-d H:i:s');
			}
		}
	}
?>