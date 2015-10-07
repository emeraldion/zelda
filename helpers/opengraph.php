<?php

	/**
	 *	@class OpenGraph
	 *	@short Defines methods and properties for the OpenGraph protocol.
	 */
	class OpenGraph
	{
		public $description;
    public $image;
    public $title;
    public $url;

    public function OpenGraph($params)
    {
      $this->description = $params['description'];
      $this->image = $params['image'];
      $this->title = $params['title'];
      $this->url = $params['url'];
    }
	}

?>
