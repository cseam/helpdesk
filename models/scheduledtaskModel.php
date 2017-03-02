<?php

  class scheduledtaskModel {
    public function __construct()
    { }

    public function getScheduledTasksByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM scheduled_calls
                        WHERE FIND_IN_SET(helpdesk, :helpdesk)");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function getTaskDetailsById($taskid) {
      $database = new Database();
      $database->query("SELECT * FROM scheduled_calls
                        WHERE callid = :taskid");
      $database->bind(':taskid', $taskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function updateTaskWithObject($updatedTask) {
      $database = new Database();
      $database->query("UPDATE scheduled_calls
                        SET scheduled_calls.enabled = :enabled,
                            scheduled_calls.title = :title,
                            scheduled_calls.details = :details,
                            scheduled_calls.assigned = :assigned,
                            scheduled_calls.frequencytype = :reoccurance,
                            scheduled_calls.startschedule = :starton
                        WHERE scheduled_calls.callid = :callid");
      $database->bind(':callid', $updatedTask->callid);
      $database->bind(':enabled', $updatedTask->enabled);
      $database->bind(':title', $updatedTask->title);
      $database->bind(':details', $updatedTask->details);
      $database->bind(':assigned', $updatedTask->assigned);
      $database->bind(':reoccurance', $updatedTask->reoccurance);
      $database->bind(':starton', $updatedTask->starton);
      $database->execute();
      return;
    }

    public function removeScheduledTaskById($taskid) {
      $database = new Database();
      $database->query("DELETE FROM scheduled_calls
                        WHERE callid = :taskid");
      $database->bind(':taskid', $taskid);
      $database->execute();
      return true;
    }

    public function disableAllScheduledTasksByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("UPDATE scheduled_calls
                        SET scheduled_calls.enabled = 0
                        WHERE scheduled_calls.helpdesk = :helpdeskid");
      $database->bind(':helpdeskid', $helpdeskid);
      $database->execute();
      return;
    }

    public function enableAllScheduledTasksByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("UPDATE scheduled_calls
                        SET scheduled_calls.enabled = 1
                        WHERE scheduled_calls.helpdesk = :helpdeskid");
      $database->bind(':helpdeskid', $helpdeskid);
      $database->execute();
      return;
    }

    public function createNewTicket($baseTicket) {
      $database = new Database();
      $database->query("INSERT INTO scheduled_calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid, frequencytype, startschedule)
                        VALUES (:name, :contact_email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoice, :callreason, :title, :lockerid, :frequencytype, :startschedule)");
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

    public function getLastComplianceDate($search) {
      $database = new Database();
      $database->query("SELECT calls.closed, calls.callid, datediff(CURDATE(), calls.closed) as daysago, engineers.engineerName
                        FROM calls
                        JOIN engineers ON calls.closeengineerid=engineers.idengineers
                        WHERE calls.title = :search
                        AND calls.status = 2
                        ORDER BY calls.callid DESC
                        LIMIT 1
                        ");
      $database->bind(':search', $search);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

}
