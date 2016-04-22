<?php

class actionViewObjectives {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $objectiveid = $baseurl[3];
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $objectivesModel = new objectivesModel();
    $pagedata = new stdClass();
    //Post Update Objective
      if ($_POST) {
        SWITCH ($_POST["button_value"]) {
          CASE "add":
            // reroute to add form
            header('Location: /manager/addobjectives/');
            exit;
          break;
          CASE "update":
            $objectivesModel->updateObjectiveById($_POST['id'], $_POST['updatedetails'], $_POST['progress']);
            $pagedata->complete = "<h3>Thank you</h3><p>Your objective has been updated.</p>";
          break;
          CASE "modify":
            // reroute to modify form
            header('Location: /manager/modifyobjectives/'.$_POST["id"]);
            exit;
          break;
          CASE "delete":
            $objectivesModel->removeObjectiveById($_POST['id']);
            $pagedata->complete = "<h3>Objective Removed</h3><p>objective #".$_POST['id']." has been removed from the database.</p>";
          break;
        }
      }
    //set report name
    $reportname = "Performance Objective #".$objectiveid;
    //set report title
    $pagedata->title = $reportname;
    //populate objective
    $pagedata->reportResults = $objectivesModel->getObjectiveById($objectiveid);
    //check engineerid is same as engineer assigned to objective {CLOWN FIESTA need to fix this but it works for now}
      if ($pagedata->reportResults[0]['engineerid'] === $_SESSION['engineerId']) { } else if ($_SESSION['engineerLevel'] > 1 OR $_SESSION['superuser'] == true) { } else {
        //no access to this objective throw error
        $error = "<h3>Access Denied</h3><p>You do not have permission to view this performance objective.</p>";
        $pagedata->reportResults = null;
      }
    //render template using $pagedata object
    require_once "views/objectivesView.php";
  }
}
