<?php
	require_once(dirname(__FILE__) . "/../../helpers/wikipedia.php");
	require_once(dirname(__FILE__) . "/../base_test.php");

	/**
	 *	@class WikipediaUnitTest
	 *	@short Test case for Wikipedia helper object.
	 */
	class WikipediaUnitTest extends UnitTest
	{
		/**
		 *	@fn test_lookup_url
		 *	@short Test method for lookup_url.
		 */
		public function test_lookup_url()
		{
			$term = 'Valentino Rossi';
			$lang = 'it';

			$wiki_url = 'http://it.wikipedia.org/wiki/Valentino_Rossi';

			$this->assertEquals($wiki_url,
				Wikipedia::lookup_url($term, $lang),
				'Bad wikipedia URL');

			$term = 'La Coruña';
			$lang = 'es';

			$wiki_url = 'http://es.wikipedia.org/wiki/La_Coru%C3%83%C2%B1a';

			$this->assertEquals($wiki_url,
				Wikipedia::lookup_url($term, $lang),
				'Bad wikipedia URL');
		}

		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new Wikipedia();
			$this->assertInstanceOf('Wikipedia', $t, 'Wrong class');
		}
	}
?>
