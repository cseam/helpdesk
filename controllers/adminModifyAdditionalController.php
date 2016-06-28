<?php

class adminModifyAdditionalController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $categoryModel = new categoryModel();
    $additionalModel = new additionalModel();
    //create page data objects
    $pagedata = new stdClass();
    //get list of catagories
    $pagedata->catagories = $categoryModel->getListOfCategorys();

    // on post update
    if ($_POST) {
      // upsert locations
      $object = new stdClass();
      $object->id = empty($_POST["id"]) ? null : htmlspecialchars($_POST["id"]);
      $object->typeid = htmlspecialchars($_POST["typeid"]);
      $object->label = htmlspecialchars($_POST["label"]);
      $additionalModel->upsertAdditionalFields($object);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $pagedata->title = "Add Additional Fields";
    $pagedata->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $pagedata->title = "Modify Additional Fields";
      $pagedata->reportResults = $additionalModel->getAdditionalFieldsById($id);
    }

    //render page
    require_once "views/adminModifyAdditionalView.php";

  }
}
