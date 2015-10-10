<?php
	require_once(dirname(__FILE__) . "/../models/spam_signature.php");

	/**
	 *	@class Antispam
	 *	@short Helper class to perform basic Antispam checks.
	 */
	class Antispam
	{
		/**
		 *	@attr first_operand
		 *	@short The first operand for the math test.
		 */
		static $first_operand = 0;

		/**
		 *	@attr second_operand
		 *	@short The second operand for the math test.
		 */
		static $second_operand = 0;

		/**
		 *	@fn random_comment
		 *	@short Returns a variable message to alert the user that she's failed the math test.
		 */
		public static function random_comment()
		{
			$comments = array(
				l('Antispam check failed. Please try again.'),
			);
			return $comments[rand(0, count($comments) - 1)];
		}

		/**
		 *	@fn init_math_test
		 *	@short Initializes the mathematical test to tell humans and machines apart.
		 */
		public static function init_math_test()
		{
			self::$first_operand = rand(0, 10);
			self::$second_operand = rand(0, 10);
			$_SESSION['antispam_math'] = array(self::$first_operand, self::$second_operand);
		}

		/**
		 *	@fn check_math
		 *	@short Verifies if the math test has been successful.
		 *	@details The math test consists in filling a form field with the result of a simple
		 *	arithmetical operation (e.g. a sum) between two operands. This method checks
		 *	that the user has answered with the correct result.
		 *	@return <tt>TRUE</tt> if the math test has been answered correctly, <tt>FALSE</tt> otherwise.
		 */
		public static function check_math()
		{
			if (isset($_SESSION['antispam_math']))
			{
				return $_SESSION['antispam_math'][0] +
					$_SESSION['antispam_math'][1] ==
					$_POST['antispam_math_result'];
			}
			return FALSE;
		}

		/**
		 *	@fn get_spam_signature
		 *	@short Returns the spam signature for a string of text.
		 *	@param $text The text that is used to calculate the spam signature.
		 */
		public static function get_spam_signature($text)
		{
			$pattern = preg_replace('/[a-z0-9]+/i', 'a', $text);
			$signature = md5($pattern);
			return $signature;
		}

		/**
		 *	@fn check_spam_signature
		 *	@short Checks whether the string of text has a recognized spam signature.
		 *	@param $text The text that is used to calculate the spam signature.
		 */
		public static function check_spam_signature($text)
		{
			$conn = Db::get_connection();

			$signature = self::get_spam_signature($text);

			$sig_factory = new SpamSignature();
			$matches = $sig_factory->find_all(array('where_clause' => "`signature` = '{$conn->escape($signature)}'"));

			Db::close_connection($conn);
			
			return (count($matches) > 0);
		}

		/**
		 *	@fn store_spam_signature
		 *	@short Stores the spam signature for the string of text.
		 *	@param $text The text that is used to calculate the spam signature.
		 */
		public static function store_spam_signature($text)
		{
			$sig = new SpamSignature(array('signature' => self::get_spam_signature($text)));
			$sig->save();
		}
	}

?>
