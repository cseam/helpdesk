<?php

class actionAdminManageSla {
  public function __construct()
  {
    //load required models
    $SLAModel = new servicelevelagreementModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage service level agreements";
    $pagedata->details = "Service level agreements generated for users when adding a new ticket to " . CODENAME;

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

    $pagedata->listofSlas = $SLAModel->getListOfSLAs();
    // render page
    require_once "views/adminManageSLAsView.php";

  }
}
