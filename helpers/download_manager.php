<?php
	require_once(dirname(__FILE__) . "/http.php");
	
	/**
	 *	@class DownloadManager
	 *	@short Helper object to manage the download of software artifacts.
	 */
	class DownloadManager
	{
		/**
		 *	@attr filename
		 *	@short The name of the file to download.
		 */
		public $filename;
		
		/**
		 *	@fn DownloadManager($filename)
		 *	@short Creates a DownloadManager object for a given filename.
		 *	@param filename The name of the file to download.
		 */
		public function DownloadManager($filename)
		{
			$this->filename = $filename;
		}
		
		/**
		 *	@fn start_download
		 *	@short Initiates the download of the file.
		 *	@details This method takes control of the response by setting the relevant
		 *	HTTP headers for content type, size and cache control, then outputs
		 *	the contents of the file to the client.
		 */
		public function start_download()
		{
			if (!file_exists($this->filename))
			{
				HTTP::error(404);
			}
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Length: ' . filesize($this->filename));
			header('Content-Disposition: attachment; filename=' . basename($this->filename));
			readfile($this->filename);
			exit();
		}
	}

?>