<?php

class actionAdminManageEngineers {
  public function __construct()
  {
    //load required models
    $engineerModel = new engineerModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Engineers";
    $pagedata->details = "Engineers available to use " . CODENAME;

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

    $pagedata->listofengineers = $engineerModel->getListOfEngineers();
    // render page
    require_once "views/adminManageEngineersView.php";

  }
}
