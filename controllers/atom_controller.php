<?php
	require_once('feed_controller.php');

	/**
	 *	@class AtomController
	 *	@short Controller for Atom feeds.
	 *	@details Atom is an extensible syndication protocol based on XML.
	 */
	class AtomController extends FeedController
	{
		protected $mimetype = 'application/atom+xml; charset=utf-8';
		protected $type = 'atom';
	}
	
?>