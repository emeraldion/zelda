<?php

	/**
	 *	@class Sanskrit
	 *	@short Helper class for Sanskrit encoding.
	 */
	class Sanskrit
	{
		/**
		 *	@fn encode($str)
		 *	@short Encodes the string to Sanskrit.
		 *	@param str A string to encode.
		 */
		public static function encode($str)
		{
			return preg_replace(array(
					"/[eiouy]/",
					"/[EIOUY]/",
				),
				array(
					"a",
					"A",
				),
				$str);
		}
	}


?>