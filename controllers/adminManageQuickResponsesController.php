<?php

class adminManageQuickResponsesController {
  public function __construct()
  {
    //load required models
    $quickresponseModel = new quickresponseModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage Quick Responses";
    $templateData->details = "quick responses available for engineers to select when updating a ticket to ".CODENAME;
    $templateData->listofQuickresponses = $quickresponseModel->getListOfQuickResponses();

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/quickresponse/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/quickresponse/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $quickresponseModel->removeQuickResponseById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageQuickResponsesView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
