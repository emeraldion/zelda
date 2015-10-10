<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../helpers/cookie.php");
	require_once(dirname(__FILE__) . "/../helpers/time.php");

	/**
	 *	@class LanguageController
	 *	@short Controller for language management.
	 */
	class LanguageController extends EmeController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->before_filter('log_visit');
		}
		
		/**
		 *	@fn set
		 *	@short Action method to set the user's home language.
		 */
		public function set()
		{
			$lang = isset($_REQUEST['id']) ? $_REQUEST['id'] : 'en';
			Cookie::set('hl', $lang, Time::next_year(), '/');
			$this->redirect_to_referrer();
			$this->redirect_to(array('controller' => 'home'));
		}
	}
?>