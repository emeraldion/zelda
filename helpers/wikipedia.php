<?php
	require_once(dirname(__FILE__) . "/../include/tag_support.inc.php");

	/**
	 *	@class Wikipedia
	 *	@short Helper class for Wikipedia topic reference.
	 */
	class Wikipedia
	{
		/**
		 *	@short Universal URL scheme for Wikipedia articles.
		 */
		const WIKIPEDIA_URL_SCHEME = 'http://%s.wikipedia.org/wiki/%s';
		
		/**
		 *	@fn wikize($term)
		 *	@short Transforms a term in a way that is suitable for Wikipedia permalinks.
		 *	@param term The term to wikize.
		 */
		private static function wikize($term)
		{
			return urlencode(iconv('iso-8859-1', 'utf-8', str_replace(' ', '_', $term)));
		}

		/**
		 *	@fn lookup_url($term, $lang)
		 *	@short Builds a URL to lookup the desired term on Wikipedia.
		 *	@param term The term to lookup.
		 *	@param lang The language of the wiki article.
		 */
		public static function lookup_url($term, $lang = 'en')
		{
			return sprintf(self::WIKIPEDIA_URL_SCHEME,
				$lang,
				self::wikize($term));
		}

		/**
		 *	@fn lookup($term, $lang)
		 *	@short Creates a hyperlink to lookup the desired term on Wikipedia.
		 *	@param term The term to lookup.
		 *	@param lang The language of the wiki article.
		 */
		public static function lookup($term, $lang = 'en')
		{
			print a($term, array('class' => 'external',
				'href' => self::lookup_url($term, $lang)));
		}
	}

?>