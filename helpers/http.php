<?php
	/**
	 *	Project EmeRails - Codename Ocarina
	 *
	 *	Copyright (c) 2008, 2017 Claudio Procida
	 *	http://www.emeraldion.it
	 *
	 */
	
	require_once(dirname(__FILE__) . "/../models/server_error.php");

	/**
	 *	@class HTTP
	 *	@short Helper class to manipulate HTTP error codes.
	 */
	class HTTP
	{
		/**
		 *	@fn error($code, $headers)
		 *	@short Redirects the request to the error page for the desired HTTP error code.
		 *	@details This method redirects the request to the ErrorController action method that
		 *	handles the HTTP error code <tt>code</tt>, optionally sending a set of headers.
		 *	@param code The HTTP error code.
		 *	@param headers An optional set of HTTP headers to send to the client.
		 */
		public static function error($code = 500, $headers = array())
		{
			if ($code != 400 && $code != 503)
			{
				$error = new ServerError(array('code' => $code,
					'description' => var_export($_SERVER, TRUE),
					'occurred_at' => date('Y-m-d H:i:s')));
				$error->save();
			}

			foreach($headers as $header => $value)
			{
				header("$header: $value");
			}
			$_SESSION['error_processed'] = TRUE;
			header(sprintf("Location: http://%s%serror/%s.html",
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$code));
			exit();
		}
	}

?>