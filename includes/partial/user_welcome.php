<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Information</h3>
<p>Welcome to <?php echo(CODENAME);?>. Please use the form to log tickets for engineers. Once your ticket is logged you will receive email feedback on your issue.</p><p>Return here any time to see the status of your ticket, clicking the ticket title under 'Your Tickets' to view updates.</p>
<p class="note">Remember, the more information you provide, the quicker the engineer can fix your problem. For example, if your printer is out of ink, please include the location of the printer, the printer model, the colour of the ink cartridge, etc.</p>