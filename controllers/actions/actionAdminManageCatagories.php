<?php

class actionAdminManageCatagories {
  public function __construct()
  {
    //load required models
    $categoryModel = new categoryModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Categories";
    $pagedata->details = "Categories available for users to select when adding a new ticket to " . CODENAME;

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

    $pagedata->listofcategorys = $categoryModel->getListOfCategorys();
    // render page
    require_once "views/adminManageCategoriesView.php";
  }
}
