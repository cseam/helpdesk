<?php

  class callreasonsModel {
    public function __construct()
    { }

    public function getReasonsByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT call_reasons.id, call_reasons.reason_name FROM call_reasons
                        WHERE helpdesk_id IN(:helpdesk)
                        ORDER BY call_reasons.reason_name ASC
                        ");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function getListOfReasons() {
      $database = new Database();
      $database->query("SELECT call_reasons.*, helpdesks.helpdesk_name FROM call_reasons
                        JOIN helpdesks ON call_reasons.helpdesk_id = helpdesks.id
                        ORDER BY helpdesk_id
                        ");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function removeReasonById($id) {
      $database = new Database();
      $database->query("DELETE FROM call_reasons WHERE id=:id");
      $database->bind(':id', $id);
      $database->execute();
      return true;
    }

    public function upsertReason($reasonobject) {
      isset($reasonobject->id) ? $this->modifyReason($reasonobject) : $this->addReason($reasonobject);
    }

    public function addReason($reasonobject) {
      $database = new Database();
      $database->query("INSERT INTO call_reasons (reason_name, helpdesk_id)
                        VALUES (:reason_name, :helpdesk_id)
                        ");
      $database->bind(':reason_name', $reasonobject->reason_name);
      $database->bind(':helpdesk_id', $reasonobject->helpdesk_id);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyReason($reasonobject) {
      $database = new Database();
      $database->query("UPDATE call_reasons
                        SET call_reasons.reason_name = :reason_name,
                            call_reasons.helpdesk_id = :helpdesk_id
                        WHERE call_reasons.id = :id
                      ");
      $database->bind(':id', $reasonobject->id);
      $database->bind(':reason_name', $reasonobject->reason_name);
      $database->bind(':helpdesk_id', $reasonobject->helpdesk_id);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getReasonById($id) {
      $database = new Database();
      $database->query("SELECT * FROM call_reasons
                        WHERE id=:id");
      $database->bind(':id', $id);
      $result = $database->single();
      return $result;
    }

}
