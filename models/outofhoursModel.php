<?php

  class outofhoursModel {
    public function __construct()
    { }

    public function getOutOfHours($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM out_of_hours
                        ORDER BY id DESC");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function addOutofhours($name, $dateofcall, $timeofcall, $calloutby, $problem, $previsit, $timeonsite, $timeleftsite, $locations, $resolution) {
      $database = new Database();
      $database->query("INSERT INTO out_of_hours (name, dateofcall, timeofcall, calloutby, problem, previsit, timeonsite, timeleftsite, locations, resolution)
                        VALUES (:name, :dateofcall, :timeofcall, :calloutby, :problem, :previsit, :timeonsite, :timeleftsite, :locations, :resolution)");
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

    public function getOutOfHoursMessages() {
      $database = new Database();
      $database->query("SELECT out_of_hours_contact_details.*, helpdesks.helpdesk_name FROM out_of_hours_contact_details
                        JOIN helpdesks ON out_of_hours_contact_details.helpdesk = helpdesks.id
                        ORDER BY out_of_hours_contact_details.helpdesk
                        ");
      $results = $database->resultset();
      return $results;
    }

    public function updateOutOfHoursMessages($newmessage) {
      $database = new Database();
      $database->query("UPDATE out_of_hours_contact_details
                        SET out_of_hours_contact_details.message = :message,
                            out_of_hours_contact_details.end_of_day = :endofday,
                            out_of_hours_contact_details.helpdesk = :helpdesk
                        WHERE out_of_hours_contact_details.id = :id
                        ");
      $database->bind(':id', $newmessage->id);
      $database->bind(':message', $newmessage->message);
      $database->bind(':endofday', $newmessage->end_of_day);
      $database->bind(':helpdesk', $newmessage->helpdesk);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getOutOfHoursMessagesById($id) {
      $database = new Database();
      $database->query("SELECT * FROM out_of_hours_contact_details
                        WHERE id=:id");
      $database->bind(':id', $id);
      $result = $database->single();
      return $result;
    }

}
