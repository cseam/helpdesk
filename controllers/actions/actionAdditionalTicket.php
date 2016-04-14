<?php

class actionAdditionalTicket {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $categoryid = $baseurl[3];
    //create new models for required data
    $additionalModel = new additionalModel();
    //get category additional fields
    $additionalfields = $additionalModel->getListOfAdditionalFieldsByCategorys($categoryid);
    //since not being viewed used to update dropdown not passed to view just rendered
    foreach ($additionalfields as $key => $value) {
      echo "<label for=\"label". $value["id"] ."\">" . $value["label"] ."</label>";
      echo "<input type=\"text\" id=\"label" . $value["id"] . "\" name=\"label" . $value["id"] . "\" value=\"\" required />";
      echo "<input type=\"hidden\" id=\"labelname" . $value["id"] . "\" name=\"labelname" . $value["id"] . "\" value=\"".$value["label"]."\" />";
    }
  }

}
