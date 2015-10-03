<?php
	require_once(dirname(__FILE__) . "/../../helpers/gravatar.php");
	require_once(dirname(__FILE__) . "/../test.php");

	/**
	 *	@class GravatarUnitTest
	 *	@short Test case for Gravatar helper object.
	 */
	class GravatarUnitTest extends UnitTest
	{
		/**
		 *	@fn test_tomorrow
		 *	@short Test method for tomorrow.
		 */
		public function test_gravatar_url()
		{
			$email = 'claudio@emeraldion.it';
			$size = 40;
			$default = 'http://www.emeraldion.it/images/avatar.png';
			
			$grav_url = '"http://www.gravatar.com/avatar.php?gravatar_id=' . md5($email) .
				'&amp;default=' . urlencode($default) .
				'&amp;size=' . $size . '"';
			
			ERAssertEqual('Gravatar::gravatar_url("' . $email . '", "' . $size . '", "' . $default . '")',
				$grav_url,
				'Bad gravatar URL');
		}
		
		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new Gravatar();
			ERAssertOfClass($t, 'Gravatar', 'Wrong class');
		}
	}
	
	$testcase = new GravatarUnitTest();
	$testcase->run();
?>