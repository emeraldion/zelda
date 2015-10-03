<?php
	require_once(dirname(__FILE__) . "/../../helpers/wikipedia.php");
	require_once(dirname(__FILE__) . "/../test.php");

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
			
			$wiki_url = '"http://it.wikipedia.org/wiki/Valentino_Rossi"';
			
			ERAssertEqual('Wikipedia::lookup_url("' . $term . '", "' . $lang . '")',
				$wiki_url,
				'Bad wikipedia URL');
				
			$term = 'La Coruña';
			$lang = 'es';
			
			$wiki_url = '"http://es.wikipedia.org/wiki/La_Coru%C3%B1a"';
			
			ERAssertEqual('Wikipedia::lookup_url("' . $term . '", "' . $lang . '")',
				$wiki_url,
				'Bad wikipedia URL');			
		}
		
		/**
		 *	@fn test_class
		 *	@short Test for class.
		 */
		public function test_class()
		{
			$t = new Wikipedia();
			ERAssertOfClass($t, 'Wikipedia', 'Wrong class');
		}
	}
	
	$testcase = new WikipediaUnitTest();
	$testcase->run();
?>