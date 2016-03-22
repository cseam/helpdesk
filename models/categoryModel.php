<?php

  class categoryModel {
  public function __construct()
    { }

    public function getListOfCategorysByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM categories WHERE helpdesk = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

}
