<?php
  require_once("eme_controller.php");

  /**
   *	@class SpeakingController
   *	@short Controller for the Speaking section.
   */
  class SpeakingController extends EmeController
  {
    public function index()
    {
      $this->render(array('layout' => 'projects'));
    }
  }
?>
