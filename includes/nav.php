<a href="/add.php">Add Ticket</a><br/>
<?php if ($_SESSION['engineerLevel'] >= "1") { ?><a href="/engineerview.php">Engineer View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] >= "2" or $_SESSION['superuser'] === "1") { ?><a href="/managerview.php">Manager View</a><br/><?php }; ?>
<a href="/login/logout.php">Logout</a><br/>