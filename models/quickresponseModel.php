<?php

  class quickresponseModel {
    public function __construct()
    { }

    public function getQuickResponseByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT quick_responses.id, quick_responses.quick_response
                        FROM quick_responses
                        WHERE helpdesk_id = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getListOfQuickResponses() {
      $database = new Database();
      $database->query("SELECT quick_responses.*, helpdesks.helpdesk_name FROM quick_responses
                        JOIN helpdesks ON quick_responses.helpdesk_id = helpdesks.id
                        ORDER BY quick_responses.helpdesk_id
                        ");
      $results = $database->resultset();
      return $results;
    }

    public function removeQuickResponseById($id) {
      $database = new Database();
      $database->query("DELETE FROM quick_responses WHERE id=:id");
      $database->bind(':id', $id);
      $database->execute();
      return true;
    }

    public function upsertQuickResponse($quickresponseobject) {
      isset($quickresponseobject->id) ? $this->modifyQuickResponse($quickresponseobject) : $this->addQuickResponse($quickresponseobject);
    }

    public function addQuickResponse($quickresponseobject) {
      $database = new Database();
      $database->query("INSERT INTO quick_responses (quick_response, helpdesk_id)
                        VALUES (:quick_response, :helpdesk_id)
                        ");
      $database->bind(':quick_response', $quickresponseobject->quick_response);
      $database->bind(':helpdesk_id', $quickresponseobject->helpdesk_id);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyQuickResponse($quickresponseobject) {
      $database = new Database();
      $database->query("UPDATE quick_responses
                        SET quick_responses.quick_response = :quick_response,
                            quick_responses.helpdesk_id = :helpdesk_id
                        WHERE quick_responses.id = :id
                        ");
      $database->bind(':id', $quickresponseobject->id);
      $database->bind(':categoryName', $quickresponseobject->quick_response);
      $database->bind(':helpdesk', $quickresponseobject->helpdesk_id);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getCategoryById($id) {
      $database = new Database();
      $database->query("SELECT *
                        FROM quick_responses
                        WHERE id=:id");
      $database->bind(':id', $id);
      $result = $database->single();
      return $result;
    }


}
