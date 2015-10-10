<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../helpers/paypal.php");

	/**
	 *	@class DonateController
	 *	@short Controller to manage donation related actions.
	 */
	class DonateController extends EmeController
	{
		function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->before_filter('log_visit');
		}
		
		function index()
		{
			$this->set_title("Emeraldion Lodge - Donate");
		}
	}
?>