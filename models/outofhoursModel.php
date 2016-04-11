<?php

  class outofhoursModel {
    public function __construct()
    { }

    public function getOutOfHours($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM out_of_hours ORDER BY id DESC");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function addOutofhours($name, $dateofcall, $timeofcall, $calloutby, $problem, $previsit, $timeonsite, $timeleftsite, $locations, $resolution) {
      $database = new Database();
      $database->query("INSERT INTO out_of_hours (name, dateofcall, timeofcall, calloutby, problem, previsit, timeonsite, timeleftsite, locations, resolution) VALUES (:name, :dateofcall, :timeofcall, :calloutby, :problem, :previsit, :timeonsite, :timeleftsite, :locations, :resolution)");
      $database->bind(':name', $name);
      $database->bind(':dateofcall', $dateofcall);
      $database->bind(':timeofcall', $timeofcall);
      $database->bind(':calloutby', $calloutby);
      $database->bind(':problem', $problem);
      $database->bind(':previsit', $previsit);
      $database->bind(':timeonsite', $timeonsite);
      $database->bind(':timeleftsite', $timeleftsite);
      $database->bind(':locations', $locations);
      $database->bind(':resolution', $resolution);
      $database->execute();
      return true;
    }

}
