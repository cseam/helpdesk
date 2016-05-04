<?php

class actionAdminManageLocations {
  public function __construct()
  {
    //load required models
    $locationModel = new locationModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Locations";
    $pagedata->details = "Locations available for users to select when adding a new ticket to " . CODENAME;

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/location/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/location/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $locationModel->removeLocationById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    $pagedata->listoflocations = $locationModel->getListOfLocations();
    // render page
    require_once "views/adminManageLocationsView.php";

  }
}
