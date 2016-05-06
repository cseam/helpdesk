<?php

  class helpdeskModel {
  public function __construct()
    { }

    public function getFriendlyHelpdeskName($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM helpdesks
                        WHERE id = :helpdeskid");
      $database->bind(":helpdeskid", $helpdeskid);
      $results = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getListOfHelpdesks() {
      $database = new Database();
      $database->query("SELECT * FROM helpdesks");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getListOfHelpdeskWithoutDeactivated() {
      $database = new Database();
      $database->query("SELECT * FROM helpdesks
                        WHERE deactivate !=1
                        ORDER BY helpdesk_name");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getHelpdeskDescription($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM helpdesks
                        WHERE id = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function isHelpdeskAutoAssign($helpdeskid) {
      $database = new Database();
      $database->query("SELECT auto_assign FROM helpdesks
                        WHERE id = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function isHelpdeskEmailEnabled($helpdeskid) {
      $database = new Database();
      $database->query("SELECT engineerEmail FROM engineers
                        JOIN helpdesks ON engineers.helpdesk=helpdesks.id
                        WHERE engineers.helpdesk = :helpdesk
                        AND helpdesks.email_on_newticket = 1");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getEngineerEmails($helpdeskid) {
      $database = new Database();
      $database->query("SELECT engineerEmail FROM engineers
                        WHERE engineers.helpdesk IN(:helpdesk)
                        AND engineers.disabled !=1");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() ===0) { return null;}
      return $results;
    }

    public function getSLADetailsByUrgencyId($urgency, $helpdeskid) {
      $database = new Database();
      $database->query("SELECT agreement, close_eta_days FROM service_level_agreement
                        WHERE helpdesk = :helpdesk
                        AND urgency = :urgency");
      $database->bind(":helpdesk", $helpdeskid);
      $database->bind(":urgency", $urgency);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function getOutOfHoursContactDetailsByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM out_of_hours_contact_details
                        WHERE helpdesk = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      $ofhTime = $result['end_of_day'];
      $ofhMessage = $result['message'];
      $hour = date("G");
      if ($hour > $ofhTime) { return $ofhMessage; } else { return null; }
    }

    public function removeHelpdeskById($id) {
      $database = new Database();
      //$database->query("DELETE FROM helpdesks WHERE id=:id");
      $database->query("UPDATE helpdesks
                        SET helpdesks.deactivate = 1
                        WHERE helpdesks.id = :id
      ");
      $database->bind(':id', $id);
      $database->execute();
      return true;
    }

    public function upsertHelpdesk($helpdeskobject) {
      isset($helpdeskobject->id) ? $this->modifyHelpdesk($helpdeskobject) : $this->addHelpdesk($helpdeskobject);
    }

    public function addHelpdesk($helpdeskobject) {
      $database = new Database();
      $database->query("INSERT INTO helpdesks (helpdesk_name, description, deactivate, auto_assign, email_on_newticket)
                        VALUES (:helpdesk_name, :description, :deactivate, :auto_assign, :email_on_newticket)
                      ");
      $database->bind(':helpdesk_name', $helpdeskobject->helpdesk_name);
      $database->bind(':description', $helpdeskobject->description);
      $database->bind(':deactivate', $helpdeskobject->deactivate);
      $database->bind(':auto_assign', $helpdeskobject->auto_assign);
      $database->bind(':email_on_newticket', $helpdeskobject->email_on_newticket);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyHelpdesk($helpdeskobject) {
      $database = new Database();
      $database->query("UPDATE helpdesks
                        SET helpdesks.helpdesk_name = :helpdesk_name,
                            helpdesks.description = :description,
                            helpdesks.deactivate = :deactivate,
                            helpdesks.auto_assign = :auto_assign,
                            helpdesks.email_on_newticket = :email_on_newticket
                        WHERE helpdesks.id = :id
                      ");
      $database->bind(':id', $helpdeskobject->id);
      $database->bind(':helpdesk_name', $helpdeskobject->helpdesk_name);
      $database->bind(':description', $helpdeskobject->description);
      $database->bind(':deactivate', $helpdeskobject->deactivate);
      $database->bind(':auto_assign', $helpdeskobject->auto_assign);
      $database->bind(':email_on_newticket', $helpdeskobject->email_on_newticket);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getHelpdeskById($id) {
      $database = new Database();
      $database->query("SELECT *
                        FROM helpdesks
                        WHERE id=:id
                      ");
      $database->bind(':id', $id);
      $result = $database->single();
      return $result;
    }

}
