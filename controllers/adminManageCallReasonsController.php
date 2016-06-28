<?php

class adminManageCallReasonsController {
  public function __construct()
  {
    //load required models
    $reasonModel = new callreasonsModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Call Reasons";
    $pagedata->details = "Reasons available for users to select when updating tickets on " . CODENAME;

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

    $pagedata->listofreasons = $reasonModel->getListOfReasons();
    // render page
    require_once "views/adminManageReasonsView.php";

  }
}
