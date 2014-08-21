<?php 
if ($_POST['id'] === "0") { include('managerreport-default.php');};
if ($_POST['id'] === "1") { echo "<h2>All Calls</h2>"; include('managerreport-allcalls.php');};
if ($_POST['id'] === "2") { echo "<h2>Oldest Call</h2>"; include('managerreport-oldestcalls.php');};
if ($_POST['id'] === "3") { echo "<h2>Blank Report</h2>"; include('managerreport-blank.php');};
if ($_POST['id'] === "4") { echo "<h2>Workrate</h2>"; include('managerreport-workrate.php');};
if ($_POST['id'] === "5") { echo "<h2>User Feedback</h2>"; include('managerreport-feedback.php');};
if ($_POST['id'] === "6") { echo "<h2>Punchcard In/Out</h2>"; include('managerreport-punchcard.php');};
if ($_POST['id'] === "7") { echo "<h2>Emerging issues</h2>"; include('managerreport-issues.php');};
?>