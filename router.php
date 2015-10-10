<?php
	require_once(dirname(__FILE__) . "/include/common.inc.php");
	require_once(dirname(__FILE__) . "/helpers/application_helper.php");
	require_once(dirname(__FILE__) . "/helpers/http.php");
	
	define('APPLICATION_ROOT', '/');
	
	if (isset($_REQUEST['controller']) && !empty($_REQUEST['controller']))
	{
		// Get controller name
		$controller = basename($_REQUEST['controller']);
		
		// Include controller class
		$controller_file = dirname(__FILE__) . "/controllers/{$controller}_controller.php";
		
		if (!file_exists($controller_file))
		{
			HTTP::error(404);
		}
		require($controller_file);
		
		// Instantiate main controller
		$main_controller = eval("return new " . joined_lower_to_camel_case($_REQUEST['controller']) . "Controller();");
		
		// Request rendering of the page
		$main_controller->render_page();
	}
	else
	{
		HTTP::error(500);
	}

?>