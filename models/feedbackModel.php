<?php

  class feedbackModel {

    private $_startrange = null;
    private $_endrangerange = null;
    private $_helpdesks = null;

    public function __construct()
    {
      // populate custom report values
      $this->_startrange = isset($_SESSION['customReportsRangeStart']) ? $_SESSION['customReportsRangeStart'] : date('Y-m-01');
      $this->_endrange = isset($_SESSION['customReportsRangeEnd']) ? $_SESSION['customReportsRangeEnd'] : date('Y-m-t');
      $this->_helpdesks = isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : null ;
    }

    public function addFeedbackToTicketById($ticketid, $satisfaction, $details) {
      $database = new Database();
      $database->query("INSERT INTO feedback (callid, satisfaction, details, opened)
                        VALUES (:id, :satisfaction, :details, :feedbackdate)");
      $database->bind(':id', $ticketid);
      $database->bind(':satisfaction', $satisfaction);
      $database->bind(':details', $details);
      $database->bind(':feedbackdate', date("c"));
      $database->execute();
      return true;
    }

    public function getPoorFeedback($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT calls.callid, engineers.engineerName, calls.owner, feedback.details, feedback.satisfaction
                        FROM feedback
                        JOIN calls ON feedback.callid=calls.callid
                        JOIN engineers ON engineers.idengineers=calls.closeengineerid
                        WHERE feedback.satisfaction IN (1,2)
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND feedback.opened BETWEEN :startrange AND :endrange
                        ");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function getFeedbackDetailsByEngineerId($id) {
      $database = new Database();
      $database->query("SELECT feedback.satisfaction, feedback.details, feedback.callid, calls.email
                        FROM feedback
                        JOIN calls on feedback.callid=calls.callid
                        JOIN engineers on engineers.idengineers=calls.closeengineerid
                        WHERE closeengineerid = :id
                        AND feedback.opened BETWEEN :startrange AND :endrange
                        ORDER BY feedback.opened DESC
                        ");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':id', $id);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }



}
