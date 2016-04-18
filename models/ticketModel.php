<?php

  class ticketModel {
    public function __construct()
    { }

    public function getMyTickets($username, $limit = 10) {
      $database = new Database();
      $database->query("SELECT * FROM calls
                        JOIN status ON calls.status=status.id
                        WHERE owner = :username
                        ORDER BY callid DESC
                        LIMIT :limit");
      $database->bind(":username", $username);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getMyOpenAssignedTickets($engineerid) {
      $database = new Database();
      $database->query("SELECT * FROM calls
                        JOIN status ON calls.status=status.id
                        WHERE assigned = :engineerid
                        AND status != 2
                        ORDER by callid");
      $database->bind(":engineerid", $engineerid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getAllTickets($limit = 10) {
      $database = new Database();
      $database->query("SELECT * FROM calls
                        JOIN status ON calls.status=status.id
                        ORDER BY callid DESC
                        LIMIT :limit");
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getTicketsByHelpdesk($helpdeskid = 0, $limit = 10) {
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE calls.helpdesk = :helpdesk
                        ORDER BY callid DESC
                        LIMIT :limit");
      $database->bind(":helpdesk", $helpdeskid);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getTicketDetails($ticketid) {
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT OUTER JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        JOIN categories ON calls.category=categories.id
                        WHERE callid = :ticketid");
      $database->bind(":ticketid", $ticketid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function getOldestTicketByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM calls
                        LEFT OUTER JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE engineers.helpdesk
                        IN (:helpdesk)
                        AND status != 2
                        ORDER BY opened
                        LIMIT 1");
      $database->bind(":helpdesk", $helpdeskid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function getOldestTicketByEngineer($engineerid) {
      $database = new Database();
      $database->query("SELECT * FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE calls.assigned
                        IN (:engineer)
                        AND status != 2
                        ORDER BY calls.opened
                        LIMIT 1");
      $database->bind(":engineer", $engineerid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function getAdditionalDetails($ticketid) {
      $database = new Database();
      $database->query("SELECT * FROM call_additional_results
                        WHERE callid = :ticketid");
      $database->bind(":ticketid", $ticketid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getAllEscalatedTickets() {
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold FROM calls
                        LEFT OUTER JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE status = 4
                        ORDER BY opened");
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getEscalatedTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE status = 4
                        AND FIND_IN_SET(calls.helpdesk, :helpdesk)
                        ORDER BY opened
                        ");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getUnassignedTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT OUTER JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND calls.assigned IS NULL
                        AND calls.status !=2
                        ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getAssignedTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND calls.assigned IS NOT NULL
                        AND calls.status != 2 ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getOpenTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT OUTER JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND calls.status != 2
                        ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getStagnateTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT OUTER JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND status IN (1,4)
                        AND DATE(calls.lastupdate) <= DATE_SUB(CURDATE(),INTERVAL 72 HOUR)
                        ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function get7DayTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT OUTER JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND status != 2
                        AND DATE(calls.opened) <= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
                        ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getSentAwayTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND status = 5
                        ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getOnHoldTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND status = 3
                        ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getClosedTicketsByHelpdesk($helpdeskid, $limit = 1000) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND status = 2
                        ORDER BY opened DESC
                        LIMIT :limit");
      $database->bind(":helpdesk", $helpdeskid);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getTicketsForInvoiceByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND requireinvoice = 1
                        ORDER BY opened
                        LIMIT 200");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
      return $results;
    }

    public function getLastViewedByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT engineers.sAMAccountName, engineers.idengineers, engineers.engineerName FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE FIND_IN_SET(engineers.helpdesk, :helpdesk)
                        AND engineers.disabled != 1
                        GROUP BY assigned
                        ORDER BY calls.helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null;}
        // now have list of enginners with tickets open in $results, itterate over and get last ticket looked at
        // create new array to store enginner results in
        $ticketviews = [];
        foreach($results as $key => $value) {
        // query each engineer (//TODO this is a clown fiesta should be done in 1 query above (note to future self FIX THIS))
        $database->query("SELECT engineers.engineerName, call_views.callid, call_views.stamp, calls.title, calls.status, status.statusCode, calls.opened, datediff(CURDATE(),calls.opened) as daysold, timediff(NOW(),call_views.stamp) as minago, location.locationName, location.iconlocation
                          FROM call_views
                          JOIN calls ON call_views.callid=calls.callid
                          JOIN status ON calls.status=status.id
                          JOIN location ON calls.location=location.id
                          JOIN engineers ON call_views.sAMAccountName=engineers.sAMAccountName
                          WHERE call_views.sAMAccountName=:sAMAccountName
                          ORDER BY call_views.id DESC
                          LIMIT 1
                          ");
        $database->bind(":sAMAccountName", $value["sAMAccountName"]);
        $results = $database->single();
        if ($database->rowcount() > 0) {array_push($ticketviews, $results);}
        }
      return $ticketviews;
    }

    public function getJobSheetByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold FROM calls
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE calls.status !=2
                        AND FIND_IN_SET(calls.helpdesk, :helpdesk)
                        ORDER BY calls.assigned, calls.opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) {return null;}
      return $results;
    }

    public function getRecentActivityByOwner($owner) {
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold FROM calls
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        LEFT OUTER JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE lastupdate >= DATE_SUB(CURDATE(),INTERVAL 5 DAY)
                        AND owner = :owner
                        ORDER BY callid DESC");
      $database->bind(":owner", $owner);
      $results = $database->resultset();
      if ($database->rowcount() === 0) {return null;}
      return $results;
    }

    public function searchTicketsByTerm($term, $limit = 150) {
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold FROM calls
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE (details LIKE :term OR callid LIKE :term OR title LIKE :term OR name LIKE :term OR email LIKE :term OR tel LIKE :term OR room LIKE :term)
                        ORDER BY callid DESC
                        LIMIT :limit");
      $wildcard = '%'.$term.'%';
      $database->bind(":term", $wildcard);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function logViewTicketById($ticketid, $sAMAccountName) {
      $database = new Database();
      $database->query("INSERT INTO call_views (sAMAccountName, callid)
                        VALUES (:sAMAccountName , :callid)");
      $database->bind(":callid", $ticketid);
      $database->bind(":sAMAccountName", $sAMAccountName);
      $database->execute();
      return null;
    }

    public function updateTicketStatusById($ticketid, $statuscode) {
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.status = :statuscode
                        WHERE calls.callid = :callid");
      $database->bind(":callid", $ticketid);
      $database->bind(":statuscode", $statuscode);
      $database->execute();
      return null;
    }

    public function updateTicketRequireInvoiceById($ticketid) {
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.requireinvoice = 1
                        WHERE calls.callid = :callid");
      $database->bind(":callid", $ticketid);
      $database->execute();
      return null;
    }

    public function updateTicketDetailsById($ticketid, $statuscode = "update", $sAMAccountName = "unknown", $update = "") {
      $message = "<div class=update>" . $update . "<h3 class=".$statuscode.">".$statuscode." by ".$sAMAccountName." - " . date("d/m/Y H:i") . "</h3></div>";
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.details = CONCAT(calls.details, :details), calls.lastupdate = :lastupdate
                        WHERE calls.callid = :callid");
      $database->bind(":callid", $ticketid);
      $database->bind(":details", $message);
      $database->bind(":lastupdate", date("c"));
      $database->execute();
      return null;
    }

    public function closeTicketById($ticketid, $engineerid, $closereason) {
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.closed = :closed, calls.status = 2, calls.callreason = :closereason, calls.lastupdate = :lastupdate, calls.closeengineerid = :closeengineerid
                        WHERE calls.callid = :callid");
      $database->bind(":callid", $ticketid);
      $database->bind(":closeengineerid", $engineerid);
      $database->bind(":closereason", $closereason);
      $database->bind(":closed", date("c"));
      $database->bind(":lastupdate", date("c"));
      $database->execute();
      return null;
    }

    public function updateTicketHelpdeskById($ticketid, $helpdeskid) {
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.helpdesk = :helpdesk
                        WHERE calls.callid = :callid");
      $database->bind(":callid", $ticketid);
      $database->bind(":helpdesk", $helpdeskid);
      $database->execute();
      return null;
    }

    public function updateTicketRemoveAssignmentById($ticketid) {
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.assigned = NULL
                        WHERE calls.callid = :callid");
      $database->bind(":callid", $ticketid);
      $database->execute();
      return null;
    }

    public function updateTicketAssignmentById($ticketid, $assigned) {
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.assigned = :assigned
                        WHERE calls.callid = :ticket");
      $database->bind(":ticket", $ticketid);
      $database->bind(":assigned", $assigned);
      $database->execute();
      return null;
    }

    public function updateTicketReasonById($ticketid, $reasonid) {
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.callreason = :reason
                        WHERE calls.callid = :ticket");
      $database->bind(":ticket", $ticketid);
      $database->bind(":reason", $reasonid);
      $database->execute();
      return null;
    }

    public function createNewTicket($baseTicket) {
      $database = new Database();
      $database->query("INSERT INTO calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid, pm)
                        VALUES (:name, :contact_email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoice, :callreason, :title, :lockerid, :pm)");
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
      $database->bind(":pm", $baseTicket->pm);
      $database->execute();
      return $database->lastInsertId();
    }

}
