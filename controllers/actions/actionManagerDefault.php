<?php

class actionManagerDefault {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view

    // Populate Graph
    // New Stats model
      $statsModel = new statsModel();
      $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);

    // populate page content
      $pagedata = new stdClass();
      $pagedata->title = "manager method";
      $pagedata->summary = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

    // render page
    require_once "views/managerView.php";
  }

}
