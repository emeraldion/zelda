<?php
	require_once(dirname(__FILE__) . "/../include/common.inc.php");

	/**
	 *	@class Filesystem
	 *	@short Helper class for file system manipulation.
	 */
	class Filesystem
	{
		/**
		 *	@fn filesize_readable($file, $retstring)
		 *	@short Returns a human readable representation of the size of <tt>file</tt>.
		 *	@details This method formats the filesize according to a hardcoded format string,
		 *	but you can also provide a custom format string.
		 *	@param file The name of the file whose size we want to show.
		 *	@param retstring An optional alternative format string.
		 */
		public static function filesize_readable ($file, $retstring = null)
		{
			if (!self::file_exists($file))
			{
				return l("No such file");
			}
			$size = filesize($file);
			// adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
			$sizes = array('B', 'kiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
			if ($retstring === null) { $retstring = '%01.2f %s'; }
			$lastsizestring = end($sizes);
			foreach ($sizes as $sizestring) {
				if ($size < 1024) { break; }
				if ($sizestring != $lastsizestring) { $size /= 1024; }
			}
			if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
			return sprintf($retstring, $size, $sizestring);
		}
		
		/**
		 *	@fn filesize($file)
		 *	@short Returns the size of the file <tt>file</tt>.
		 *	@param file The name of the file whose size we want to know.
		 */
		public static function filesize($file)
		{
			if (!file_exists($file))
			{
				return 0;
			}
			return filesize($file);
		}
		
		/**
		 *	@fn file_exists($file)
		 *	@short Returns <tt>TRUE</tt> if the file exists, <tt>FALSE</tt> otherwise.
		 *	@param file The name of the file whose existence we want to check.
		 */
		public static function file_exists($file)
		{
			return file_exists($file);
		}
		
		/**
		 *	@fn md5_sum($file, $raw)
		 *	@short Returns the MD5 sum of the file <tt>file</tt>.
		 *	@param file The name of the file.
		 *	@param raw Tells whether the checksum should be returned in a raw format.
		 */
		public static function md5_sum($file, $raw = FALSE)
		{
			if (!self::file_exists($file))
			{
				return NULL;
			}
			return md5_file($file, $raw);
		}
	}

?>