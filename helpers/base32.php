<?php

	/**
	 *	@class Base32
	 *	@short Base32 encoding helper
	 */
	class Base32
	{
		/**
		 *	@fn encode($txt)
		 *	@short Encodes a string with Base32 encoding
		 *	@param txt The string to encode
		 */
		public static function encode($txt)
		{
			return base32_encode($txt);
		}
		
		/**
		 *	@fn encode_chunklength($txt, $chunk_length = 32, $separator = "-")
		 *	@short Encodes a string with Base32 encoding and adds separators
		 *	@param txt The string to encode
		 *	@param chunk_length The length of each chunk between separators
		 *	@param separators The string to use as separator
		 */
		public static function encode_chunklength($txt, $chunk_length = 32, $separator = "-")
		{
			$b32 = self::encode($txt);
			$buf = "";
			while (strlen($b32) > 0)
			{
				$buf .= substr($b32, 0, $chunk_length) . $separator;
				$b32 = substr($b32, $chunk_length);
			}
			return $buf;
		}
	}

?>