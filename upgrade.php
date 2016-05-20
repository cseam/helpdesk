<!DOCTYPE html>
<html lang="en">
<head>
<title>SETUP</title>
<link rel="stylesheet" type="text/css" href="/public/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/public/css/style.css" />
</head>
<body>
<div class="section" style="overflow: auto;">
  <h2>Upgrade Database Existing Records</h2>
  <p>
    Used to upgrade ticket details from single record to split ones
  </p>
  <p>
    listed are all updates for all tickets split out
  </p>


  <table>
    <thead>
      <tr>
        <th>Call ID</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody>
<?php
  //hard code fudge as not using framework for this but this page will be destroyed once upgrade is done
  require_once "config/config.php";
  require_once "models/ticketModel.php";
  require_once "models/Database.php";
  $ticketModel = new ticketModel();

  function getNodeInnerHTML(DOMNode $oNode)
  {
      $oDom = new DOMDocument();
      $oDom->appendChild($oDom->importNode($oNode, true));
      return $oDom->saveHTML();
  }


  // get all tickets to process
  //$ticketDetails = $ticketModel->getAllTicketsNoLimit();
  $ticketDetails = $ticketModel->getAllTickets(10000);
  // loop all tickets
  foreach ($ticketDetails as $key => $value) {

    // parse each ticket pulling out details
        $doc = new DOMDocument();
        $doc->loadHTML($value["details"]);
        $items = $doc->documentElement->getElementsByTagName('div');
            foreach ($items as $tag1)
            {
              echo "<tr>";
              echo "<td>" . $value["callid"] . "</td>";
              echo "<td>" . getNodeInnerHTML($tag1) . "</td>";
              echo "</tr>";
            }

  }

 ?>

  </tbody>
</table>


</div>
</body>
</html>
