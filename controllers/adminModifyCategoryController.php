<?php

class adminModifyCategoryController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $categoryModel = new categoryModel();
    $helpdeskModel = new helpdeskModel();
    //create page data objects
    $pagedata = new stdClass();
    //populate helpdesks
    $pagedata->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

    // on post update
    if ($_POST) {
      // upsert locations
      $categoryobject = new stdClass();
      $categoryobject->id = empty($_POST["id"]) ? null : htmlspecialchars($_POST["id"]);
      $categoryobject->categoryName = htmlspecialchars($_POST["categoryName"]);
      $categoryobject->helpdesk = htmlspecialchars($_POST["helpdesk"]);
      $categoryModel->upsertCategory($categoryobject);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $pagedata->title = "Add Category";
    $pagedata->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $pagedata->title = "Modify Category";
      $pagedata->reportResults = $categoryModel->getCategoryById($id);
    }

    //render page
    require_once "views/adminModifyCategoryView.php";

  }
}
