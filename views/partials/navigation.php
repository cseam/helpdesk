<?php if (!empty($_SESSION['sAMAccountName'])) { ?>
<div id="non-mobile-menu">
<a href="/user/">Add Ticket</a> /
<?php if ($_SESSION['engineerLevel'] === "1" or $_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="/engineer/">Engineer View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="/manager/">Manager View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="/reports/">Reports View</a><br/><?php }; ?>
<?php if ($_SESSION['superuser'] === "1") { ?><a href="/admin/">Admin View</a><br/><?php }; ?>
<a href="/logout/" class="logout">Log out</a><br/>
</div>
<a href="#sidr" id="mobile-menu"><img src="/public/images/ICONS-hamburger.svg" width="24" height="auto" /></a>
<?php } ?>
