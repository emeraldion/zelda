<?php
	require_once(dirname(__FILE__) . "/registration.php");
	require_once(dirname(__FILE__) . "/../helpers/singular_license.php");
	
	/**
	 *	@class SingularRegistration
	 *	@short Model object for registrations of the Singular application.
	 *	@details Object of class Registration represent the event of a user registering a software.
	 *	A license object for the user is automatically created and carried along.
	 */
	class SingularRegistration extends Registration
	{
		// All registrations should go in the same table.
		// 'Single table inheritance'?
		protected $table_name = 'registrations';
		
		protected $license_class = 'SingularLicense';
		
		protected function init($values)
		{
			if (!empty($values['username']))
			{
				// Creates a default license for the username
				$this->generate_license();
			}
		}
		
		/**
		 *	@fn generate_license
		 *	@short Requests that the license for the registration be generated.
		 */		
		public function generate_license()
		{
			$key = call_user_func(array($this->license_class, 'generate_key'),
				$this->username,
				$this->registered_on,
				$this->expires_on,
				$this->license_type);
			$this->license = new $this->license_class($this->username,
				$this->email,
				$key);
		}
	}
?>