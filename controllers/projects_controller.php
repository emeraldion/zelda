<?php
	require_once("eme_controller.php");

	/**
	 *	@class ProjectsController
	 *	@short Controller for the projects section.
	 */
	class ProjectsController extends EmeController
	{
		/**
		 *	@attr mimetype
		 *	@short A MIME type for the response.
		 */
		protected $mimetype = 'text/html; charset=iso-8859-1';

		protected function init()
		{
			// Call parent's init method
			parent::init();

			//$this->caches_page(array('index', 'read'));
			$this->before_filter(array('log_visit', 'block_ip'));
			$this->after_filter('shrink_html');
			$this->after_filter('compress');
		}

		public function index()
		{
      // $this->render(array('layout' => 'software', 'action' => 'index'));
		}
	}
?>
