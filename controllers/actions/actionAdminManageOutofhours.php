<?php

class actionAdminManageOutofhours {
  public function __construct()
  {
    //load required models
    $outofhoursModel = new outofhoursModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Out of Hours Message";
    $pagedata->details = "Messages shown to users who log a ticket outside of the working day";

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "modify":
            header('Location: /admin/outofhours/'.$id);
            exit;
          break;
        }
      }

    $pagedata->listofOutofhoursmessages = $outofhoursModel->getOutOfHoursMessages();
    //render page
    require_once "views/adminManageOutofhoursView.php";

  }
}
