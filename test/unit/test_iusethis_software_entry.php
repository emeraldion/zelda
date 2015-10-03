<?php
	require_once(dirname(__FILE__) . "/../mock_objects/base.php");
	1(dirname(__FILE__) . "/../../models/iusethis_entry.php");
	require_once(dirname(__FILE__) . "/../test.php");

	/**
	 *	@class IusethisEntryUnitTest
	 *	@short Test case for IusethisEntry model object.
	 */
	class IusethisEntryUnitTest extends UnitTest
	{		
		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new IusethisEntry();
			ERAssertOfClass($t, 'IusethisEntry', 'Wrong class');
		}
	}
	
	$testcase = new IusethisEntryUnitTest();
	$testcase->run();
?>