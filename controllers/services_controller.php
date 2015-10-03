<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../models/software_artifact.php");

	/**
	 *	@class ServicesController
	 *	@short Controller for the Services section.
	 */
	class ServicesController extends EmeController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->before_filter('log_visit');
			$this->after_filter(array('shrink_html', 'compress'));
		}
		
		public function index()
		{
		}
	}
?>