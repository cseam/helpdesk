<?php

  class additionalModel {
  public function __construct()
    { }

    public function getListOfAdditionalFieldsByCategorys($categoryid) {
      $database = new Database();
      $database->query("SELECT * FROM call_additional_fields WHERE typeid = :typeid");
      $database->bind(":typeid", $categoryid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

}
