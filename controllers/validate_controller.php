<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../helpers/email.php");
	
	/**
	 *	@class ValidateController
	 *	@short Controller class for common validation checks.
	 *	@details ValidateController provides validation services to all controllers, returning JSON data
	 *	about the validation results.
	 */
	class ValidateController extends EmeController
	{
		protected $mimetype = 'text/json';
		protected $type = 'json';
		
		public function index()
		{
		}
		
		/**
		 *	@fn validate_email()
		 *	@short Validates an email address.
		 *	@details Checks if an email address provided as input is valid.
		 */
		public function validate_email()
		{
			die("{email:'{$_REQUEST['email']}', valid:" .
				(Email::is_valid($_REQUEST['email']) ? 'true' : 'false') .
				"}");
		}
	}
?>