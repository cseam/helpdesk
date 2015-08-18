<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Add Performance Objective</h3>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" method="post" id="addForm">
<fieldset>
	<legend>Objective Details</legend>
		<label for="engineerid" title="Engineer">Engineer</label>
		<select id="engineerid" name="engineerid" required>
			<option value="" SELECTED>Please select</option>
			
				<?php
						if ($_SESSION['engineerHelpdesk'] <= '3') {
							$STHloop = $DBH->Prepare("SELECT * FROM engineers WHERE helpdesk <= :helpdeskid ORDER BY engineerName");
							$hdid = 3;
						} else {
							$STHloop = $DBH->Prepare("SELECT * FROM engineers WHERE helpdesk = :helpdeskid ORDER BY engineerName");
							$hdid = $_SESSION['engineerHelpdesk'];
						}
						$STHloop->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
						$STHloop->setFetchMode(PDO::FETCH_OBJ);
						$STHloop->execute();
						while($row = $STHloop->fetch()) { ?>
						<option value="<?php echo($row->idengineers);?>"><?php echo($row->engineerName);?></option>
				<?php }; ?>
			
			</select>

		<label for="title" title="title">Objective Title</label>
		<input type="text" id="title" name="title" value=""  required />

		<label for="datedue" title="date due (yyyy/mm/dd)">date due ISO format (yyyy/mm/dd)</label>
		<input type="date" id="datedue" name="datedue" value="<?php echo date("Y/m/d");?>"  required />

		<label for="details" title="objective details">Objective Details</label>
		<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit" title="Submit">Submit</button>
	<button name="clear" value="clear" type="reset" title="Clear">Clear</button>
</p>
</form>
<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state
		$("#addForm").validate({
			rules: {
				datedue: {
					dateISO: true,
					}
				},
			// Submit via ajax if valid
			submitHandler: function(form) {
				$.ajax(
					{
					type: 'post',
					url: '/includes/partial/post/pdo_add_objective.php',
					data: $("#addForm").serialize(),
					success: function(data)
					{
						$('#ajax').html(data);
						console.log ("pdo added objective");
					},
					error: function()
					{
						$('#ajax').html('error :' + error() );
						console.log ("add objective has failed");
					}
				});
			}
		});
	// End DOM Ready
	});
</script>