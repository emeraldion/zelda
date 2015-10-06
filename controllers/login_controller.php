<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../models/user.php");
	require_once(dirname(__FILE__) . "/../models/user_login.php");
	require_once(dirname(__FILE__) . "/../models/password_request.php");
	require_once(dirname(__FILE__) . "/../helpers/cookie.php");
	require_once(dirname(__FILE__) . "/../helpers/time.php");
	require_once(dirname(__FILE__) . "/../helpers/login.php");
	require_once(dirname(__FILE__) . "/../helpers/antispam.php");

	/**
	 *	@class LoginController
	 *	@short Controller that manages all authentication related tasks such as login,
	 *	logout and password retrieval.
	 */
	class LoginController extends EmeController
	{
		function init()
		{
			// Call parent's init method
			parent::init();

			$this->before_filter(array('log_visit', 'block_ip'));
		}

		/**
		 *	@fn login
		 *	@short Action method to perform a login.
		 */
		function login()
		{
			if ($this->request->is_post())
			{
				$conn = Db::get_connection();

				$user_factory = new User();

				$users = $user_factory->find_all(array('where_clause' => "`username` = '{$conn->escape($_POST['username'])}' AND `password` = '" . md5($_POST['password']) . "'", 'limit' => 1));

				if (count($users) > 0)
				{
					$user = $users[0];

					$expires = $_POST['leave_me_registered'] ? Time::next_year() : Time::tomorrow();

					Cookie::set('_u', $user->username, $expires, "/", FALSE);
					Cookie::set('_uid', md5(Login::magic_phrase . $user->password), $expires, "/", FALSE);

					// Annotates the login in the database
					$user_login = new UserLogin();
					$user_login->user_id = $user->id;
					$user_login->performed_at = date("Y-m-d H:i:s");
					$user_login->save();

					$this->flash(sprintf(l('Welcome, %s'), $user->first), 'info');

					// When login is required to access a particular action, we may store controller & action in a session,
					// perform login, then redirect to the action requested in the first place
					if (isset($_SESSION['redirect_to']))
					{
						$this->redirect_to(array('controller' => $_SESSION['redirect_to']['controller'],
							'action' => $_SESSION['redirect_to']['action']));
					}
					else
					{
						$this->redirect_to(array('controller' => 'home'));
					}

					Db::close_connection($conn);
				}
				else
				{
					$this->flash(l('Bad username / password'), 'error');
				}
			}
			$this->redirect_to(array('action' => 'index'));
		}

		/**
		 *	@fn logout
		 *	@short Action method that logs out a user.
		 */
		function logout()
		{
			Cookie::delete('_u');
			Cookie::delete('_uid');

			$this->flash(l('Logout was performed successfully'), 'message');
			$this->redirect_to(array('controller' => 'home'));
		}

		/**
		 *	@fn lost_password
		 *	@short Action method to request a new password.
		 */
		function lost_password()
		{
			$this->set_title("Emeraldion Lodge .o. " . l('Retrieve lost password'));

			Antispam::init_math_test();
		}

		/**
		 *	@fn request_password
		 *	@short Action method to send a new password to a registered user.
		 */
		function request_password()
		{
			if (!Antispam::check_math())
			{
				$this->flash(Antispam::random_comment(), 'error');
				$this->redirect_to(array('action' => 'lost_password'));
			}
			$user_factory = new User();
			$users = $user_factory->find_all(array('where_clause' => "`email` = '{$_POST['email']}'", 'limit' => 1));
			if (count($users) > 0)
			{
				$user = $users[0];

				$request = new PasswordRequest();
				$request->user_id = $user->id;
				$request->created_at = date("Y-m-d H:i:s");
				$request->hash = md5($request->created_at . $request->user_id . 'Questa non la sai');
				$request->save();

				$this->redirect_to(array('action' => 'request_sent'));
			}
			$this->flash(l('No such user'), 'error');
			$this->redirect_to(array('action' => 'lost_password'));
		}

		/**
		 *	@fn request_sent
		 *	@short Action method to show the results of a password request.
		 */
		function request_sent()
		{
			$this->redirect_to(array('controller' => 'home', 'after' => 10));
		}
	}
?>
