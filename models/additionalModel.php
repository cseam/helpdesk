<?php

  class additionalModel {
  public function __construct()
    { }

    public function getListOfAdditionalFieldsByCategorys($categoryid) {
      $database = new Database();
      $database->query("SELECT * FROM call_additional_fields
                        WHERE typeid = :typeid");
      $database->bind(":typeid", $categoryid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function countFieldsByCategoryId($categoryid) {
      $database = new Database();
      $database->query("SELECT COUNT(*) as count FROM call_additional_fields
                        WHERE typeid = :typeid");
      $database->bind(":typeid", $categoryid);
      $results = $database->single();
      if ($database->rowCount() === 0) { return 0;}
      return $results["count"];
    }

    public function addAdditionalResult($callid, $label, $value) {
      $database = new Database();
      $database->query("INSERT INTO call_additional_results (callid, label, value)
                        VALUES (:callid , :label, :value)");
      $database->bind(":callid", $callid);
      $database->bind(":label", $label);
      $database->bind(":value", $value);
      $database->execute();
      return null;
    }
}
