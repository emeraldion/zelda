<?php

	class Base64
	{
		public static function encode($txt)
		{
			return base64_encode($txt);
		}
		
		public static function decode($txt)
		{
			$txt = self::_clean($txt);
			return base64_decode($txt);
		}
		
		public static function encode_linelength($txt, $line_length = 32)
		{
			$b64 = self::encode($txt);
			$buf = "";
			while (strlen($b64) > 0)
			{
				$buf .= substr($b64, 0, $line_length) . "\n";
				$b64 = substr($b64, $line_length);
			}
			return $buf;
		}
		
		private static function _clean($text)
		{
			return preg_replace("/[^a-z0-9\+\/]/i",
				"",
				$text);
		}
	}

?>