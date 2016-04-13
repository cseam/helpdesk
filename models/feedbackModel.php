<?php

  class feedbackModel {
    public function __construct()
    { }

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

}
