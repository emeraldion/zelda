<?php

	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../models/user.php");

	/**
	 *	@class Login
	 *	@short Helper class for authentication tasks.
	 */
	class Login
	{
		/**
		 *	@attr magic_phrase
		 *	@short Secret phrase used in hash generation.
		 */
		const magic_phrase = "Nei boschi a Rumiai";

		/**
		 *	@attr logged_in
		 *	@short Set to <tt>TRUE</tt> if the current user is authenticated.
		 */
		public static $logged_in;

		/**
		 *	@attr is_logged_in
		 *	@short Returns <tt>TRUE</tt> if the current user is authenticated.
		 *	@details This method queries the database to detect if the current user is authenticated
		 *	and then caches the result to speed up subsequent calls.
		 */
		static function is_logged_in()
		{
			if (!isset(Login::$logged_in))
			{
				Login::$logged_in = FALSE;
				if (!empty($_COOKIE['_u']))
				{
					$conn = Db::get_connection();

					$user_factory = new User();
					$users = $user_factory->find_all(array('where_clause' => "`username` = '{$conn->escape($_COOKIE['_u'])}'", 'limit' => 1));
					if (count($users) > 0)
					{
						$user = $users[0];
						Login::$logged_in = md5(self::magic_phrase . $user->password) == @$_COOKIE['_uid'];
					}
					
					Db::close_connection($conn);
				}
			}
			return Login::$logged_in;
		}
	}

?>
