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
      $database = new Database();
      $database->query("DELETE FROM location WHERE id=:id");
      $database->bind(':id', $id);
      $database->execute();
      return true;
    }

    public function addLocation($locationobject) {
      $database = new Database();
    }

    public function modifyLocationById($id, $locationobject) {
      $database = new Database();
    }

}
