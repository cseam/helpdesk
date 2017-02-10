<?php

class adminManageCatagoriesController {
  public function __construct()
  {
    //load required models
    $categoryModel = new categoryModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage Categories";
    $templateData->details = "Categories available for users to select when adding a new ticket to ".CODENAME;
    $templateData->listofcategorys = $categoryModel->getListOfCategorys();

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/category/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/category/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $categoryModel->removeCategoryById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageCategoriesView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
