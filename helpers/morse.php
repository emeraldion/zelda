<?php
	/**
	 *	@class Morse
	 *	@short Helper class for Morse code translation.
	 */
	class Morse
	{
		/**
		 *	@attr translation_table
		 *	@short Translation table for Morse code.
		 */
		static $translation_table = array(
			'a' => '.-',
			'b' => '-...',
			'c' => '-.-.',
			'd' => '-..',
			'e' => '.',
			'f' => '..-.',
			'g' => '--.',
			'h' => '....',
			'i' => '..',
			'j' => '.---',
			'k' => '-.-',
			'l' => '.-..',
			'm' => '--',
			'n' => '-.',
			'o' => '---',
			'p' => '.--.',
			'q' => '--.-',
			'r' => '.-.',
			's' => '...',
			't' => '-',
			'u' => '..-',
			'v' => '...-',
			'w' => '.--',
			'x' => '-..-',
			'y' => '-.--',
			'z' => '--..',
			'0' => '-----',
			'1' => '.----',
			'2' => '..---',
			'3' => '...--',
			'4' => '....-',
			'5' => '.....',
			'6' => '-....',
			'7' => '--...',
			'8' => '---..',
			'9' => '----.',
			'.' => '.-.-.-',
			',' => '--..--',
			'?' => '..--..',
			'\'' => '.----.',
			'!' => '-.-.--',
			'/' => '-..-.',
			'(' => '-.--.',
			')' => '-.--.-',
			'&' => '.-...',
			':' => '---...',
			';' => '-.-.-.',
			'=' => '-...-',
			'+' => '.-.-.',
			'-' => '-....-',
			'_' => '..--.-',
			'"' => '.-..-.',
			'$' => '...-..-',
			'@' => '.--.-.',
		);
		
		/**
		 *	@attr char_table
		 *	@short Character translation table for non ASCII chars.
		 */
		static $char_table = array(
			'à' => 'a',
			'á' => 'a',
			'ä' => 'a',
			'è' => 'e',
			'é' => 'e',
			'ë' => 'e',
			'ì' => 'i',
			'í' => 'i',
			'ò' => 'o',
			'ó' => 'o',
			'ö' => 'o',
			'ù' => 'u',
			'ú' => 'u',
			'ü' => 'u',
			'ñ' => 'n',
		);
		
		/**
		 *	@fn encode($text)
		 *	@short Encodes the given text in Morse code.
		 *	@param text The text to encode.
		 */
		public static function encode($text)
		{
			return strtr(strtr(strtolower($text), self::$char_table), self::table());
		}

		/**
		 *	@fn decode($text)
		 *	@short Decodes the given text from Morse code.
		 *	@param text The text to decode.
		 */		
		public static function decode($text)
		{
			return strtr($text, array_flip(self::table()));
		}
		
		/**
		 *	@fn table
		 *	@short Returns a usable version of the translation table.
		 *	@details The Morse translation table needs to be edited before being
		 *	used. A space is added after each Morse sequence to delimit letters.
		 */
		public static function table()
		{
			$table = self::$translation_table;
			array_walk($table, create_function('&$t', '$t = $t . " ";'));
			return $table;
		}
	}

?>