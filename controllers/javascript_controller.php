<?php
	require_once('asset_controller.php');
	require_once(dirname(__FILE__) . '/../config/js.conf.php');

	/**
	 *	@class JavascriptController
	 *	@short Controller for serving Javascript content.
	 */
	class JavascriptController extends AssetController
	{
		protected function init()
		{
			// Call parent's init method
			parent::init();
			
			//$this->after_filter('minify', 'compress');
		}
		
		public function index()
		{
			$this->common();
		}
		
		public function common()
		{
			global $js_files;
			
			$this->mimetype = 'application/x-javascript';
			$this->response->body = '';
			$mtime = 0;
			foreach ($js_files as $js_file)
			{
				$js_file = dirname(__FILE__) . '/../' . $js_file;
				$mtime = max($mtime, filemtime($js_file));
				$this->response->body .= file_get_contents($js_file);
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