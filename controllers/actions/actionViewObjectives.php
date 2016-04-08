<?php

class actionViewObjectives {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $objectiveid = $baseurl[3];

    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $objectivesModel = new objectivesModel();
    $pagedata = new stdClass();

    //set report name
    $reportname = "Performance Objective #".$objectiveid;
    //set report title
    $pagedata->title = $reportname;

    //Populate Objective
    //get objective details
    $pagedata->reportResults = $objectivesModel->getObjectiveById($objectiveid);
    //check engineerid is same as engineer assigned to objective {CLOWN FIESTA need to fix this but it works for now}
      if ($pagedata->reportResults[0]['engineerid'] === $_SESSION['engineerId']) {
        //objective owner
        //populate report results for use in view
      } else if ($_SESSION['engineerLevel'] > 1 OR $_SESSION['superuser'] == true) {
        //manager or superuser for system
        //populate report results for use in view
      } else {
        //shouldent have access to this objective throw error
        $pagedata->errorMessage = "<h3>Access Denied</h3><p>You do not have permission to view this performance objective.</p>";
        $pagedata->reportResults = null;
      }

    //Post Update Objective
      if ($_POST) {
        SWITCH ($_POST["button_value"]) {
          CASE "update":
            echo "update";
          break;
          CASE "modify":
            echo "modify";
          break;
          CASE "delete":
            echo "delete";
          break;
        }
      }

    //render template using $pagedata object
    require_once "views/ObjectivesView.php";
  }
}
