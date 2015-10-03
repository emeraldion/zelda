<?php
	require_once('asset_controller.php');
	require_once(dirname(__FILE__) . '/../config/styles.conf.php');

	/**
	 *	@class StylesController
	 *	@short Controller for serving Styles content.
	 */
	class StylesController extends AssetController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
		}
		
		public function index()
		{
			$this->common();
		}
		
		public function common()
		{
			global $css_files;
			
			$this->mimetype = 'text/css';
			$this->response->body = '';
			$mtime = 0;
			foreach ($css_files as $css_file)
			{
				$css_file = dirname(__FILE__) . '/../' . $css_file;
				$mtime = max($mtime, filemtime($css_file));
				$this->response->body .= file_get_contents($css_file);
			}
			$this->response->add_header('Content-Type', $this->mimetype);
			$this->response->add_header('Cache-Control', 'max-age=86400');
			$this->response->add_header('Pragma', 'max-age=86400');
			$this->response->add_header('Last-Modified', gmstrftime('%a, %d %b %Y %H:%M:%S %Z', $mtime));
			$this->response->add_header('Date', gmstrftime('%a, %d %b %Y %H:%M:%S %Z'));
			$this->response->add_header('Expires', gmstrftime('%a, %d %b %Y %H:%M:%S %Z', time() + 86400));

			$this->render(NULL);
		}
	}
?>