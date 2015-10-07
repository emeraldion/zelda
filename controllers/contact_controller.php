<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../helpers/contact_email.php");
	require_once(dirname(__FILE__) . "/../helpers/cookie.php");
	require_once(dirname(__FILE__) . "/../helpers/time.php");
	require_once(dirname(__FILE__) . "/../helpers/antispam.php");

	/**
	 *	@class ContactController
	 *	@short Controller for contact and mailing communication actions.
	 */
	class ContactController extends EmeController
	{
		/**
		 *	@fn init
		 *	@short Initialization method for the Controller.
		 *	@details Here you can define custom filters, caching strategies etc.
		 */
		protected function init()
		{
			// Call parent's init method
			parent::init();

			$this->before_filter(array('block_ip', 'log_visit'));
			$this->after_filter(array('shrink_html', 'compress'));
		}

		/**
		 *	@fn index
		 *	@short Default action method.
		 */
		public function index()
		{
			//$this->redirect_to(array('action' => 'index', 'after' => 3));
			$this->set_title("Emeraldion Lodge .o. " . l('Contact'));
		}

		/**
		 *	@fn report
		 *	@short Reports an issue with the site
		 */
		public function report()
		{
			header("Location: https://github.com/emeraldion/zelda/issues/new");
			exit();
		}

		/**
		 *	@fn send
		 *	@short Sends the contact email if validation passes.
		 *	@details This method creates a contact email with the post data submitted by the user
		 *	and delivers it to the website owner. Cookies are set for the user details if the <tt>remember_me</tt>
		 *	flag has been set.
		 *	If any of the validation steps fails, it performs a redirection to the action <tt>index</tt>.
		 *	A redirection to the action <tt>thank_you</tt> is performed on success.
		 */
		public function send()
		{
			if (!$this->request->is_post())
			{
				$this->redirect_to(array('action' => 'index'));
			}

			if (!Email::is_valid($_POST['email']))
			{
				$this->flash(l('Please enter a valid email address'), 'error');
				$this->redirect_to(array('action' => 'index'));
			}

			if (!Antispam::check_math())
			{
				$this->flash(Antispam::random_comment(), 'error');
				$this->redirect_to(array('action' => 'index'));
			}
			// A static class method would be infinitely better...
			$contact_email = new ContactEmail($_POST);
			$contact_email->send();

			if (isset($_POST['remember_me']))
			{
				$this->set_credentials($_POST['name'],
					$_POST['email'],
					$_POST['URL']);
			}
			$this->redirect_to(array('action' => 'thank_you'));
		}

		/**
		 *	@fn thank_you
		 *	@short Shows thankfulness to the user for the contact email.
		 *	@details A delayed redirection to the <tt>Home</tt> controller is performed here.
		 */
		public function thank_you()
		{
			$this->redirect_to(array('controller' => 'home', 'after' => 10));
		}
	}
?>
