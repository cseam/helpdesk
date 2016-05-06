<?php

class actionAdminManageQuickresponses {
  public function __construct()
  {
    //load required models
    $quickresponseModel = new quickresponseModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Quick Responses";
    $pagedata->details = "quick responses available for engineers to select when updating a ticket to " . CODENAME;

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

    $pagedata->listofQuickresponses = $quickresponseModel->getListOfQuickResponses();
    // render page
    require_once "views/adminManageQuickResponsesView.php";
  }
}
