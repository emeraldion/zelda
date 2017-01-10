<?php
	require_once('eme_controller.php');

	/**
	 *	@class AssetController
	 *	@short Controller for asset retrieval and inherent optimizations.
	 *	@details The Asset controller tries to save bandwidth by compressing the plain text resources
	 *	(e.g. CSS stylesheets, Javascript source code, etc.)
	 */
	class AssetController extends EmeController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			$this->after_filter('rewrite', 'compress');
		}
		
		public function index()
		{
			switch ($_GET['ext'])
			{
				case 'js':
					$this->mimetype = 'application/x-javascript';
					break;
				case 'rss':
					$this->mimetype = 'application/rss+xml';
					break;
				case 'xml':
					$this->mimetype = 'text/xml';
					break;
				case 'css':
					$this->mimetype = 'text/css';
					break;
				default:
					$this->mimetype = 'text/plain';
			}
			$asset_file = dirname(__FILE__) . '/../assets/' . $_GET['dir'] . '/' . $_GET['file'] . '.' . $_GET['ext'];
			
			$this->response->body = file_get_contents($asset_file);

			$this->response->add_header('Content-Type', $this->mimetype);
			$this->response->add_header('Cache-Control', 'max-age=86400');
			$this->response->add_header('Pragma', 'max-age=86400');
			$this->response->add_header('Last-Modified', gmstrftime('%a, %d %b %Y %H:%M:%S %Z', filemtime($asset_file)));
			$this->response->add_header('Date', gmstrftime('%a, %d %b %Y %H:%M:%S %Z'));
			$this->response->add_header('Expires', gmstrftime('%a, %d %b %Y %H:%M:%S %Z', time() + 86400));

			$this->render(NULL);
		}

		protected function rewrite()
		{
			if (APPLICATION_ROOT !== '/')
			{
				$this->response->body = preg_replace('/\/assets\//i', APPLICATION_ROOT . 'assets/', $this->response->body);
			}
		}
	}
?>