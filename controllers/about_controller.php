<?php
	require_once("eme_controller.php");

	/**
	 *	@class AboutController
	 *	@short Controller for the About section.
	 *	@details The About section collects information pages that illustrate
	 *	the website, the technologies it relies upon, and something about the author.
	 */
	class AboutController extends EmeController
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

			$this->before_filter(array('log_visit', 'block_ip'));
			if (
				@$_GET['hl'] == 'morse' ||
				@$_COOKIE['hl'] == 'morse')
			{
				$this->after_filter('morse_encode');
			}
			else if (
				@$_GET['hl'] == 'sanskrit' ||
				@$_COOKIE['hl'] == 'sanskrit')
			{
				$this->after_filter('sanskrit_ambra');
			}
			$this->after_filter('shrink_html');
			$this->after_filter('compress');
		}

		/**
		 *	@fn index
		 *	@short Default action method.
		 *	@details This method simply performs a redirection to the action <tt>claudio</tt>.
		 */
		public function index()
		{
			$this->redirect_to(array('action' => 'claudio'));
		}

		/**
		 *	@fn claudio
		 *	@short Action method that shows info on Claudio.
		 */
		public function claudio()
		{
		}

		/**
		 *	@fn emeraldion_lodge
		 *	@short Action method that shows info on the Emeraldion Lodge website.
		 */
		public function emeraldion_lodge()
		{
		}

		/**
		 *	@fn emerails
		 *	@short Action method that shows info on the EmeRails framework.
		 */
		public function emerails()
		{
		}

		/**
		 *	@fn primula_toggle
		 *	@short Just records the click on the primula toggler.
		 */
		public function primula_toggle()
		{
			$this->render(NULL);
		}

		/**
		 *	@fn joke
		 *	@short Filter method that replaces "Emeraldion Lodge" with "Emilio Fede"
		 *	in the response body.
		 */
		public function joke()
		{
			$this->response->body = str_replace("Emeraldion Lodge", "Emilio Fede", $this->response->body);
		}
	}
?>
