<?php

class formCategoryTicketController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $helpdeskid = $baseurl[3];
    //create new models for required data
    $categoryModel = new categoryModel();
    //get helpdesk description
    $category = $categoryModel->getListOfCategorysByHelpdesk($helpdeskid);
    //since not being viewed used to update dropdown not passed to view just rendered
    echo "<option value=\"\" SELECTED>Please Select</option>";
    foreach ($category as $key => $value) { echo "<option value=\"".$value["id"]."\">".$value["categoryName"]."</option>";}
  }

}
