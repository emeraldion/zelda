<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../models/server_error.php");

	/**
	 *	@class ErrorController
	 *	@short Controller class for HTTP errors.
	 *	@details ErrorController is responsible for handling HTTP errors.
	 *	This is an improved version of the mainstream ErrorController class.
	 */
	class ErrorController extends EmeController
	{
		/**
		 *	@short Brief descriptions of HTTP error codes.
		 */
		public static $descriptions = array('404' => 'Not Found',
			'403' => 'Forbidden',
			'405' => 'Method Not Supported',
			'500' => 'Internal Server Error',
			);
			
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->after_filter(array('shrink_html', 'compress'));
		}
		
		public function index()
		{
			$this->redirect_to(array('controller' => 'home'));
		}
		
		/**
		 *	@fn _404
		 *	@short Handles 404 Not Found HTTP errors.
		 */
		public function _404()
		{
			//$this->generate_error(404);
		}

		/**
		 *	@fn _403
		 *	@short Handles 403 Forbidden HTTP errors.
		 */
		public function _403()
		{
			$this->generate_error(403);
		}

		/**
		 *	@fn _405
		 *	@short Handles 405 Method Not Supported HTTP errors.
		 */
		public function _405()
		{
			$this->generate_error(405);
		}

		/**
		 *	@fn _500
		 *	@short Handles 500 Internal Server Error HTTP errors.
		 */
		public function _500()
		{
			$this->generate_error(500);
		}

		/**
		 *	@fn generate_error($code)
		 *	@short Private common error handler.
		 *	@param code An error code.
		 */
		private function generate_error($code)
		{
			$desc = self::$descriptions[$code];
			header("HTTP/1.1 $code $desc");
			if (isset($_SESSION['error_processed']))
			{
				unset($_SESSION['error_processed']);
				return;
			}
			if ($code == 404)
			{
				return;
			}
			$error = new ServerError(array('code' => $code,
				'description' => var_export($_SERVER, TRUE),
				'occurred_at' => date('Y-m-d H:i:s')));
			$error->save();
		}
	}
?>