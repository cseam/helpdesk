<?php

  class scheduledtaskModel {
    public function __construct()
    { }

    public function getScheduledTasksByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM scheduled_calls WHERE helpdesk IN (:helpdesk)");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function removeScheduledTaskById($taskid) {
      $database = new Database();
      $database->query("DELETE FROM scheduled_calls WHERE callid = :taskid");
      $database->bind(':taskid', $taskid);
      $database->execute();
      return true;
    }

    public function createNewTicket($baseTicket) {
      $database = new Database();
      $database->query("INSERT INTO scheduled_calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid, frequencytype, startschedule) VALUES (:name, :contact_email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoice, :callreason, :title, :lockerid, :frequencytype, :startschedule)");
      $database->bind(":name", $baseTicket->name);
      $database->bind(":contact_email", $baseTicket->contact_email);
      $database->bind(":tel", $baseTicket->tel);
      $database->bind(":details", $baseTicket->details);
      $database->bind(":assigned", $baseTicket->assigned);
      $database->bind(":opened", $baseTicket->opened);
      $database->bind(":lastupdate", $baseTicket->lastupdate);
      $database->bind(":status", $baseTicket->status);
      $database->bind(":closed", $baseTicket->closed);
      $database->bind(":closeengineerid", $baseTicket->closeengineerid);
      $database->bind(":urgency", $baseTicket->urgency);
      $database->bind(":location", $baseTicket->location);
      $database->bind(":room", $baseTicket->room);
      $database->bind(":category", $baseTicket->category);
      $database->bind(":owner", $baseTicket->owner);
      $database->bind(":helpdesk", $baseTicket->helpdesk);
      $database->bind(":invoice", $baseTicket->invoice);
      $database->bind(":callreason", $baseTicket->callreason);
      $database->bind(":title", $baseTicket->title);
      $database->bind(":lockerid", $baseTicket->lockerid);
      $database->bind(":frequencytype", $baseTicket->frequencytype);
      $database->bind(":startschedule", $baseTicket->startschedule);
      $database->execute();
      return $database->lastInsertId();
    }

}
