<?php

class adminManageCallReasonsController {
  public function __construct()
  {
    //load required models
    $reasonModel = new callreasonsModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage Call Reasons";
    $templateData->details = "Reasons available for users to select when updating tickets on " . CODENAME;
    $templateData->listofreasons = $reasonModel->getListOfReasons();

    //Post Update reasons
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/reason/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/reason/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $reasonModel->removeReasonById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageReasonsView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
