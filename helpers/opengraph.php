<?php

	/**
	 *	@class OpenGraph
	 *	@short Defines methods and properties for the Open Graph protocol.
   *  For a full description see http://ogp.me
	 */
	class OpenGraph
	{
    /**
		 *	@attr description
		 *	@short Value of the og:description tag
		 */
		public $description;

    /**
		 *	@attr image
		 *	@short Value of the og:image tag
		 */
    public $image;

    /**
		 *	@attr title
		 *	@short Value of the og:title tag
		 */
    public $title;

    /**
		 *	@attr url
		 *	@short Value of the og:url tag
		 */
    public $url;

    /**
		 *	@attr type
		 *	@short Value of the og:type tag
		 */
    public $type;

    /**
     *  @fn OpenGraph
     *  @short Constructs objects that hold Open Graph metadata
     */
    public function OpenGraph($params)
    {
      $this->description = $params['description'];
      $this->image = $params['image'];
      $this->title = $params['title'];
      $this->url = $params['url'];
      $this->type = $params['type'];
    }
	}

?>
