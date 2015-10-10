<?php
	require_once(dirname(__FILE__) . "/base.php");
	
	/**
	 *	@class Tag
	 *	@short Model object that represents a category to classify information.
	 *	@details Taxonomy is so popular in the Web2.0! We use tags to classify
	 *	blog posts, software products, and much more.
	 */
	class Tag extends ActiveRecord
	{
		/**
		 *	@fn cloud($js_fn)
		 *	@short Creates an HTML tag cloud for all the existing tags.
		 *	@param js_fn An optional Javascript function to be used
		 *	as <tt>onclick</tt> handler for tag items.
		 */
		public static function cloud($js_fn = NULL)
		{
			$factory = new self();
			$tags = $factory->find_all();
			return self::join($tags, TRUE, $js_fn);
		}
		
		/**
		 *	@fn join($tags, $hyperlinks, $js_fn)
		 *	@short Joins the tags and optionally adds hyperlinks with a Javascript
		 *	handler.
		 *	@param tags An array of tags to join.
		 *	@param hyperlinks <tt>TRUE</tt> if you want hyperlinks, <tt>FALSE</tt> for plain text.
		 *	@param js_fn An optional Javascript function to be used
		 *	as <tt>onclick</tt> handler for tag items.
		 */
		public static function join($tags, $hyperlinks = FALSE, $js_fn = NULL)
		{
			if (is_array($tags))
			{
				$fn = $hyperlinks ?
					create_function('$t', "return a(\$t->tag, array('class' => 'token', 'href' => '#', 'onclick' => '" . addslashes($js_fn) . "'));") :
					create_function('$t', 'return $t->tag;');
				$tags = array_map($fn, $tags);
				$tags = implode(', ', $tags);
			}
			return $tags;
		}
	}
?>