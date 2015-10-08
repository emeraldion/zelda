<?php
	require_once("diario_controller.php");

	/**
	 *	@class HomeController
	 *	@short Controller for the Homepage of the website.
	 */
	class HomeController extends DiarioController
	{
		/**
		 *	@fn init
		 *	@short Initialization method for the Controller.
		 *	@details This method simply redirects to the Diario controller.
		 */
		protected function init()
		{
			// Call parent's init method
			parent::init();

			$this->redirect_to(array('controller' => 'diario', 'action' => @$_REQUEST['action'], 'id' => @$_REQUEST['id']));
		}
	}
?>
