<?php

class reportFeedbackNoteController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $id = $baseurl[4];
    //create new models for required data
    $feedbackModel = new feedbackModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    //set report title
    $templateData->title = "Manager feedback notes";
    if ($_POST) {
      //update note
      $feedbackModel->addNoteByTicketId($id, htmlspecialchars($_POST["note"]));
    }
    //populate report results for use in view
    $templateData->feedback = $feedbackModel->getFeedbackByTicketId($id);
    $templateData->managerNotes = $feedbackModel->getNotesByTicketId($id);
    //set page details
    $templateData->details = "Showing additional manager notes.";
    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsFeedbackNotesView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
