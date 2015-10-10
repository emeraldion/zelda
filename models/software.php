<?php
	require_once(dirname(__FILE__) . "/base.php");
	require_once(dirname(__FILE__) . "/../include/tag_support.inc.php");

	/**
	 *	@class Software
	 *	@short Model class for software products.
	 *	@details Software objects represent software products that are released to
	 *	the public on the Emeraldion Lodge.
	 *	Since software development is our main business, this model class
	 *	is particularly loaded with functionality.
	 */
	class Software extends ActiveRecord
	{
		/**
		 *	@attr licenses
		 *	@short Array of license types for software products.
		 */
		public static $licenses = array('freeware', 'donationware', 'shareware', 'commercial', 'demo', 'adware', 'free software', 'public beta');
	
		public function relative_url()
		{
			return sprintf('software/%s/%s.html',
				$this->type,
				$this->name);
		}
		
		/**
		 *	@fn small_icon
		 *	@short Returns a small sized icon for the software product.
		 */
		public function small_icon()
		{
			return $this->icon('mini');
		}
		
		/**
		 *	@fn big_icon
		 *	@short Returns a big sized icon for the software product.
		 */
		public function big_icon()
		{
			return $this->icon('big');
		}

		/**
		 *	@fn icon($size)
		 *	@short Returns an icon of the desired size for the software product.
		 *	@param size A size for the returned icon.
		 */
		public function icon($size = 'mini')
		{
			return sprintf('%sassets/images/software/%s/%s/%s-%s.png',
					APPLICATION_ROOT,
					$this->type,
					$this->name,
					$this->name,
					$size);
		}
		
		/**
		 *	@fn releasenotes_permalink
		 *	@short Returns a permanent link for the releasenotes page of the software product.
		 */
		public function releasenotes_permalink()
		{
			return sprintf('http://%s%ssoftware/releasenotes/%s',
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->id);
		}
		
		/**
		 *	@fn appcast_permalink
		 *	@short Returns a permanent link for the appcast feed of the software product.
		 */
		public function appcast_permalink()
		{
			return sprintf('http://%s%ssoftware/appcast/%s',
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->name);
		}

		/**
		 *	@fn changelog_permalink
		 *	@short Returns a permanent link for the changelog page of the software product.
		 */
		public function changelog_permalink()
		{
			return sprintf('http://%s%ssoftware/%s/%s/changelog.html',
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->type,
				$this->name);
		}
		
		/**
		 *	@fn donate_permalink
		 *	@short Returns a permanent link for the donations page of the software product.
		 */
		public function donate_permalink()
		{
			return sprintf('http://%s%ssoftware/%s/%s/donate.html',
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->type,
				$this->name);
		}
		
		/**
		 *	@fn registration_permalink
		 *	@short Returns a permanent link for the registration page of the software product.
		 */
		public function registration_permalink()
		{
			return sprintf('http://%s%ssoftware/%s/%s/register.html',
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->type,
				$this->name);
		}
		
		/**
		 *	@fn comments_permalink
		 *	@short Returns a permanent link for the comments page of the software product.
		 */
		public function comments_permalink()
		{
			return sprintf('http://%s%ssoftware/%s/%s/comments.html',
				$_SERVER['HTTP_HOST'],
				APPLICATION_ROOT,
				$this->type,
				$this->name);
		}
		
		/**
		 *	@fn url_to_detail($detail)
		 *	@short Returns an URL for the desired detail page of the software product.
		 *	@param detail The desired detail (e.g. comments).
		 */
		public function url_to_detail($detail = 'main')
		{
			return $detail == 'main' ? sprintf('%ssoftware/%s/%s.html',
					APPLICATION_ROOT,
					$this->type,
					$this->name) :
				sprintf('%ssoftware/%s/%s/%s.html',
					APPLICATION_ROOT,
					$this->type,
					$this->name,
					$detail);
		}
		
		/**
		 *	@fn colorful_license
		 *	@short Returns a colored license label for the the software product.
		 */
		public function colorful_license()
		{
			$color = '#69f';
			switch ($this->license) {
				case 'free software':
					$color = '#f09'; // fuchsia
					break;
				case 'freeware':
					$color = '#0c0'; // green
					break;
				case 'shareware':
					$color = '#609'; // purple
					break;				
				case 'commercial':
					$color = '#00c'; // blue
					break;				
				case 'demo':
					$color = '#c00'; // red
					break;				
				case 'donationware':
					$color = '#f93'; // orange
					break;			
			}
			return span(ucwords($this->license), array('style' => "font-weight:bold;color:$color"));
		}
	}
?>