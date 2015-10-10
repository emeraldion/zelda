<?php
	require_once(dirname(__FILE__) . "/../include/db.inc.php");
	require_once(dirname(__FILE__) . "/../include/" . DB_ADAPTER . "_adapter.php");
	require_once(dirname(__FILE__) . "/../models/user.php");
	require_once(dirname(__FILE__) . "/../models/titlebar_message.php");
	require_once(dirname(__FILE__) . "/cookie.php");
	require_once(dirname(__FILE__) . "/time.php");
	require_once(dirname(__FILE__) . "/login.php");
	require_once(dirname(__FILE__) . "/localization.php");
	
	error_reporting(E_ALL);
	session_name('_eme_sid');
	session_set_cookie_params(Time::next_year(), '/');
	//session_save_path(dirname(__FILE__) . "/../session");
	session_start();
	
	if (isset($_COOKIE['hl']))
	{
		setlocale(LC_TIME, $_COOKIE['hl']);
	}

	class ApplicationHelper
	{
		// Put here functionality available to all controllers within the application
	}

?>