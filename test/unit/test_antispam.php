<?php
	require_once(dirname(__FILE__) . "/../../helpers/antispam.php");
	require_once(dirname(__FILE__) . "/../test.php");
	require_once(dirname(__FILE__) . "/../fixtures/antispam.php");

	/**
	 *	@class AntispamUnitTest
	 *	@short Test case for Antispam helper object.
	 */
	class AntispamUnitTest extends UnitTest
	{
		/**
		 *	@fn test_init_math_test
		 *	@short Test method for init_math_test.
		 */
		public function test_init_math_test()
		{
			Antispam::init_math_test();
			ERAssertInRange('Antispam::$first_operand', 0, 10, 'First operand not in expected range');
			ERAssertInRange('Antispam::$second_operand', 0, 10, 'Second operand not in expected range');
		}
		
		/**
		 *	@fn test_check_math
		 *	@short Test method for check_math.
		 */
		public function test_check_math()
		{
			Antispam::init_math_test();
			$_POST = array('antispam_math_result' => (Antispam::$first_operand +
				Antispam::$second_operand));
			ERAssertTrue('Antispam::check_math()', 'Condition is false');
			
			$_POST = array('antispam_math_result' => (Antispam::$first_operand +
				Antispam::$second_operand + 1));
			ERAssertFalse('Antispam::check_math()', 'Condition is true');
		}

		/**
		 *	@fn test_get_spam_signature
		 *	@short Test method for get_spam_signature.
		 */
		public function test_get_spam_signature()
		{
			ERAssertEqual('Antispam::get_spam_signature("' . FIXTURE_ANTISPAM_SPAM_TEXT . '")',
				FIXTURE_ANTISPAM_SPAM_TEXT_SIGNATURE,
				'Bad signature');
		}
		
		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$spam = new Antispam();
			ERAssertOfClass($spam, 'Antispam', 'Wrong class');
		}
	}
	
	$testcase = new AntispamUnitTest();
	$testcase->run();
?>