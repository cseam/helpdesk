<div id="sidr">
<h3>Controls</h3>
<a href="/ticket/add/">Add Ticket</a> / <a href="/user/">My Tickets</a> / <a href="/user/profile/">My Profile</a><br/>
<?php if (isset($_SESSION['engineerLevel'])) { ?>
<?php if ($_SESSION['engineerLevel'] === "1") { ?><a href="/engineer/">Engineer View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="/manager/">Manager View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="/report/">Reports View</a><br/><?php }; ?>
<?php if ($_SESSION['superuser'] === "1") { ?><a href="/admin/">Admin View</a><br/><?php }; ?>
<a href="/logout/" class="logout">Log out</a><br/>
<br/>
<?php } ?>
</div>
<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state
			// Bind sidr to menu
			$('#mobile-menu').sidr({
				name: 'sidr',
				side: 'right'
			});
			$('.menubutton').sidr({
				name: 'sidr',
				side: 'right'
			})
		// End DOM ready check
	});
</script>
