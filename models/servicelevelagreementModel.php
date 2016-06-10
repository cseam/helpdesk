<?php

  class servicelevelagreementModel {
  // function for total mins
  function getTotalMinutes(DateInterval $int){
      return ($int->d * 24 * 60) + ($int->h * 60) + $int->i;
  }

  public function __construct()
    { }

  public function getListOfSLAs() {
    $database = new Database();
    $database->query("SELECT service_level_agreement.*, helpdesks.helpdesk_name
                      FROM service_level_agreement
                      JOIN helpdesks ON service_level_agreement.helpdesk = helpdesks.id
                      ORDER BY service_level_agreement.helpdesk, service_level_agreement.urgency
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

  public function GetFailedSLAThisMonth($scope = null) {
    isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
    $database = new Database();
    $database->query("SELECT calls.callid, calls.title, helpdesks.helpdesk_name, engineers.engineerName, calls.urgency, service_level_agreement.close_eta_days, datediff(calls.closed, calls.opened) AS 'total_days_to_close'
                      FROM calls
                      INNER JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk
                      JOIN helpdesks ON calls.helpdesk = helpdesks.id
                      JOIN engineers ON engineers.idengineers=calls.assigned
                      WHERE service_level_agreement.urgency = calls.urgency
                      AND Year(closed) = :year
                      AND Month(closed) = :month
                      AND FIND_IN_SET(calls.helpdesk, :scope)
                      ORDER BY assigned ");
    $database->bind(':month', date("m"));
    $database->bind(':year', date("o"));
    $database->bind(':scope', $helpdesks);
    $result = $database->resultset();
    if ($database->rowCount() === 0) { return null;}
    return $result;
  }

  public function GetSLAPerformance($scope = null, $startdate, $enddate, $urgency) {
    isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
    $database = new Database();
    $database->query("SELECT calls.callid, calls.urgency, service_level_agreement.agreement, service_level_agreement.close_eta_days, call_updates.stamp, call_updates.status, calls.opened, calls.closed, service_level_agreement.firstresponse_in_min
                      FROM calls
                      INNER JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk
                      JOIN call_updates on calls.callid=call_updates.callid
                      WHERE calls.urgency = :urgency
                      AND service_level_agreement.urgency=:urgency
                      AND year(opened) = :year
                      AND Month(opened) = :month
                      AND FIND_IN_SET(calls.helpdesk, :scope)
                      AND call_updates.status = 1
                      AND calls.status = 2
                      GROUP BY calls.callid
                      ORDER BY calls.callid
                      ");
    $database->bind(':month', date("m")-1);
    $database->bind(':year', date("o"));
    $database->bind(':scope', $helpdesks);
    $database->bind(':urgency', $urgency);
    $result = $database->resultset();
    if ($database->rowCount() === 0) { return null;}
    // create counters
    $countTotal = 0;
    $countRTSuccess = 0;
    $countFRSuccess = 0;
    // loop results
    foreach ($result as &$value) {
        // increment totals
        $countTotal++;
        // setup dates
        $op = date_create($value['opened']); // ticket open datetime
        $cl = date_create($value['closed']); // ticket closed datetime
        $fr = date_create($value['stamp']); // ticket first response datetime
        $dtdiff = date_diff($op, $cl);
        $frdiff = date_diff($fr, $op);
        // process dates
        if ($dtdiff->format('%a') <= $value['close_eta_days']) {
          // increment counter if closed before close eta in days
          $countRTSuccess++;
        }
        if ($this->getTotalMinutes($frdiff) <= $value['firstresponse_in_min']) {
          // increment counter if first response before first response in min
          $countFRSuccess++;
        }
    }
    // return formated results
    $totals['SLA'] = $urgency;
    $totals['Agreement'] = $result[0]["agreement"];
    $totals['Total'] = $countTotal;
    $totals['FirstResponseSuccess'] = $countFRSuccess;
    $totals['ResponseTimeSuccess'] = $countRTSuccess;
    return $totals;
  }


}
