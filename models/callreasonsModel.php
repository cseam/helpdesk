<?php

  class callreasonsModel {
    public function __construct()
    { }

    public function getReasonsByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT callreasons.id, callreasons.reason_name FROM callreasons
                        WHERE helpdesk_id IN(:helpdesk)
                        ORDER BY callreasons.reason_name ASC
                        ");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getListOfReasons() {
      $database = new Database();
      $database->query("SELECT * FROM callreasons
                        JOIN helpdesks ON callreasons.helpdesk_id = helpdesks.id
                        ");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function removeReasonById($id) {
      $database = new Database();
      $database->query("DELETE FROM callreasons WHERE id=:id");
      $database->bind(':id', $id);
      $database->execute();
      return true;
    }

    public function upsertReason($reasonobject) {
      isset($reasonobject->id) ? $this->modifyReason($reasonobject) : $this->addReason($reasonobject);
    }

    public function addReason($reasonobject) {
      $database = new Database();
      $database->query("INSERT INTO callreasons (reason_name, helpdesk_id)
                        VALUES (:reason_name, :helpdesk_id)
                        ");
      $database->bind(':reason_name', $reasonobject->reason_name);
      $database->bind(':helpdesk_id', $reasonobject->helpdesk_id);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyReason($reasonobject) {
      $database = new Database();
      $database->query("UPDATE callreasons
                        SET callreasons.reason_name = :reason_name,
                            callreasons.helpdesk_id = :helpdesk_id
                        WHERE callreasons.id = :id
                      ");
      $database->bind(':id', $reasonobject->id);
      $database->bind(':reason_name', $reasonobject->reason_name);
      $database->bind(':helpdesk_id', $reasonobject->helpdesk_id);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getReasonById($id) {
      $database = new Database();
      $database->query("SELECT * FROM callreasonsModel
                        WHERE id=:id");
      $database->bind(':id', $id);
      $result = $database->single();
      return $result; 
    }

}
