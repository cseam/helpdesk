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

    //create empty object to store data for template
    $templateData = new stdClass();
    //get list of catagories
    $templateData->catagories = $categoryModel->getListOfCategorys();

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
    $templateData->title = "Add Additional Fields";
    $templateData->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $templateData->title = "Modify Additional Fields";
      $templateData->reportResults = $additionalModel->getAdditionalFieldsById($id);
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifyAdditionalView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
