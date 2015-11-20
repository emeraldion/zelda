<?php
  require_once("eme_controller.php");
  require_once(dirname(__FILE__) . "/../helpers/email.php");

  /**
   *	@class WebhookController
   *	@short Controller for Webhooks.
   *	TODO: move to ambrosia.emeraldion.it
   */
  class WebhookController extends EmeController
  {
    protected function init()
    {
      parent::init();
    }

    public function index()
    {
      if (!$this->request->is_post())
      {
        $this->redirect_to(array('controller' => 'home'));
      }

      // Do something with $_POST
      // Send an email to notify the event
      $email = new Email(array('text' => stream_get_contents(fopen('php://input', 'r+'))));
      $email->send();
      // Don't render
      $this->render(NULL);
    }
  }
?>
