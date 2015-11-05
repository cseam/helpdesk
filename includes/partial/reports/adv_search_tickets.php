<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h1>Search Tickets</h1>
<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="search" class="searchform">
<div id="resultspost" style="clear: both;"></div>
<fieldset>
		<legend>Search all tickets</legend>
		<label for="term">Search Query</label>
		<input type="text" id="term" name="term" value="" />
		<br/>
</fieldset>
<fieldset>
		<legend>Advanced Filters</legend>
		<label for="ticketid">Ticket ID (optional)</label>
		<input type="text" id="ticketid" name="ticketid" value="" />
		<label for="location">Location (optional)</label>
		<select id="location" name="location">
		<?php
				$STH = $DBH->Prepare('SELECT DISTINCT room FROM calls ORDER BY room');
				$STH->setFetchMode(PDO::FETCH_OBJ);
				$STH->execute();
				while($row = $STH->fetch()) { ?>
			<option value="<?php echo($row->room); ?>"><?php echo($row->room); ?></option>
				<?php }; ?>
		</select>


		<label for="engineer">Engineer Assigned (optional)</label>
		<select id="engineer" name="engineer">
			<option value="" SELECTED>Please Select</option>
				<?php
						$STHloop = $DBH->Prepare("SELECT * FROM engineers ORDER BY engineerName");
						$STHloop->setFetchMode(PDO::FETCH_OBJ);
						$STHloop->execute();
						while($row = $STHloop->fetch()) { ?>
			<option value="<?php echo($row->idengineers);?>"><?php echo($row->engineerName);?></option>
					<?php }; ?>
		</select>
		<label for="user">Username (optional)</label>
		<input type="text" id="user" name="user" value="" />

		<label for="helpdesk">Helpdesk (optional)</label>
		<select id="helpdesk" name="helpdesk">
			<option value="" SELECTED>Please Select</option>
				<?php
				$STH = $DBH->Prepare('SELECT * FROM helpdesks');
				$STH->setFetchMode(PDO::FETCH_OBJ);
				$STH->execute();
				while($row = $STH->fetch()) { ?>
			<option value="<?php echo($row->id); ?>"><?php echo($row->helpdesk_name); ?></option>
				<?php }; ?>
		</select>
		<label for="status">Ticket Status (optional)</label>
		<select id="status" name="status">
			<option value="" SELECTED>All Codes</option>
				<?php
				$STH = $DBH->Prepare('SELECT * FROM status');
				$STH->setFetchMode(PDO::FETCH_OBJ);
				$STH->execute();
				while($row = $STH->fetch()) { ?>
			<option value="<?php echo($row->id); ?>"><?php echo($row->statusCode); ?></option>
				<?php }; ?>
		</select>

</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Search</button>
</p>
</form>

<script type="text/javascript">
    $('.searchform').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: 'includes/partial/post/adv_search_tickets.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/public/images/ICONS-spinny.gif" alt="loading" class="loading"/>');
    			},
				success: function(data)
				{
				$('#ajax').html(data);
    			},
				error: function()
				{
				$('#ajax').html('error loading data, please refresh.');
    			}
			});
       e.preventDefault();
       return false;
    });
</script>
