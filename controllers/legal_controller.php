<?php
	require_once("eme_controller.php");

	/**
	 *	@class LegalController
	 *	@short Controller for the legal notices in the website.
	 */
	class LegalController extends EmeController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->before_filter(array('log_visit', 'block_ip'));
			$this->after_filter(array('shrink_html', 'compress'));
		}

		public function index()
		{
			$this->redirect_to(array('action' => 'disclaimer'));
		}

		/**
		 *	@fn disclaimer
		 *	@short Action method that shows a disclaimer for the usage of the website.
		 */
		public function disclaimer()
		{
		}
	}
?>