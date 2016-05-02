<?php

  class locationModel {
    public function __construct()
    { }

    public function getListOfLocations() {
      $database = new Database();
      $database->query("SELECT * FROM location
                        ORDER BY locationName");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function removeLocationById($id) {

    }

    public function addLocation($locationobject) {

    }

    public function modifyLocationById($id, $locationobject) {
      
    }

}
