<?php
	require_once("diario_controller.php");

	/**
	 *	@class BlogController
	 *	@short Controller for the (no longer existing) Blog section.
	 *	@details This class exists for retrocompatibility reasons.
	 */
	class BlogController extends DiarioController
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