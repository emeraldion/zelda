<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/../helpers/filesystem.php");
	require_once(dirname(__FILE__) . "/../include/tag_support.inc.php");

	/**
	 *	@class SoftwareArtifact
	 *	@short Model class for software artifacts.
	 */
	class SoftwareArtifact extends ActiveRecord
	{
		protected $foreign_key_name = 'artifact';

		/**
		 *	@fn filesize_readable
		 *	@short Returns a readable size for the artifact's local file.
		 */
		public function filesize_readable()
		{
			return Filesystem::filesize_readable($this->local_file());
		}

		/**
		 *	@fn filesize
		 *	@short Returns the size of the artifact's local file.
		 */
		public function filesize()
		{
			return Filesystem::filesize($this->local_file());
		}

		/**
		 *	@fn filename
		 *	@short Returns the filename of the artifact.
		 */
		public function filename()
		{
			if (!$this->file_exists())
			{
				return span($this->file, array('class' => 'missing-file',
					'title' => l('Missing file')));
			}
			return $this->file;
		}

		/**
		 *	@fn file_exists
		 *	@short Returns <tt>TRUE</tt> if the artifact's local file exists, <tt>FALSE</tt> otherwise.
		 */
		public function file_exists()
		{
			return Filesystem::file_exists($this->local_file());
		}

		/**
		 *	@fn md5_sum($raw)
		 *	@short Returns the MD5 sum of the artifact's local file.
		 *	@param raw Set to <tt>TRUE</tt> if you want the raw checksum.
		 */
		public function md5_sum($raw = FALSE)
		{
			return Filesystem::md5_sum($this->local_file(), $raw);
		}

		/**
		 *	@fn icon
		 *	@short Returns an icon suitable for the type of the artifact's local file.
		 */
		public function icon()
		{
			return sprintf('%sassets/images/download_%s_128.png',
				APPLICATION_ROOT,
				ends_with($this->file, '.zip') ? 'zip' : 'dmg');
		}

		/**
		 *	@fn type
		 *	@short Returns the extension of the artifact's local file.
		 */
		public function type()
		{
			return substr($this->file, strrpos($this->file, '.') + 1);
		}

		public function relative_url()
		{
			return sprintf('software/download/%s/%s',
				$this->id,
				$this->file);
		}

		/**
		 *	@fn local_file
		 *	@short Returns the path to the artifact's local file.
		 */
		public function local_file()
		{
			return sprintf(dirname(__FILE__) . "/../assets/artifacts/%s",
				$this->file);
		}

		/**
		 *	@fn total_downloads
		 *	@short Returns the total number of downloads for all software artifacts.
		 */
		public static function total_downloads()
		{
			$conn = Db::get_connection();
			$conn->prepare('SELECT SUM(`downloads`) FROM `software_artifacts` WHERE 1');
			$conn->exec();
			$ret = $conn->result(0);
			Db::close_connection($conn);
			return $ret;
		}
	}
?>
