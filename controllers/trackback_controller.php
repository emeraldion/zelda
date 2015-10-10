<?php
	require_once("eme_controller.php");
	require_once(dirname(__FILE__) . "/../models/diario_pingback.php");
	require_once(dirname(__FILE__) . "/../models/software_pingback.php");
	require_once(dirname(__FILE__) . "/../helpers/http.php");
	require_once(dirname(__FILE__) . "/../helpers/trackback.php");
	
	/**
	 *	@class TrackbackController
	 *	@short Controller for Trackback actions.
	 *	@details Trackback is a blogging feature that allows a blog to be notified about other blogs
	 *	quoting a post in an article. Trackback "pings" contain information on the blog name, post URL
	 *	and an excerpt of the article.
	 *	It became suddenly such a source of SPAM, that the term SPING (SPAM Ping) was created.
	 *	Trackback pings are now commonly subject to moderation (either manual or automatic).
	 */
	class TrackbackController extends EmeController
	{
		function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->before_filter(array('block_ip', 'log_visit'));
		}
		
		/**
		 *	@fn diario
		 *	@short Action for accepting pingbacks for the Diario blog.
		 */
		function diario()
		{
			if (!this->request->is_post())
			{
				$this->redirect_to(array('controller' => 'diario', 'action' => 'read', 'id' => $_REQUEST['id']));
			}
			
			$trackback = new TrackBack('Emeraldion Lodge - Diario', 'claudio');
			
			$pingback = new DiarioPingback();

			$pingback->post_id = $trackback->get_id; // The id of the item being trackbacked
			$pingback->url = $trackback->url; // The URL from which we got the trackback
			$pingback->title = $trackback->title; // Subject/title send by trackback
			$pingback->excerpt = $trackback->excerpt; // Short text send by trackback			
			
			if ($pingback->save())
			{
				// Logged successfully...
				echo $trackback->receive(TRUE);
			}
			else
			{
				// Something went wrong...
				echo $trackback->receive(FALSE, l('Trackbacks are currently disabled'));
			}
			exit();
		}
		
		/**
		 *	@fn software
		 *	@short Action for accepting pingbacks for Software products.
		 */
		public function software()
		{
			if (!this->request->is_post())
			{
				$this->redirect_to(array('controller' => 'software', 'action' => 'show', 'id' => $_REQUEST['id']));
			}
			
			$trackback = new TrackBack('Emeraldion Lodge - Software', 'claudio');
			
			$pingback = new SoftwarePingback();

			$pingback->software_id = $trackback->get_id; // The id of the item being trackbacked
			$pingback->url = $trackback->url; // The URL from which we got the trackback
			$pingback->title = $trackback->title; // Subject/title send by trackback
			$pingback->excerpt = $trackback->excerpt; // Short text send by trackback			
			
			if ($pingback->save())
			{
				// Logged successfully...
				echo $trackback->receive(TRUE);
			}
			else
			{
				// Something went wrong...
				echo $trackback->receive(FALSE, l('Trackbacks are currently disabled'));
			}
			exit();
		}
		
		/**
		 *	@fn require_post
		 *	@short Simple filter method that triggers a 405 error when using a method other than POST.
		 */
		protected function require_post()
		{
			if (!$this->request->is_post())
			{
				HTTP::error(405, array('Allow', 'POST'));
			}
		}
	}
?>