<?php

class adminManageEngineersController {
  public function __construct()
  {
    //load required models
    $engineerModel = new engineerModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage Engineers";
    $templateData->details = "Engineers available to use ".CODENAME;
    $templateData->listofengineers = $engineerModel->getListOfEngineers();

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/engineer/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/engineer/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $engineerModel->disableEngineerById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageEngineersView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
