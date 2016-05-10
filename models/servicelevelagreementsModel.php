<?php

  class servicelevelagreementsModel {
  public function __construct()
    { }

  public function getListOfSLAs() {
    $database = new Database();
    $database->query("SELECT service_level_agreement.*, helpdesk.helpdesk_name
                      FROM service_level_agreement
                      JOIN helpdesks ON service_level_agreement.helpdesk = helpdesks.id
                      ORDER BY service_level_agreement.helpdesk
                      ");
    $results = $database->resultset();
    if ($database->rowCount() === 0) {return null;}
    return $results;
  }

  public function removeSLAById($id) {
    $database = new Database();
    $database->query("DELETE FROM service_level_agreement
                      WHERE id=:id");
    $database->bind(':id', $id);
    $database->execute();
    return true;
  }

  public function upsertSLA($slaobject) {
    isset($slaobject->id) ? $this->modifySLAById($slaobject) : $this->addSLA($slaobject);
  }

  public function addSLA($slaobject) {
    $database = new Database();
    $database->query("INSERT INTO service_level_agreement (helpdesk, urgency, agreement, close_eta_days)
                      VALUES (:helpdesk, :urgency, :agreement, :close_eta_days)
                      ");
    $database->bind(":helpdesk", $slaobject->helpdesk);
    $database->bind(":urgency", $slaobject->urgency);
    $database->bind(":agreement", $slaobject->agreement);
    $database->bind(":close_eta_days", $slaobject->close_eta_days);
    $database->execute();
    return $database->lastInsertId();
  }

  public function modifySLAById($slaobject) {
    $database = new Database();
    $database->query("UPDATE service_level_agreement
                      SET service_level_agreement.helpdesk = :helpdesk,
                          service_level_agreement.urgency = :urgency,
                          service_level_agreement.agreement = :agreement,
                          service_level_agreement.close_eta_days = :close_eta_days
                      WHERE service_level_agreement.id= :id
                      ");
    $database->bind(":id", $slaobject->id);
    $database->bind(":helpdesk", $slaobject->helpdesk);
    $database->bind(":urgency", $slaobject->urgency);
    $database->bind(":agreement", $slaobject->agreement);
    $database->bind(":close_eta_days", $slaobject->close_eta_days);
    $database->execute();
    return $database->lastInsertId();
  }

  public function getSLAById($id) {
    $database = new Database();
    $database->query("SELECT * FROM service_level_agreement
                      WHERE id=:id");
    $database->bind(":id", $id);
    $result = $database->single();
    return $result;
  }

}
