<?php
	require_once('base_controller.php');
	require_once(dirname(__FILE__) . '/../models/visit.php');
	require_once(dirname(__FILE__) . '/../models/blocked_ip.php');
	require_once(dirname(__FILE__) . '/../models/blocked_visit.php');
	require_once(dirname(__FILE__) . '/../helpers/email.php');
	require_once(dirname(__FILE__) . '/../helpers/cookie.php');
	require_once(dirname(__FILE__) . '/../helpers/opengraph.php');
	require_once(dirname(__FILE__) . '/../helpers/time.php');
	require_once(dirname(__FILE__) . '/../helpers/morse.php');
	require_once(dirname(__FILE__) . '/../helpers/base64.php');
	require_once(dirname(__FILE__) . '/../helpers/sanskrit.php');

	/**
	 *	@class EmeController
	 *	@short Main controller class for the Emeraldion Lodge.
	 *	@details EmeController implements all default filters and shared functionality that
	 *	is specifically designed for the Emeraldion Lodge.
	 */
	class EmeController extends BaseController
	{
		/**
		 *	@short Flag that determines if the controller must log the visits.
		 */
		const LOG_VISITS = FALSE;

		/**
		 *	@short Flag that determines if the controller should block requests by IP address.
		 */
		const BLOCK_IPS = FALSE;

		/**
		 *	@attr credentials
		 *	@short User credentials.
		 */
		protected $credentials;

		/**
		 *	@short Keywords for the "Keywords" meta header.
		 */
		protected $keywords = array();

		/**
		 *	@short Description for the "Description" meta header.
		 */
		protected $description;

		protected function init()
		{
			parent::init();

			$this->set_title('Emeraldion Lodge');
			$this->set_description(l('Personal website of Claudio Procida, hosting my projects and my blog'));
			$this->credentials = $this->get_credentials();
			$this->set_fail_toast();

			$this->before_filter('init_opengraph');
		}

		public function index()
		{
		}

		/**
		 *	@short Sets the title for the current page.
		 *	@override
		 *	@param title A title for the current page.
		 */
		public function set_title($title)
		{
			$this->title = $this->opengraph->title = $title;
		}

		/**
		 *	@short Sets the description for the current page.
		 *	@override
		 *	@param description A description for the current page.
		 */
		public function set_description($description)
		{
			$this->description = $this->opengraph->description = $description;
		}

		/**
		 *	@fn set_credentials($realname, $email, $website)
		 *	@short Stores a set of credentials into a cookie using Base64 encoding.
		 *	@param realname The user's real name.
		 *	@param email The user's email address.
		 *	@param url The user's website URL.
		 */
		protected function set_credentials($realname = '', $email = '', $url = '')
		{
			$credentials = $realname . '%%' . $email . '%%' . $url;
			$encoded = Base64::encode($credentials);
			Cookie::set('_vc', $encoded, Time::next_year());
		}

		/**
		 *	@fn get_credentials
		 *	@short Returns a set of credentials previously stored into a cookie with Base64 encoding.
		 */
		protected function get_credentials()
		{
			$parts = array('', '', '');
			if (($encoded = Cookie::get('_vc')) !== NULL)
			{
				$credentials = Base64::decode($encoded);
				$parts = explode('%%', $credentials);
			}
			return array_combine(array('realname', 'email', 'url'), $parts);
		}

		/**
		 *	@fn check_auth
		 *	@short Filter method that checks authorization before accessing actions.
		 */
		protected function check_auth()
		{
			if (!Login::is_logged_in())
			{
				$_SESSION['redirect_to'] = array('controller' => $this->name, 'action' => $this->action);
				$this->flash('Login is required to access the page you requested!', 'warning');
				$this->redirect_to(array('controller' => 'login'));
			}
		}

		/**
		 *	@fn log_visit
		 *	@short Filter method that saves a Visit object for current request.
		 */
		protected function log_visit()
		{
			if (self::LOG_VISITS)
			{
				$visit = new Visit();
				$visit->save();
			}
		}

		/**
		 *	@fn block_ip
		 *	@short Filter method that interrupts response generation if the client IP is blacklisted.
		 */
		protected function block_ip()
		{
			// Return if BLOCK_IPS is not set
			if (!self::BLOCK_IPS) {
				return;
			}
			if (BlockedIp::is_blocked($_SERVER['REMOTE_ADDR']))
			{
				$bv = new BlockedVisit();
				$bv->save();
				die(l('Sorry, your IP address is currently blacklisted'));
			}
		}

		/**
		 *	@fn add_acronyms
		 *	@short Filter method that adds common acronyms.
		 */
		protected function add_acronyms()
		{
			$acronyms = array('URI' => 'Uniform Resource Identifier',
				'URL' => 'Uniform Resource Locator',
				'CSS' => 'Cascading Style Sheets',
				'JSP' => 'JavaServer Pages',
				'XML' => 'eXtensible Markup Language',
				'SMS' => 'Short Message System',
				'JSF' => 'JavaServer Faces',
				'HTTP' => 'HyperText Transfer Protocol',
				'GWT' => 'Google Web Toolkit');
			$patterns = array();
			$replacements = array();
			foreach ($acronyms as $acronym => $explanation)
			{
				$expl = h($explanation);
				$patterns[] = "/([^_\-a-z0-9])($acronym)([^_\-a-z0-9])/i";
				$replacements[] = "$1<acronym title=\"$expl\">$2</acronym>$3";
			}
			$this->response->body = preg_replace($patterns,
				$replacements,
				$this->response->body);
		}

		/**
		 *	@fn morse_encode
		 *	@short Filter method that converts response contents to Morse code.
		 */
		protected function morse_encode()
		{
			$this->response->body = preg_replace(
				array(
					'/-->/',
					'/\/\*/',
					'/\*\//',
					'/>([^<]*)</e',
					'/(alt|title|content)="([^"]*)"/e',
					'/���/',
					'/###/',
					'/%%%/',
				),
				array(
					'���',
					'###',
					'%%%',
					"'>'.Morse::encode('\\1').'<'",
					"'\\1=\"'.Morse::encode('\\2').'\"'",
					'-->',
					'/*',
					'*/',
				),
				$this->response->body);
		}

		/**
		 *	@fn shrink_html
		 *	@short Filter method that removes all unnecessary spaces from HTML output
		 */
		protected function shrink_html()
		{
			return;
			$this->response->body = preg_replace(
				array(
					'/\s+|\n/',
					'/>\s+</',
					"/> <(\/?)(p|link|meta|div|h|body|title|script|style|!--|ul|ol|li|dl|dd|dt|option|th|td|tr|table|tbody|thead|tfoot)/",
					"/<(p|link|meta|div|h|body|title|script|style|!--|ul|ol|li|dl|dd|dt|option|th|td|tr|table|tbody|thead|tfoot)([^>]*)> </",
				),
				array(
					' ',
					'> <',
					'><\1\2',
					'<\1\2><',
				),
				$this->response->body);
		}

		/**
		 *	@fn sanskrit_ambra
		 *	@short Filter method that converts response contents to Ambra Angiolini's "sanskrit".
		 *	@details This filter replaces all vowels with 'a', thus doing like Ambra Angiolini when
		 *	singing during the Italian TV show "Non � la Rai".
		 */
		protected function sanskrit_ambra()
		{
			$this->response->body = preg_replace(
				array(
					"/&([^;]+);/",
					"/>([^<]*)</e",
					"/<&([^;]+);>/",
				),
				array(
					"<&\\1;>",
					"'>'.Sanskrit::encode('\\1').'<'",
					"&\\1;",
				),
				$this->response->body);
		}

		/**
		 *	@fn init_opengraph
		 *	@short Filter method to initialize OpenGraph data.
		 */
		protected function init_opengraph()
		{
			$this->opengraph = new OpenGraph(array(
				'description' => $this->description,
				'image' => sprintf('http://%s/assets/images/claudio.jpg', $_SERVER['HTTP_HOST']),
				'title' => $this->title,
				'url' => $this->url_to_myself(FALSE),
				'type' => 'website',
			));
		}

		/**
		 *	@fn load_part_contents($filename)
		 *	@short Loads localized part contents from file.
		 *	@details Checks if a localized part file exists for the requested filename, otherwise
		 *	calls the superclass implementation.
		 *	@param filename The name of the part file.
		 *	@return The contents of the part file.
		 */
		protected function load_part_contents($filename)
		{
			$localized_filename = @preg_replace("/\.([^\.]+)$/",
				"-{$_COOKIE['hl']}.\\1",
				$filename);
			if (file_exists($localized_filename))
			{
				$contents = file_get_contents($localized_filename);
			}
			else
			{
				if (!file_exists($filename))
				{
					HTTP::error(500);
				}
				$contents = file_get_contents($filename);
			}
			return $this->strip_external_php_tags($contents);
		}

		/**
		 *	@fn include_localized($filename)
		 *	@short Includes a localized version of the requested filename if possible.
		 *	@details Checks if a localized version of the requested filename exists, otherwise
		 *	calls <tt>include</tt>.
		 *	@param filename The name of the file to be included.
		 */
		protected function include_localized($filename)
		{
			$localized_filename = @preg_replace("/\.([^\.]+)$/",
				"-{$_COOKIE['hl']}.\\1",
				$filename);
			if (file_exists($localized_filename))
			{
				include($localized_filename);
			}
			else
			{
				if (!file_exists($filename))
				{
					HTTP::error(500);
				}
				include($filename);
			}
		}

		protected function set_fail_toast()
		{
			$this->old_error_handler = set_error_handler(array($this, 'fail_toast'));
		}

		public function fail_toast($errno, $errstr, $errfile, $errline)
		{
			if (!(error_reporting() & $errno)) {
				// This error code is not included in error_reporting, so let it fall
				// through to the standard PHP error handler
				return FALSE;
			}

			switch ($errno) {
				case E_USER_ERROR:
					$this->redirect_to(array('controller' => 'error', 'action' => '503'));
					return TRUE;
			}

			// Don't execute PHP internal error handler
			return FALSE;
		}
	}
?>
