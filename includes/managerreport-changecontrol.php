<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['addchange'] == "add") { ?>
<h2>Add Change Control</h2>
<?
	$uniquetagcsv = implode(',',array_unique(explode(',', $_POST['tagname'])));
	//$uniquetagcsv = $_POST['tagname'];

	$sqlquery = $db->query("INSERT INTO changecontrol (engineersid, stamp, changemade, tags, server) VALUES (".$_POST['engineer'].",'".date("c")."','".$_POST['details']."','". $uniquetagcsv ."','". $_POST['servername'] ."')");
	if($sqlquery)
		{
			echo "<p>Your change control has been added</p>";
		}
?>
<?}?>
<p>Please log all changes to servers, and tag appropriately.</p>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" id="changecontrol">
<fieldset>
	<legend>add change control</legend>
	<label for="">Engineer</label>
		<select id="engineer" name="engineer" required>
				<?php
				if ($_SESSION['engineerHelpdesk'] <= '3') {
					$whereenginners = 'WHERE helpdesk <= 3';
				} else {
					$whereenginners = 'WHERE helpdesk='.$_SESSION['engineerHelpdesk'];
				};
				$helpdesks = mysqli_query($db, "SELECT * FROM engineers " .$whereenginners. " ORDER BY engineerName");
				while($option = mysqli_fetch_array($helpdesks)) { ?>
					<option value="<?=$option['idengineers'];?>"><?=$option['engineerName'];?></option>
				<? } ?>
		</select>
	<label for="">Server</label>
		<input type="text" id="servername" name="servername" />
	<label for="">Change</label>
		<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
	<label for="">Tags</label>
		<textarea id="tagname" name="tagname" rows="2" cols="40" value="" readonly="true" required ></textarea>
	<p class="buttons">
		<input type="hidden" id="addchange" name="addchange" value="add" />
		<button name="add" value="add" type="submit">Submit</button>
	</p>
</fieldset>
</form>
<fieldset>
	<legend>Please select your tags</legend>
<p class="tags">
		<?
			$tags = mysqli_query($db, "SELECT * FROM changecontrol_tags;");
				while($buttons = mysqli_fetch_array($tags)) { ?>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" class="addtagform">
					<input type="hidden" class="addtagid" name="addtagid" value="<?=$buttons['id'];?>" />
					<input type="hidden" class="addtagname" name="addtagname" value="<?=$buttons['tagname'];?>" />
					<button name="tag" value="addtag" type="submit"><?=$buttons['tagname'];?></button>
					</form>
		<? } ?>
</p>
</fieldset>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $('#changecontrol').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/managerreport-changecontrol.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/images/ICONS-spinny.gif" alt="loading" class="loading"/>');
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