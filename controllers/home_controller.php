<?php
	require_once("eme_controller.php");

	/**
	 *	@class HomeController
	 *	@short Controller for the Homepage of the website.
	 */
	class HomeController extends EmeController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->before_filter(array('log_visit', 'block_ip'));
			$this->after_filter('shrink_html');
			$this->after_filter('compress');
		}
		
		public function index()
		{
		}
	}
?>