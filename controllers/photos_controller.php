<?php
	require_once("base_controller.php");

	/**
	 *	@class PhotosController
	 *	@short Redirector to the collection of photos.
	 */
	class PhotosController extends BaseController
	{
		/**
		 *	@fn init
		 *	@short Initialization method for the Controller.
		 *	@details This method simply redirects to Flickr.
		 */
		protected function init()
		{
			// Call parent's init method
			parent::init();

			$this->redirect_to('https://flickr.com/claudiopro');
		}
	}
?>
