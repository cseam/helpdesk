<?php

class adminManageSLAController {
  public function __construct()
  {
    //load required models
    $SLAModel = new servicelevelagreementModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage service level agreements";
    $templateData->details = "Service level agreements generated for users when adding a new ticket to ".CODENAME;
    $templateData->listofSlas = $SLAModel->getListOfSLAs();

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/sla/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/sla/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $SLAModel->removeSLAById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageSLAsView');
    $view->setDataSrc($templateData);
    $view->render();

  }
}
