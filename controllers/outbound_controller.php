<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../models/outbound.php");

	/**
	 *	@class OutboundController
	 *	@short Controller for outbound traffic.
	 *	@details This controller is responsible for logging all clicks on
	 *	external links.
	 */
	class OutboundController extends EmeController
	{
		/**
		 *	@short Flag that determines if the controller must log the outbound URLs.
		 */
		const OUTBOUND_LOG_URLS = TRUE;
		
		public function index()
		{
			if (isset($_REQUEST['url']))
			{
				if (self::OUTBOUND_LOG_URLS)
				{
					$outbound = new Outbound($_REQUEST);
					$outbound->gate = @$_SERVER['HTTP_REFERER'];
					$outbound->save();
				}
				$this->redirect_to($_REQUEST['url']);
			}
			$this->redirect_to(array('controller' => 'home'));
		}
	}
?>