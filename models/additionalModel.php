<?php

  class additionalModel {
  public function __construct()
    { }

    public function getListOfAdditionalFieldsByCategorys($categoryid) {
      $database = new Database();
      $database->query("SELECT * FROM call_additional_fields
                        WHERE typeid = :typeid");
      $database->bind(":typeid", $categoryid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function countFieldsByCategoryId($categoryid) {
      $database = new Database();
      $database->query("SELECT COUNT(*) as count FROM call_additional_fields
                        WHERE typeid = :typeid");
      $database->bind(":typeid", $categoryid);
      $results = $database->single();
      if ($database->rowCount() === 0) { return 0; }
      return $results["count"];
    }

    public function addAdditionalResult($callid, $label, $value) {
      $database = new Database();
      $database->query("INSERT INTO call_additional_results (callid, label, value)
                        VALUES (:callid , :label, :value)");
      $database->bind(":callid", $callid);
      $database->bind(":label", $label);
      $database->bind(":value", $value);
      $database->execute();
      return null;
    }

    public function getListOfAdditionalFields() {
      $database = new Database();
      $database->query("SELECT call_additional_fields.*, categories.categoryName, helpdesks.helpdesk_name FROM call_additional_fields
                        JOIN categories ON categories.id = call_additional_fields.typeid
                        JOIN helpdesks ON categories.helpdesk = helpdesks.id
                        ORDER BY typeid
                        ");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function removeAdditionalFieldsById($id) {
      $database = new Database();
      $database->query("DELETE FROM call_additional_fields WHERE id=:id");
      $database->bind(":id", $id);
      $database->execute();
      return true;
    }

    public function upsertAdditionalFields($additionalfields) {
      isset($additionalfields->id) ? $this->modifyAdditionalFieldsById($additionalfields) : $this->addAdditionalFields($additionalfields);
    }

    public function addAdditionalFields($additionalfields) {
      $database = new Database();
      $database->query("INSERT INTO call_additional_fields (typeid, label)
                        VALUES (:typeid, :label)
                        ");
      $database->bind(":typeid", $additionalfields->typeid);
      $database->bind(":label", $additionalfields->label);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyAdditionalFieldsById($additionalfields) {
      $database = new Database();
      $database->query("UPDATE call_additional_fields
                        SET call_additional_fields.typeid = :typeid,
                            call_additional_fields.label = :label
                        WHERE call_additional_fields.id = :id
                        ");
      $database->bind(":id", $additionalfields->id);
      $database->bind(":typeid", $additionalfields->typeid);
      $database->bind(":label", $additionalfields->label);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getAdditionalFieldsById($id) {
      $database = new Database();
      $database->query("SELECT * FROM call_additional_fields
                        WHERE id = :id");
      $database->bind(":id", $id);
      $result = $database->single();
      return $result;
    }

}
