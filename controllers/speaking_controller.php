<?php
  require_once("eme_controller.php");
  require_once(dirname(__FILE__) . "/../models/talk.php");
  require_once(dirname(__FILE__) . "/../models/speakerdeck_deck.php");
  require_once(dirname(__FILE__) . "/../models/vimeo_video.php");
  require_once(dirname(__FILE__) . "/../models/youtube_video.php");

  /**
   *	@class SpeakingController
   *	@short Controller for the Speaking section.
   */
  class SpeakingController extends EmeController
  {
    public function index()
    {
      $talk_factory = new Talk();
      $this->talks = $talk_factory->find_all(array(
        'order_by' => '`date` DESC'));

      foreach ($this->talks as $talk)
      {
        $talk->has_and_belongs_to_many('speakerdeck_decks');
        $talk->has_and_belongs_to_many('vimeo_videos');
        $talk->has_and_belongs_to_many('youtube_videos');
      }

      $this->render(array('layout' => 'projects'));
    }

    public function index_old()
    {
      $this->render(array('layout' => 'projects'));
    }
  }
?>
