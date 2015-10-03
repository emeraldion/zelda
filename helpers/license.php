<?php
	/**
	 *	@class License
	 *	@short Abstract helper class to handle software licenses.
	 */
	class License
	{
		/**
		 *	@short The user who owns this license.
		 */
		public $username;

		/**
		 *	@short The email address of the license owner.
		 */
		public $email;
		
		/**
		 *	@short The key of the license.
		 */
		public $key;
		
		/**
		 *	@short The type of the license.
		 */
		public $license_type;
		
		/**
		 *	@short The validity date of the license.
		 */
		public $registration_date;
		
		/**
		 *	@short The expiration date of the license.
		 */
		public $expiration_date;
		
		/**
		 *	@fn is_valid
		 *	@short Tells if this license is valid.
		 *	@details A license is valid when:
		 *	@li The key is valid for the username.
		 *	@li The validity date is in the past.
		 *	@li The expiration date is in the future.
		 */
		public function is_valid()
		{
			return call_user_func(array(get_class($this), 'valid_key'),
				$this->key,
				$this->username);
		}
		
		/**
		 *	@fn generate_key($username, $registration_date, $expiration_date, $license_type)
		 *	@short Generates a key for a license.
		 */
		public static function generate_key($username,
			$registration_date = NULL,
			$expiration_date = NULL,
			$license_type = NULL)
		{
			return NULL;
		}
		
		/**
		 *	@fn function valid_key($key, $username, $cleartext)
		 *	@short Validates a key.
		 */
		public static function valid_key($key,
			$username = '',
			&$cleartext = NULL)
		{
			return FALSE;
		}
	}

?>