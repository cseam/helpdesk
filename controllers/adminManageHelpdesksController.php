<?php

class adminManageHelpdesksController {
  public function __construct()
  {
    //load required models
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage Helpdesks";
    $templateData->details = "helpdesks available for users to select when adding a new ticket to ".CODENAME;

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/helpdesk/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/helpdesk/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $helpdeskModel->removeHelpdeskById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    $templateData->listofHelpdesks = $helpdeskModel->getListOfHelpdesks();

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageHelpdesksView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
