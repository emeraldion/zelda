<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../helpers/morse.php");

	/**
	 *	@class MorseController
	 *	@short Controller for Morse encoding / decoding actions.
	 *	@details This controller is just a proof of concept to illustrate EmeRails filtering capabilities.
	 */
	class MorseController extends EmeController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->before_filter(array('log_visit', 'block_ip'));
			$this->after_filter('my_morse_encode', array('only' => 'encode'));
			$this->after_filter('my_morse_decode', array('only' => 'decode'));
			$this->after_filter('shrink_html');
			$this->after_filter('compress');
		}
		
		public function index()
		{
		}
		
		/**
		 *	@fn encode
		 *	@short Action method to encode in Morse code the request.
		 */
		public function encode()
		{
			$this->render(array('layout' => FALSE));
		}
		
		/**
		 *	@fn decode
		 *	@short Action method to decode the request from Morse code.
		 */
		public function decode()
		{
			$this->render(array('layout' => FALSE));
		}

		/**
		 *	@fn my_morse_encode
		 *	@short Filter method to encode a plain text response body to Morse code
		 */
		protected function my_morse_encode()
		{
			$this->response->body =
				Morse::encode($this->response->body);
			$this->response->body =
				preg_replace(array(
					"/\./",
					"/\-/",
					),
					array(
					"&middot;",
					"&mdash;",
					),
					$this->response->body);
		}
		
		/**
		 *	@fn my_morse_decode
		 *	@short Filter method to decode a Morse encoded response body to plain text.
		 */
		protected function my_morse_decode()
		{
			$this->response->body =
				Morse::decode($this->response->body);
		}
	}
?>