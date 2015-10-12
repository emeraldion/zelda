<?php
	require_once(dirname(__FILE__) . "/../../helpers/filesystem.php");
	require_once(dirname(__FILE__) . "/../base_test.php");
	require_once(dirname(__FILE__) . "/../fixtures/filesystem.php");

	/**
	 *	@class FilesystemUnitTest
	 *	@short Test case for Filesystem helper object.
	 */
	class FilesystemUnitTest extends UnitTest
	{
		protected function setUp()
		{
			if (!file_put_contents(FIXTURE_FILESYSTEM_FILENAME, FIXTURE_FILESYSTEM_FILE_CONTENTS))
				echo "Unable to write file";
		}

		protected function tearDown()
		{
			unlink(FIXTURE_FILESYSTEM_FILENAME);
		}

		/**
		 *	@fn test_file_exists
		 *	@short Test method for file_exists.
		 */
		public function test_file_exists()
		{
			$this->assertTrue(Filesystem::file_exists(FIXTURE_FILESYSTEM_FILENAME),
				'File exists');
		}

		/**
		 *	@fn test_filesize
		 *	@short Test method for filesize.
		 */
		public function test_filesize()
		{
			$this->assertEquals(strlen(FIXTURE_FILESYSTEM_FILE_CONTENTS),
				Filesystem::filesize(FIXTURE_FILESYSTEM_FILENAME),
				'Bad file size');
		}

		/**
		 *	@fn test_filesize_readable
		 *	@short Test method for filesize_readable.
		 */
		public function test_filesize_readable()
		{
			$this->assertEquals(sprintf('%s B', strlen(FIXTURE_FILESYSTEM_FILE_CONTENTS)),
				Filesystem::filesize_readable(FIXTURE_FILESYSTEM_FILENAME),
				'Bad readable file size');
		}

		/**
		 *	@fn test_md5_sum
		 *	@short Test method for md5_sum.
		 */
		public function test_md5_sum()
		{
			$this->assertEquals(FIXTURE_FILESYSTEM_FILE_MD5SUM,
				Filesystem::md5_sum(FIXTURE_FILESYSTEM_FILENAME),
				'Bad MD5 sum');
		}

		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new Filesystem();
			$this->assertInstanceOf('Filesystem', $t, 'Wrong class');
		}
	}
?>
