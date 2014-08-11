<?php 
if ($_POST['id'] === "1") { echo "<h2>All Calls</h2>"; include('managerreport1.php');};
if ($_POST['id'] === "2") { echo "<h2>Oldest Calls</h2>"; include('managerreport2.php');};
if ($_POST['id'] === "3") { echo "<h2>Engineer Workload</h2>"; include('managerreport3.php');};
if ($_POST['id'] === "4") { echo "<h2>Workrate</h2>"; include('managerreport4.php');};
if ($_POST['id'] === "5") { echo "<h2>User Feedback</h2>"; include('managerreport5.php');};
if ($_POST['id'] === "6") { echo "<h2>Punchcard In/Out</h2>"; include('managerreport6.php');};
if ($_POST['id'] === "7") { echo "<h2>Emerging issues</h2>"; include('managerreport7.php');};
?>