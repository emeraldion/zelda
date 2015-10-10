<?php
	require_once(dirname(__FILE__) . "/../../helpers/time.php");
	require_once(dirname(__FILE__) . "/../test.php");

	/**
	 *	@class TimeUnitTest
	 *	@short Test case for Time helper object.
	 */
	class TimeUnitTest extends UnitTest
	{
		/**
		 *	@fn test_tomorrow
		 *	@short Test method for tomorrow.
		 */
		public function test_tomorrow()
		{
			ERAssertEqual('Time::tomorrow()', time() + 24 * 3600, 'Bad timestamp');
			ERAssertTrue('Time::tomorrow() > time()', 'Bad timestamp');
		}
		
		/**
		 *	@fn test_yesterday
		 *	@short Test method for yesterday.
		 */
		public function test_yesterday()
		{
			ERAssertEqual('Time::yesterday()', time() - 24 * 3600, 'Bad timestamp');
			ERAssertTrue('Time::yesterday() < time()', 'Bad timestamp');
		}
		
		/**
		 *	@fn test_ago
		 *	@short Test method for ago.
		 */
		public function test_ago()
		{
			ERAssertEqual('Time::ago("hour")', time() - 3600, 'Bad timestamp');
			ERAssertTrue('Time::ago("hour") < time()', 'Bad timestamp');
			
			ERAssertEqual('Time::ago("day")', time() - 24 * 3600, 'Bad timestamp');
			ERAssertTrue('Time::ago("day") < time()', 'Bad timestamp');
			
			ERAssertEqual('Time::ago("week")', time() - 7 * 24 * 3600, 'Bad timestamp');
			ERAssertTrue('Time::ago("week") < time()', 'Bad timestamp');

			ERAssertEqual('Time::ago("month")', time() - 30 * 24 * 3600, 'Bad timestamp');
			ERAssertTrue('Time::ago("month") < time()', 'Bad timestamp');
			
			ERAssertEqual('Time::ago()', time(), 'Bad timestamp');
			ERAssertEqual('Time::ago()', time(), 'Bad timestamp');
		}
		
		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new Time();
			ERAssertOfClass($t, 'Time', 'Wrong class');
		}
	}
	
	$testcase = new TimeUnitTest();
	$testcase->run();
?>