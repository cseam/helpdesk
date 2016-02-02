<?php

class homeController {
  public function __construct()
  {
    // do controller things and request data from model
    $pagedata = new stdClass();
    $pagedata->title = "HOME PAGE";
    $pagedata->summary = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

    // render page
    require_once "views/homeView.php";
  }

}
