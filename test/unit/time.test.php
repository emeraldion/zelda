<?php
	require_once(dirname(__FILE__) . "/../../helpers/time.php");
	require_once(dirname(__FILE__) . "/../base_test.php");

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
			$this->assertEquals(time() + 24 * 3600, Time::tomorrow(), 'Bad timestamp');
			$this->assertTrue(Time::tomorrow() > time(), 'Bad timestamp');
		}

		/**
		 *	@fn test_yesterday
		 *	@short Test method for yesterday.
		 */
		public function test_yesterday()
		{
			$this->assertEquals(time() - 24 * 3600, Time::yesterday(), 'Bad timestamp');
			$this->assertTrue(Time::yesterday() < time(), 'Bad timestamp');
		}

		/**
		 *	@fn test_ago
		 *	@short Test method for ago.
		 */
		public function test_ago()
		{
			$this->assertEquals(time() - 3600, Time::ago("hour"), 'Bad timestamp');
			$this->assertTrue(Time::ago("hour") < time(), 'Bad timestamp');

			$this->assertEquals(time() - 24 * 3600, Time::ago("day"), 'Bad timestamp');
			$this->assertTrue(Time::ago("day") < time(), 'Bad timestamp');

			$this->assertEquals(time() - 7 * 24 * 3600, Time::ago("week"), 'Bad timestamp');
			$this->assertTrue(Time::ago("week") < time(), 'Bad timestamp');

			$this->assertEquals(time() - 30 * 24 * 3600, Time::ago("month"), 'Bad timestamp');
			$this->assertTrue(Time::ago("month") < time(), 'Bad timestamp');

			$this->assertEquals(time(), Time::ago(), 'Bad timestamp');
			$this->assertEquals(time(), Time::ago(), 'Bad timestamp');
		}

		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new Time();
			$this->assertInstanceOf('Time', $t, 'Wrong class');
		}
	}
?>
