<?php

  class locationModel {
    public function __construct()
    { }

    public function getListOfLocations() {
      $database = new Database();
      $database->query("SELECT * FROM location
                        ORDER BY optiongroup, locationName");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function removeLocationById($id) {
      $database = new Database();
      $database->query("DELETE FROM location WHERE id=:id");
      $database->bind(':id', $id);
      $database->execute();
      return true;
    }

    public function upsertLocation($locationobject) {
      isset($locationobject->id) ? $this->modifyLocationById($locationobject) : $this->addLocation($locationobject);
    }

    public function addLocation($locationobject) {
      $database = new Database();
      $database->query("INSERT INTO location (locationName, iconlocation, shorthand, optiongroup)
                        VALUES (:locationName, :iconlocation, :shorthand, :optiongroup)
                      ");
      $database->bind(":locationName", $locationobject->locationName);
      $database->bind(":iconlocation", $locationobject->iconlocation);
      $database->bind(":shorthand", $locationobject->shorthand);
      $database->bind(":optiongroup", $locationobject->optiongroup);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyLocationById($locationobject) {
      $database = new Database();
      $database->query("UPDATE location
                        SET location.locationName = :locationName,
                            location.iconlocation = :iconlocation,
                            location.shorthand = :shorthand,
                            location.optiongroup = :optiongroup
                        WHERE location.id = :id
                      ");
      $database->bind(":id", $locationobject->id);
      $database->bind(":locationName", $locationobject->locationName);
      $database->bind(":iconlocation", $locationobject->iconlocation);
      $database->bind(":shorthand", $locationobject->shorthand);
      $database->bind(":optiongroup", $locationobject->optiongroup);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getLocationById($locationid) {
      $database = new Database();
      $database->query("SELECT * FROM location
                        WHERE id = :id");
      $database->bind(":id", $locationid);
      $result = $database->single();
      return $result;
    }

}
