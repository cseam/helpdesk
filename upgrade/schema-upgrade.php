<!DOCTYPE html>
<html lang="en">
<head>
<title>SETUP</title>
<link rel="stylesheet" type="text/css" href="/public/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/public/css/style.css" />
</head>
<body>
<div class="section" style="overflow: auto;">
  <h2>Split Call Details Out, Upgrade Database Existing Records</h2>
  <p>
    Used to upgrade ticket details from single record to split ones
  </p>
  <p>
    listed are all updates for all tickets split out
  </p>
<style>
  table
  {
      table-layout: fixed;
      width: 100%;
  }
  ::-webkit-scrollbar {
  	width: 25px;
  }
</style>
  <table>
    <thead>
      <tr>
        <th>Call ID</th>
        <th>Update Details</th>
        <th>Action Taken</th>
      </tr>
    </thead>
    <tbody>
<?php
  // up memory size to process request
  ini_set('memory_limit', '1024M');
  ini_set('max_execution_time', 300);
  //hard code fudge as not using framework for this but this page will be destroyed once upgrade is done
  require_once "../config/config.php";
  require_once "../models/ticketModel.php";
  require_once "../models/Database.php";
  $ticketModel = new ticketModel();

  function getNodeInnerHTML(DOMNode $oNode)
  {
      $oDom = new DOMDocument();
      $oDom->appendChild($oDom->importNode($oNode, true));
      return $oDom->saveHTML();
  }

  function getElementsByClass(&$parentNode, $className) {
      $nodes=array();
      $childNodeList = $parentNode;
      for ($i = 0; $i < $childNodeList->length; $i++) {
          $temp = $childNodeList->item($i);
          if (stripos($temp->getAttribute('class'), $className) !== false) {
              $nodes[]=$temp;
          }
      }
      return $nodes;
  }
  // create new db tables to store results
  try {
    // Connect to dev db
    $conn = new PDO("mysql:host=".DB_LOC.";dbname=".DB_SCHEMA, DB_USER, DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $queryCreateUpdatesTable = "CREATE TABLE IF NOT EXISTS `call_updates` (
        `ID` int(11) unsigned NOT NULL auto_increment,
        `callid` int(11) DEFAULT NULL,
        `stamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `details` longtext,
        `sAMAccountName` varchar(45) DEFAULT NULL,
        `status` int(11) DEFAULT '1',
        PRIMARY KEY  (`ID`)
      )";
    $conn->exec($queryCreateUpdatesTable);
    }
  catch(PDOException $e)
    {
    echo "<p class='urgent'>ERROR: " . $e->getMessage() ."</p>";
    }

  // get all tickets to process
  $ticketDetails = $ticketModel->getAllTicketsNoLimit();
  // get 1000 tickets used when testing instead of getting 20,000 records
  //$ticketDetails = $ticketModel->getAllTickets(10);

  // Parse 1, loop all tickets, export all ticket updates to new table
  foreach ($ticketDetails as $key => $value) {
    // parse each ticket pulling out details
        $doc = new DOMDocument();
        $doc->loadHTML($value["details"]);
        $items = $doc->documentElement->getElementsByTagName('div');
        $classValue=getElementsByClass($items, 'original');//will contain the three nodes under "content_node"
        $original = getNodeInnerHTML($classValue[0]);

            foreach ($items as $tag1)
            {
            echo "<tr>";
              echo "<td>" . $value["callid"] . "</td>";
              echo "<td>" . getNodeInnerHTML($tag1) . "</td>";
              echo "<td>";
              // pull out date/time update from ticket
              preg_match('/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/', $tag1->nodeValue, $timestamp );
              if (sizeof($timestamp) > 0) {
                // this record should be inserted into a new table as its a ticket update
                // create mysql date time stamp
                $stamp = DateTime::createFromFormat('d/m/Y H:i', $timestamp[0]);
                // parse sAMAccountName and status type
                preg_match('/(\w*) (\w*) (\w*),{0,1}\s{0,1}-{0,1}\s{0,1}(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/', $tag1->nodeValue, $updatetoken );
                // fudge as no space to split on
                $switchval = substr($updatetoken[1] , -4);
                SWITCH ($switchval) {
                  CASE "osed":
                    $status = 2;
                  break;
                  CASE "open":
                    $status = 1;
                  break;
                  CASE "hold":
                    $status = 3;
                  break;
                  CASE "ated":
                    $status = 4;
                  break;
                  CASE "away":
                    $status = 5;
                  break;
                  CASE "date":
                    $status = 1;
                  break;
                  default:
                    $status = 1;
                  break;
                }
                // set sAMAccountName
                if (isset($updatetoken[3])) {
                  $sam = $updatetoken[3];
                } else {
                  // need to do additional checking for reassigned tickets eg "Ticket reassigned by danielsd2 (07/01/2016 09:37:33)"
                  preg_match('/(\w*)\s{1}[(](\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/', $tag1->nodeValue, $reassigned);
                  $sam = $reassigned[1];
                }
                // execute query
                $database = new Database();
                $database->query("INSERT INTO call_updates (callid, stamp, details, sAMAccountName, status)
                                  VALUES (:callid, :stamp, :detail, :sAMA, :status)
                                ");
                $database->bind(":callid", $value["callid"]);
                $database->bind(":stamp", $stamp->format("Y-m-d H:i:s"));
                $database->bind(":detail", getNodeInnerHTML($tag1));
                $database->bind(":sAMA", $sam);
                $database->bind(":status", $status);
                $database->execute();
                echo "Inserted Into Call_Updates";
              }

              echo "</td>";
            echo "</tr>";
            }
        // Parse 2, Remove ticket updates from call details leaving only original comment
        $database = new Database();
        $database->query("UPDATE calls
                          SET calls.details = :original
                          WHERE calls.callid = :callid");
        $database->bind(":original", $original);
        $database->bind(":callid", $value["callid"]);
        $database->execute();
  }

// Finaly rename callreasons table as inconsistantly named
$database = new Database();
$database->query("RENAME TABLE callreasons TO call_reasons;");
$database->execute();

//tidy up 
$conn = null;
?>
  </tbody>
</table>
</div>
</body>
</html>
