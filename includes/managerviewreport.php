<?php 
if ($_POST['report'] == "0") { include('managerreport-default.php');};
if ($_POST['report'] == "1") { echo "<h2>All Calls</h2>"; include('managerreport-allcalls.php');};
if ($_POST['report'] == "2") { echo "<h2>Oldest Call</h2>"; include('managerreport-oldestcalls.php');};
if ($_POST['report'] == "3") { echo "<h2>Assigned Not Closed</h2>"; include('managerreport-assigned.php');};
if ($_POST['report'] == "4") { echo "<h2>Workrate</h2>"; include('managerreport-workrate.php');};
if ($_POST['report'] == "5") { echo "<h2>User Feedback</h2>"; include('managerreport-feedback.php');};
if ($_POST['report'] == "6") { echo "<h2>Punchcard In/Out</h2>"; include('managerreport-punchcard.php');};
if ($_POST['report'] == "7") { echo "<h2>Emerging issues</h2>"; include('managerreport-issues.php');};
if ($_POST['report'] == "8") { echo "<h2>Search Calls</h2>"; include('managerreport-search.php');};
if ($_POST['report'] == "9") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
if ($_POST['report'] == "10") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
if ($_POST['report'] == "11") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
if ($_POST['report'] == "12") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
if ($_POST['report'] == "13") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
if ($_POST['report'] == "14") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
if ($_POST['report'] == "15") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
if ($_POST['report'] == "16") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
if ($_POST['report'] == "17") { echo "<h2>Empty</h2>"; include('managerreport-blank.php');};
?>