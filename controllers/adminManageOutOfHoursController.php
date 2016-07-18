<?php

class adminManageOutOfHoursController {
  public function __construct()
  {
    //load required models
    $outofhoursModel = new outofhoursModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage Out of Hours Message";
    $templateData->details = "Messages shown to users who log a ticket outside of the working day";
    $templateData->listofOutofhoursmessages = $outofhoursModel->getOutOfHoursMessages();

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

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageOutofhoursView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
