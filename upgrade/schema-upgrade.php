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
        <th>DB Row</th>
        <th>Call ID</th>
        <th>Update</th>
        <th>Calculated Timestamp</th>
      </tr>
    </thead>
    <tbody>
<?php
  // up memory size to process request
  ini_set('memory_limit', '1024M');
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

  $counter = 0;
  // get all tickets to process
  $ticketDetails = $ticketModel->getAllTicketsNoLimit();
  // get 10 tickets used when testing instead of getting 20,000 records
  // $ticketDetails = $ticketModel->getAllTickets(100);
  // loop all tickets
  foreach ($ticketDetails as $key => $value) {

    // parse each ticket pulling out details
        $doc = new DOMDocument();
        $doc->loadHTML($value["details"]);
        $items = $doc->documentElement->getElementsByTagName('div');
            foreach ($items as $tag1)
            {
              $counter++;
              echo "<tr>";
              echo "<td>".$counter."</td>";
              echo "<td>" . $value["callid"] . "</td>";
              echo "<td>" . getNodeInnerHTML($tag1) . "</td>";

              echo "<td>";
              // need to parse date and time from $tag1 else output $value[opened]
              if (DateTime::createFromFormat('d/m/Y H:i', substr($tag1->nodeValue, -16)) !== FALSE) {
                // it's a date
                $calcDT = DateTime::createFromFormat('d/m/Y H:i', substr($tag1->nodeValue, -16));
                //echo substr($tag1->nodeValue, -16);
                echo "<span style=\"color: orange\">" . $calcDT->format("Y-m-d H:i:s") . "</span>";
              } else {
                echo $value["opened"];
              }


               echo "</td>";



              echo "</tr>";
            }

  }

 ?>

  </tbody>
</table>
</div>
</body>
</html>
