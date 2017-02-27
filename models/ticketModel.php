<?php

  class ticketModel {

    private $_startrange = null;
    private $_endrange = null;
    private $_helpdesks = null;

    public function __construct()
    {
      // populate custom report values
      $this->_startrange = isset($_SESSION['customReportsRangeStart']) ? $_SESSION['customReportsRangeStart'] : date('Y-m-01');
      $this->_endrange = isset($_SESSION['customReportsRangeEnd']) ? $_SESSION['customReportsRangeEnd'] : date('Y-m-t');
      $this->_helpdesks = isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : null;
    }

    public function getMyTickets($username, $limit = 10) {
      $database = new Database();
      $database->query("SELECT * FROM calls
                        JOIN status ON calls.status=status.id
                        WHERE owner = :username
                        AND status != 2
                        ORDER BY callid DESC
                        LIMIT :limit");
      $database->bind(":username", $username);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function getTicketUpdatesByCallId($callid) {
      $database = new Database();
      $database->query("SELECT * FROM call_updates WHERE callid = :callid ORDER BY id");
      $database->bind(":callid", $callid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function getRecentTicketsByEngineerId($engineerid) {
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) AND calls.closeengineerid = :engineerid
                        ORDER BY opened DESC
                        ");
      $database->bind(":engineerid", $engineerid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
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
      if ($database->rowCount() === 0) { return null; }
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
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function getAllTicketsNoLimit() {
      $database = new Database();
      $database->query("SELECT * FROM calls
                        JOIN status ON calls.status=status.id
                        ORDER BY callid DESC
                        ");
      $results = $database->resultset();
      return $results;
    }

    public function getTicketsByHelpdesk($helpdeskid = 0, $limit = 10) {
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE calls.helpdesk = :helpdesk
                        ORDER BY callid DESC
                        LIMIT :limit");
      $database->bind(":helpdesk", $helpdeskid);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
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
      if ($database->rowCount() === 0) { return null; }
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
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function getOldestTicketByEngineer($engineerid) {
      $database = new Database();
      $database->query("SELECT * FROM calls
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE calls.assigned
                        IN (:engineer)
                        AND status != 2
                        ORDER BY calls.opened
                        LIMIT 1");
      $database->bind(":engineer", $engineerid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function getAdditionalDetails($ticketid) {
      $database = new Database();
      $database->query("SELECT * FROM call_additional_results
                        WHERE callid = :ticketid");
      $database->bind(":ticketid", $ticketid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null; }
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
      if ($database->rowcount() === 0) { return null; }
      return $results;
    }

    public function getEscalatedTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE status = 4
                        AND FIND_IN_SET(calls.helpdesk, :helpdesk)
                        ORDER BY opened
                        ");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null; }
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
      if ($database->rowcount() === 0) { return null; }
      return $results;
    }

    public function getAssignedTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND calls.assigned IS NOT NULL
                        AND calls.status != 2 ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null; }
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
      if ($database->rowcount() === 0) { return null; }
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
      if ($database->rowcount() === 0) { return null; }
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
      if ($database->rowcount() === 0) { return null; }
      return $results;
    }

    public function getSentAwayTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND status = 5
                        ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null; }
      return $results;
    }

    public function getOnHoldTicketsByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND status = 3
                        ORDER BY opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null; }
      return $results;
    }

    public function getClosedTicketsByHelpdesk($helpdeskid, $limit = 500) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND status = 2
                        ORDER BY opened DESC
                        LIMIT :limit");
      $database->bind(":helpdesk", $helpdeskid);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null; }
      return $results;
    }

    public function getTicketsForInvoiceByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold
                        FROM calls
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE FIND_IN_SET(calls.helpdesk, :helpdesk)
                        AND requireinvoice = 1
                        ORDER BY opened
                        LIMIT 250");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null; }
      return $results;
    }

    public function getLastViewedByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT engineers.sAMAccountName, engineers.idengineers, engineers.engineerName FROM calls
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE FIND_IN_SET(engineers.helpdesk, :helpdesk)
                        AND engineers.disabled != 1
                        GROUP BY assigned
                        ORDER BY calls.helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) { return null; }
        // now have list of enginners with tickets open in $results, itterate over and get last ticket looked at
        // create new array to store enginner results in
        $ticketviews = [];
        foreach ($results as $key => $value) {
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
        if ($database->rowcount() > 0) {array_push($ticketviews, $results); }
        }
      return $ticketviews;
    }

    public function getJobSheetByHelpdesk($helpdeskid) {
      // EPIC FAIL :( couldent get SQL IN to work with comma helpdesk list so using FIND IN SET as fudge, CLOWN FIESTA! (note to future self: FIX THIS!)
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold FROM calls
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE calls.status !=2
                        AND FIND_IN_SET(calls.helpdesk, :helpdesk)
                        ORDER BY calls.assigned, calls.status, calls.opened");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowcount() === 0) {return null; }
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
      if ($database->rowcount() === 0) {return null; }
      return $results;
    }

    public function searchTicketsByTerm($term, $scope = NULL, $limit = 150) {
      $database = new Database();
      $database->query("SELECT *, datediff(CURDATE(),calls.opened) as daysold FROM calls
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        LEFT JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE (details LIKE :term OR callid LIKE :term OR title LIKE :term OR name LIKE :term OR email LIKE :term OR tel LIKE :term OR room LIKE :term)
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        ORDER BY callid DESC
                        LIMIT :limit");
      $wildcard = '%'.$term.'%';
      $database->bind(":term", $wildcard);
      $database->bind(":scope", $scope);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
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

    /**
     * @param integer $statuscode
     */
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

    public function updateTicketInvoiceReceivedById($ticketid) {
        $database = new Database();
        $database->query("UPDATE calls
                          SET calls.requireinvoice = null,
                          calls.invoicedate = :invoicedate
                          WHERE calls.callid = :callid");
        $database->bind(":invoicedate", date("c"));
        $database->bind(":callid", $ticketid);
        $database->execute();
        return null;
    }

    /**
     * @param string $opened
     */
    public function updateTicketOpenById($ticketid, $opened) {
        $database = new Database();
        $database->query("UPDATE calls
                          SET
                          calls.original = calls.opened,
                          calls.opened = :opened,
                          calls.lastupdate = :lastupdate
                          WHERE calls.callid = :callid
                          ");
        $database->bind(":opened", $opened);
        $database->bind(":callid", $ticketid);
        $database->bind(":lastupdate", date("c"));
        $database->execute();
        return null;
    }

    /**
     * @param string $workedwith
     */
    public function updateTicketDetailsById($ticketid, $statuscode = "update", $sAMAccountName = "unknown", $update = "", $workedwith = null) {
      $message = "<div class=update>".$update."<h3 class=".$statuscode.">".$statuscode." by ".$sAMAccountName." - ".date("d/m/Y H:i")."</h3></div>";
      // update timestamp
      $database = new Database();
      $database->query("UPDATE calls
                        SET calls.lastupdate = :lastupdate
                        WHERE calls.callid = :callid");
      $database->bind(":callid", $ticketid);
      $database->bind(":lastupdate", date("c"));
      $database->execute();
      // update call_updates
        SWITCH ($statuscode) {
          CASE "scheduled":
            $status = 6;
          break;
          CASE "sendaway":
            $status = 5;
          break;
          CASE "hold":
            $status = 3;
          break;
          CASE "escalated":
            $status = 4;
          break;
          CASE "closed":
            $status = 2;
          break;
          default:
            $status = 1;
          break;
      }
      $database->query("INSERT INTO call_updates (callid, stamp, details, sAMAccountName, status, workedwith)
                        VALUES (:callid, :lastupdate, :details, :who, :status, :workedwith)");
      $database->bind(":callid", $ticketid);
      $database->bind(":details", $message);
      $database->bind(":lastupdate", date("c"));
      $database->bind(":who", $sAMAccountName);
      $database->bind(":status", $status);
      $database->bind(":workedwith", $workedwith);
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

    /**
     * @param stdClass $baseTicket
     */
    public function createNewTicket($baseTicket) {
      $database = new Database();
      $database->query("INSERT INTO calls (name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, invoicedate, callreason, title, lockerid, pm, requiredfor)
                        VALUES (:name, :contact_email, :tel, :details, :assigned, :opened, :lastupdate, :status, :closed, :closeengineerid, :urgency, :location, :room, :category, :owner, :helpdesk, :invoice, :callreason, :title, :lockerid, :pm, :requiredfor)");
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
      $database->bind(":requiredfor", $baseTicket->requiredfor);
      $database->execute();
      return $database->lastInsertId();
    }

    public function countUrgencyTotals($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT calls.urgency, count(calls.callid) AS Totals
                        FROM calls
                        JOIN categories ON calls.category=categories.id
                        WHERE calls.status = 2
                        AND calls.closed BETWEEN :startrange AND :endrange
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        GROUP BY calls.urgency
                        ORDER BY Totals");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      // update array values with friendly name as they arent in the db!!!!
      foreach ($result as $key => $value) {
        $result[$key]["urgency"] = urgency_friendlyname(array_values($value)[0]);
      }
      return $result;
    }

    public function countDayBreakdownTotals($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT engineers.engineerName,
                        helpdesks.helpdesk_name,
                        sum(case when hour(calls.closed) < 7 || hour(calls.lastupdate) < 7 THEN 1 ELSE 0 END) AS '0-7',
                        sum(case when hour(calls.closed) = 7 || hour(calls.lastupdate) = 7 THEN 1 ELSE 0 END) AS '7-8',
                        sum(case when hour(calls.closed) = 8 || hour(calls.lastupdate) = 8 THEN 1 ELSE 0 END) AS '8-9',
                        sum(case when hour(calls.closed) = 9 || hour(calls.lastupdate) = 9 THEN 1 ELSE 0 END) AS '9-10',
                        sum(case when hour(calls.closed) = 10 || hour(calls.lastupdate) = 10 THEN 1 ELSE 0 END) AS '10-11',
                        sum(case when hour(calls.closed) = 11 || hour(calls.lastupdate) = 11 THEN 1 ELSE 0 END) AS '11-12',
                        sum(case when hour(calls.closed) = 12 || hour(calls.lastupdate) = 12 THEN 1 ELSE 0 END) AS '12-13',
                        sum(case when hour(calls.closed) = 13 || hour(calls.lastupdate) = 13 THEN 1 ELSE 0 END) AS '13-14',
                        sum(case when hour(calls.closed) = 14 || hour(calls.lastupdate) = 14 THEN 1 ELSE 0 END) AS '14-15',
                        sum(case when hour(calls.closed) = 15 || hour(calls.lastupdate) = 15 THEN 1 ELSE 0 END) AS '15-16',
                        sum(case when hour(calls.closed) = 16 || hour(calls.lastupdate) = 16 THEN 1 ELSE 0 END) AS '16-17',
                        sum(case when hour(calls.closed) = 17 || hour(calls.lastupdate) = 17 THEN 1 ELSE 0 END) AS '17-18',
                        sum(case when hour(calls.closed) = 18 || hour(calls.lastupdate) = 18 THEN 1 ELSE 0 END) AS '18-19',
                        sum(case when hour(calls.closed) > 19 || hour(calls.lastupdate) > 19 THEN 1 ELSE 0 END) AS '19-24'
                        FROM engineers
                        JOIN calls ON calls.closeengineerid = engineers.idengineers
                        JOIN helpdesks ON engineers.helpdesk = helpdesks.id
                        WHERE engineers.disabled != 1
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY engineers.engineerName
                        ORDER BY helpdesks.id
                      ");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countPlannedVsReactiveTotals($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT calls.pm, count(calls.callid) AS Totals FROM calls
                        WHERE calls.status = 2
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY calls.pm
                        ORDER BY Totals");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      // else populate object with db results
      // update array values with friendly name as they arent in the db!!!!
      foreach ($result as $key => $value) {
        ($result[$key]["pm"] == 1 ? $result[$key]["pm"] = "Planned Tickets" : $result[$key]["pm"] = "Reactive Tickets");
      }
      return $result;
    }

    public function countWorkRateTotals($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT engineers.engineerName, helpdesks.helpdesk_name, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS Last7,
                        sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS Last1,
                        sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS Last30
                        FROM engineers
                        JOIN calls ON calls.closeengineerid = engineers.idengineers
                        JOIN helpdesks ON engineers.helpdesk=helpdesks.id
                        WHERE engineers.disabled != 1
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY engineers.engineerName
                        ORDER BY Last30 DESC");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countAssignedTickets($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT helpdesks.helpdesk_name, engineers.idengineers, engineers.engineerName, Count(assigned) AS HowManyAssigned, sum(case when status !=2 THEN 1 ELSE 0 END) AS OpenOnes
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN helpdesks ON engineers.helpdesk=helpdesks.id
                        WHERE engineers.disabled != 1
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        GROUP BY calls.assigned
                        ORDER BY calls.helpdesk");
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countReasonForTickets($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT call_reasons.reason_name, count(*) AS last7
                        FROM calls
                        INNER JOIN call_reasons ON calls.callreason = call_reasons.id
                        WHERE calls.status='2'
                        AND calls.closed BETWEEN :startrange AND :endrange
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        GROUP BY call_reasons.reason_name");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countEngineerFeedbackTotals($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT calls.closeengineerid, engineers.engineerName, helpdesks.helpdesk_name, AVG(feedback.satisfaction) as FeedbackAVG, COUNT(calls.callid) as FeedbackCOUNT
                        FROM calls
                        JOIN feedback ON feedback.callid=calls.callid
                        JOIN engineers ON engineers.idengineers=calls.closeengineerid
                        JOIN helpdesks ON engineers.helpdesk = helpdesks.id
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY calls.closeengineerid");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countAllTickets() {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countAllTickets
                        FROM calls");
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countAllOpenTickets() {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countAllOpenTickets
                        FROM calls
                        WHERE status !=2");
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countTicketsByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countTicketsByHelpdesk
                        FROM calls
                        WHERE helpdesk IN (:helpdeskid)");
      $database->bind(":helpdeskid", $helpdeskid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    /**
     * @param integer $statuscode
     */
    public function countTicketsByStatusCode($statuscode, $scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countTotal
                        FROM calls
                        WHERE status = :status
                        AND FIND_IN_SET(calls.helpdesk, :scope)");
      $database->bind(":status", $statuscode);
      $database->bind(":scope", $helpdesks);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countTicketsByOwner($owner) {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countTicketsByOwner
                        FROM calls
                        WHERE owner = :owner");
      $database->bind(":owner", $owner);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countTotalsThisYear($year) {
      $database = new Database();
      $database->query("SELECT Month(closed) AS MonthNum, count(callid) AS Totals
                        FROM calls
                        WHERE status = 2
                        AND Year(closed) = :year
                        GROUP BY Month(closed)
                        ORDER BY MonthNum, helpdesk");
      $database->bind(':year', $year);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countTotalsThisYearbyHelpdesk($year, $helpdesk) {
      $database = new Database();
      $database->query("SELECT MONTH(calls.closed) AS MonthNum, count(calls.callid) AS Totals
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk=helpdesks.id
                        WHERE calls.status = 2
                        AND calls.helpdesk = :helpdesk
                        AND Year(calls.closed) = :year
                        GROUP BY Month(calls.closed)
                        ORDER BY MonthNum, calls.helpdesk");
      $database->bind(':helpdesk', $helpdesk);
      $database->bind(':year', $year);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countEngineerTotalsLastWeek($engineerId) {
      $database = new Database();
      $database->query("SELECT DATE_FORMAT(closed, '%a') AS DAY_OF_WEEK
                        FROM calls
                        WHERE closeengineerid = :engineerId
                        AND closed >= DATE_SUB(CURDATE(),INTERVAL 1 WEEK)");
      $database->bind(':engineerId', $engineerId);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      $engineermon = $engineertue = $engineerwed = $engineerthu = $engineerfri = $engineersat = $engineersun = 0;

      foreach ($result as $key => $value) {
        SWITCH ($value["DAY_OF_WEEK"]) {
          CASE "Mon":
            ++$engineermon;
            break;
          CASE "Tue":
            ++$engineertue;
            break;
          CASE "Wed":
            ++$engineerwed;
            break;
          CASE "Thu":
            ++$engineerthu;
            break;
          CASE "Fri":
            ++$engineerfri;
            break;
          CASE "Sat":
            ++$engineersat;
            break;
          CASE "Sun":
            ++$engineersun;
            break;
        }
      }
      $count = array();
      $count["Mon"] = $engineermon;
      $count["Tue"] = $engineertue;
      $count["Wed"] = $engineerwed;
      $count["Thu"] = $engineerthu;
      $count["Fri"] = $engineerfri;
      $count["Sat"] = $engineersat;
      $count["Sun"] = $engineersun;
      return $count;
    }

    public function countClosedByEngineerIdLastWeek($engineerId) {
      $database = new Database();
      $database->query("SELECT count(closeengineerid) AS engineerClose
                        FROM calls
                        WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 1 WEEK)
                        AND closeengineerid = :engineerId ");
      $database->bind(':engineerId', $engineerId);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function countAllTicketsByEngineerIdLastWeek($engineerId) {
      $database = new Database();
      $database->query("SELECT count(callid) AS engineerAll
                        FROM calls
                        WHERE lastupdate >= DATE_SUB(CURDATE(),INTERVAL 1 WEEK)
                        AND assigned = :engineerId");
      $database->bind(':engineerId', $engineerId);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $result;
    }

    public function avgCloseTimeInDays() {
      $database = new Database();
      $database->query("SELECT helpdesks.helpdesk_name, avg(datediff(calls.closed, calls.opened)) as avg_days
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        GROUP BY helpdesk");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function advCloseTimeByHelpdeskIdInDays($helpdesk) {
      $database = new Database();
      $database->query("SELECT avg(datediff(calls.closed, calls.opened)) as avg_days
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        WHERE calls.helpdesk = :helpdesk
                        GROUP BY calls.helpdesk");
      $database->bind(':helpdesk', $helpdesk);
      $results = $database->single();
      if ($database->rowCount() === 0) { return 0; }
      return $results;
    }

    public function avgUrgency($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;
      $database = new Database();
      $database->query("SELECT avg(calls.urgency) as avgUrgency
                        FROM calls
                        WHERE calls.status = 2
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY calls.urgency
                        ");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $results = $database->single();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function countOutstandingTicketsByHelpdesk($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT count(calls.callid) as outstanding
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        WHERE calls.status != 2
                        AND calls.helpdesk = :scope
                        GROUP BY calls.helpdesk");
      $database->bind(':scope', $helpdesks);
      $results = $database->single();
      if ($database->rowCount() === 0) { return 0; }
      return $results;
    }

    public function countClosed($scope = null) {

      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;
      $database = new Database();
      $database->query("SELECT count(calls.callid) as countClosed
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        WHERE calls.status = 2
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        ");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $results = $database->single();
      if ($database->rowCount() === 0) { return 0; }
      return $results;
    }

    public function countActivity($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;
      $database = new Database();
      $database->query("SELECT
                        sum(case when hour(calls.closed) < 7 || hour(calls.lastupdate) < 7 THEN 1 ELSE 0 END) AS '0-7',
                        sum(case when hour(calls.closed) = 7 || hour(calls.lastupdate) = 7 THEN 1 ELSE 0 END) AS '7-8',
                        sum(case when hour(calls.closed) = 8 || hour(calls.lastupdate) = 8 THEN 1 ELSE 0 END) AS '8-9',
                        sum(case when hour(calls.closed) = 9 || hour(calls.lastupdate) = 9 THEN 1 ELSE 0 END) AS '9-10',
                        sum(case when hour(calls.closed) = 10 || hour(calls.lastupdate) = 10 THEN 1 ELSE 0 END) AS '10-11',
                        sum(case when hour(calls.closed) = 11 || hour(calls.lastupdate) = 11 THEN 1 ELSE 0 END) AS '11-12',
                        sum(case when hour(calls.closed) = 12 || hour(calls.lastupdate) = 12 THEN 1 ELSE 0 END) AS '12-13',
                        sum(case when hour(calls.closed) = 13 || hour(calls.lastupdate) = 13 THEN 1 ELSE 0 END) AS '13-14',
                        sum(case when hour(calls.closed) = 14 || hour(calls.lastupdate) = 14 THEN 1 ELSE 0 END) AS '14-15',
                        sum(case when hour(calls.closed) = 15 || hour(calls.lastupdate) = 15 THEN 1 ELSE 0 END) AS '15-16',
                        sum(case when hour(calls.closed) = 16 || hour(calls.lastupdate) = 16 THEN 1 ELSE 0 END) AS '16-17',
                        sum(case when hour(calls.closed) = 17 || hour(calls.lastupdate) = 17 THEN 1 ELSE 0 END) AS '17-18',
                        sum(case when hour(calls.closed) = 18 || hour(calls.lastupdate) = 18 THEN 1 ELSE 0 END) AS '18-19',
                        sum(case when hour(calls.closed) > 19 || hour(calls.lastupdate) > 19 THEN 1 ELSE 0 END) AS '19-24'
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        WHERE FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY calls.helpdesk
                      ");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $results = $database->single();
      if ($database->rowCount() === 0) { return 0; }
      return $results;
    }

    public function processSchedule() {
      $database = new Database();
      $database->query("SELECT *
                        FROM calls
                        WHERE calls.status = 6");
      $result = $database->resultset();
        foreach ($result as &$value) {
          if (strtotime($value["opened"]) < time()) {
            // schedule due change ticket status
            $this->updateTicketStatusById($value["callid"], 1);
            echo "Scheduled change status \"#".$value["callid"]."\"";
          }
        }
      return true;
    }

}
