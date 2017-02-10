<?php

class adminManageAdditionalController {
  public function __construct()
  {
    //load required models
    $additionalModel = new additionalModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage Addititional Fields";
    $templateData->details = "additional fields that drop down when a catagory is selected when adding a new ticket to ".CODENAME;
    $templateData->listofadditional = $additionalModel->getListOfAdditionalFields();

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/additional/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/additional/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $additionalModel->removeAdditionalFieldsById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageAdditionalView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
