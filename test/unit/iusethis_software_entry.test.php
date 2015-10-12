<?php
	// require_once(dirname(__FILE__) . "/../mock_objects/base.php");
	require_once(dirname(__FILE__) . "/../../models/iusethis_entry.php");
	require_once(dirname(__FILE__) . "/../base_test.php");

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
			$this->assertInstanceOf('IusethisEntry', $t, 'Wrong class');
		}
	}

?>
