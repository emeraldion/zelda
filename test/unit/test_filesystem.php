<?php
	require_once(dirname(__FILE__) . "/../../helpers/filesystem.php");
	require_once(dirname(__FILE__) . "/../test.php");
	require_once(dirname(__FILE__) . "/../fixtures/filesystem.php");

	/**
	 *	@class FilesystemUnitTest
	 *	@short Test case for Filesystem helper object.
	 */
	class FilesystemUnitTest extends UnitTest
	{
		protected function set_up()
		{
			file_put_contents(FIXTURE_FILESYSTEM_FILENAME, FIXTURE_FILESYSTEM_FILE_CONTENTS);
		}
		
		protected function tear_down()
		{
			unlink(FIXTURE_FILESYSTEM_FILENAME);
		}
		
		/**
		 *	@fn test_file_exists
		 *	@short Test method for file_exists.
		 */
		public function test_file_exists()
		{
			ERAssertTrue('Filesystem::file_exists("' . FIXTURE_FILESYSTEM_FILENAME . '")', 'File exists');
		}
		
		/**
		 *	@fn test_filesize
		 *	@short Test method for filesize.
		 */
		public function test_filesize()
		{
			ERAssertEqual('Filesystem::filesize("' . FIXTURE_FILESYSTEM_FILENAME . '")',
				strlen(FIXTURE_FILESYSTEM_FILE_CONTENTS),
				'Bad file size');
		}
		
		/**
		 *	@fn test_filesize_readable
		 *	@short Test method for filesize_readable.
		 */
		public function test_filesize_readable()
		{
			ERAssertEqual('Filesystem::filesize_readable("' . FIXTURE_FILESYSTEM_FILENAME . '")',
				sprintf("'%s B'", strlen(FIXTURE_FILESYSTEM_FILE_CONTENTS)),
				'Bad readable file size');
		}
		
		/**
		 *	@fn test_md5_sum
		 *	@short Test method for md5_sum.
		 */
		public function test_md5_sum()
		{
			ERAssertEqual('Filesystem::md5_sum("' . FIXTURE_FILESYSTEM_FILENAME . '")',
				'FIXTURE_FILESYSTEM_FILE_MD5SUM',
				'Bad MD5 sum');
		}
		
		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new Filesystem();
			ERAssertOfClass($t, 'Filesystem', 'Wrong class');
		}
	}
	
	$testcase = new FilesystemUnitTest();
	$testcase->run();
?>