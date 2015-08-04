<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Add Change Control</h2>
<?php
if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['addchange'] == "add") {
	//  add change control
	$uniquetagcsv = implode(',',array_unique(explode(',', $_POST['tagname'])));
	$STH = $DBH->Prepare('INSERT INTO changecontrol (engineersid, stamp, changemade, tags, server, helpdesk) VALUES (:engineersid, :stamp, :changemade, :tags, :server, :helpdesk)');
	$STH->bindParam(':engineersid', $_POST['engineer'], PDO::PARAM_STR);
	$STH->bindParam(':stamp', date("c"), PDO::PARAM_STR);
	$STH->bindParam(':changemade', $_POST['details'], PDO::PARAM_STR);
	$STH->bindParam(':tags', $uniquetagcsv, PDO::PARAM_STR);
	$STH->bindParam(':server', $_POST['servername'], PDO::PARAM_STR);
	$STH->bindParam(':helpdesk', $_SESSION['engineerHelpdesk'], PDO::PARAM_INT);
	$STH->execute();
	// list engineers in same helpdesk
	
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT * FROM engineers WHERE helpdesk <= :helpdeskid");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT * FROM engineers WHERE helpdesk = :helpdeskid");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) { 
		// email all engineers to let them know details of change control	
			// Construct message
			$to = $row->engineerEmail;
			$message = "<span style='font-family: arial;'><p>Change control has been added</p>";
			$message .= "<p><b>" . $_POST['servername'] . "</b></p>";
			$message .= "<p>" . engineer_friendlyname($_POST['engineer']) . "</p>";
			$message .= "<p>" . date("l jS \of F Y h:i:s A") . "</p>";
			$message .= "<p>" . $_POST['details'] . "</p>";
			$message .= "<p>To view the details of this change please <a href='". HELPDESK_LOC ."'>Visit ". CODENAME ."</a></p>";
			$message .= "<p>This is an automated message please <b>do not reply</b></p>";
			$msgtitle = "Change Control Added (" . $_POST['servername'] . ")";
			$headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion();
			// In case any of our lines are larger than 70 characters, we wordwrap()
			$message = wordwrap($message, 70, "\r\n");
			// Send email
			mail($to, $msgtitle, $message, $headers);
	};
	// update view 
	echo("<p>Your change control has been added</p>");
};
?>
<p>Please log all changes to servers, and tag appropriately.</p>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" id="changecontrol">
<fieldset>
	<legend>add change control</legend>
	<label for="">Engineer</label>
		<select id="engineer" name="engineer" required>
				<?php
						if ($_SESSION['engineerHelpdesk'] <= '3') {
							$STH = $DBH->Prepare("SELECT * FROM engineers WHERE helpdesk <= :helpdeskid ORDER BY engineerName");
							$hdid = 3;
						} else {
							$STH = $DBH->Prepare("SELECT * FROM engineers WHERE helpdesk = :helpdeskid ORDER BY engineerName");
							$hdid = $_SESSION['engineerHelpdesk'];
						}
						$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
						$STH->setFetchMode(PDO::FETCH_OBJ);
						$STH->execute();
						while($row = $STH->fetch()) { ?>
						<option value="<?php echo($row->idengineers);?>"><?php echo($row->engineerName);?></option>
				<?php }; ?>
		</select>
	<label for="">Server</label>
		<input type="text" id="servername" name="servername" />
	<label for="">Change</label>
		<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
	<label for="">Tags</label>
		<textarea id="tagname" name="tagname" rows="2" cols="40" value="" readonly="true" required ></textarea>
		<input type="hidden" id="helpdesk" name="helpdesk" value="<?php echo($hdid); ?>" />
	<p class="buttons">
		<input type="hidden" id="addchange" name="addchange" value="add" />
		<button name="add" value="add" type="submit">Submit</button>
	</p>
</fieldset>
</form>
<fieldset>
	<legend>Please select your tags</legend>
<p class="tags">
		<?php
			
			if ($_SESSION['engineerHelpdesk'] <= '3') {
				$STH = $DBH->Prepare("SELECT * FROM changecontrol_tags WHERE helpdesk <= :helpdeskid");
				$hdid = 3;
			} else {
				$STH = $DBH->Prepare("SELECT * FROM changecontrol_tags WHERE helpdesk = :helpdeskid");
				$hdid = $_SESSION['engineerHelpdesk'];
			}
			$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
			$STH->setFetchMode(PDO::FETCH_OBJ);
			$STH->execute();
			while($row = $STH->fetch()) { ?>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" class="addtagform">
				<input type="hidden" class="addtagid" name="addtagid" value="<?=$row->id;?>" />
				<input type="hidden" class="addtagname" name="addtagname" value="<?=$row->tagname;?>" />
				<button name="tag" value="addtag" type="submit"><?=$row->tagname;?></button>
				</form>
		<?php }; ?>
</p>
</fieldset>
<script type="text/javascript">
    $('#changecontrol').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/partial/reports/add_change_control.php',
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
				$('#ajax').html('error :' + error() );
    			}
			});
       e.preventDefault();
       return false;
    });
    $('.addtagform').submit(function(e) {
	    var formresults = $( this ).serializeArray();
	    var currenttagvalues = $("#tagname").val();
		$.each( formresults, function( i, field ) {
			$( "#tagname" ).val( field.value + "," + currenttagvalues );
    		});
       e.preventDefault();
       return false;
    });
</script>