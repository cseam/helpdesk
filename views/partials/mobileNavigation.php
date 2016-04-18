<div id="sidr">
<h3>Controls</h3>
<a href="/ticket/add/">Add Ticket</a> / <a href="/user/">My Tickets</a><br/>
<?php if ($_SESSION['engineerLevel'] === "1") { ?><a href="/engineer/">Engineer View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="/manager/">Manager View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="/report/">Reports View</a><br/><?php }; ?>
<?php if ($_SESSION['superuser'] === "1") { ?><a href="/admin/">Admin View</a><br/><?php }; ?>
<a href="/logout/" class="logout">Log out</a><br/>
<br/>
<?php if ($_SESSION['engineerLevel'] === "1") { ?>
<h3>My Tickets</h3>
	<a href="#calllist" onclick="$('#leftpage').animate({scrollTop: $('#calllist').offset().top-130}, 2000);" class="menubutton"><img src="/public/images/ICONS-yourcalls.svg" alt="your tickets" title="your tickets"  width="16" height="17" /> Assigned Tickets</a><br/>
	<a href="#deptlist" onclick="$('#leftpage').animate({scrollTop: $('#deptlist').offset().top-130}, 2000);" class="menubutton"><img src="/public/images/ICONS-allcalls.svg" alt="your tickets" title="your tickets"  width="16" height="17" /> Departments Tickets</a><br/>
	<a href="#objlist" onclick="$('#leftpage').animate({scrollTop: $('#objlist').offset().top-130}, 2000);" class="menubutton"><img src="/public/images/ICONS-allcalls.svg" alt="Performance Objectives" title="Performance Objectives"  width="16" height="17" />Performance Objectives</a><br/>
	<a href="#reportlinks" onclick="$('#leftpage').animate({scrollTop: $('#reportlinks').offset().top-130}, 2000);" class="menubutton"><img src="/public/images/ICONS-workrate.svg" alt="your tickets" title="your tickets"  width="16" height="17" /> Reports</a><br/>
<?php }; ?>
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
