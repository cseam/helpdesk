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
    //create empty object to store data for template
    $templateData = new stdClass();

    //populate helpdesks
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();
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
    $templateData->title = "Add Category";
    $templateData->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $templateData->title = "Modify Category";
      $templateData->reportResults = $categoryModel->getCategoryById($id);
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifyCategoryView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
