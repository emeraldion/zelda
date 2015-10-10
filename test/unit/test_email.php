<?php
	require_once(dirname(__FILE__) . "/../../helpers/email.php");
	require_once(dirname(__FILE__) . "/../test.php");

	/**
	 *	@class EmailUnitTest
	 *	@short Test case for Filesystem helper object.
	 */
	class EmailUnitTest extends UnitTest
	{
		/**
		 *	@fn test_is_valid
		 *	@short Test method for is_valid.
		 */
		public function test_is_valid()
		{
			ERAssertTrue('Email::is_valid("claudio@emeraldion.it")', 'Email address is valid');
			ERAssertTrue('Email::is_valid("claudio@burgos.emeraldion.it")', 'Email address is valid');
			ERAssertTrue('Email::is_valid("claudio.procida@burgos.emeraldion.it")', 'Email address is valid');
			
			ERAssertFalse('Email::is_valid("claudio_emeraldion.it")', 'Email address is NOT valid');
			ERAssertFalse('Email::is_valid("claudio.it")', 'Email address is NOT valid');
		}
		
		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new Email();
			ERAssertOfClass($t, 'Email', 'Wrong class');
		}
	}
	
	$testcase = new EmailUnitTest();
	$testcase->run();
?>