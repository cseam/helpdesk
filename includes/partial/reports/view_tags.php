<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Tag Control</h2>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['tagname'] == TRUE) { ?>
 <?php
$sqlquery = $db->query("INSERT INTO changecontrol_tags (tagname) VALUES ('".$_POST['tagname']."');");
	if($sqlquery)
		{
			echo "<p>Your new tag has been added</p>";
		}
?>
<? } ?>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['delthis'] == TRUE) { ?>
<?php
$sqlquery = $db->query("DELETE FROM changecontrol_tags WHERE id=".$_POST['delthis'].";");
	if($sqlquery)
		{
			echo "<p>Selected tag deleted</p>";
		}
?>
<? } ?>
<fieldset>
	<legend>Remove current tag</legend>
<p class="tags  delete">
		<?
			$tags = mysqli_query($db, "SELECT * FROM changecontrol_tags;");
				while($buttons = mysqli_fetch_array($tags)) { ?>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" class="deltag">
					<input type="hidden" id="delthis" name="delthis" value="<?=$buttons['id'];?>" />
					<button name="tag" value="<?=$buttons['tagname'];?>" type="submit"><?=$buttons['tagname'];?></button>
				</form>
		<? } ?>
</p>
</fieldset>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" id="addtag">
<fieldset>
<legend>Add New Tag</legend>
<label for="">Tag name</label>
		<input type="text" id="tagname" name="tagname" value=""  required />
	<p class="buttons">
		<button name="add" value="add" type="submit">Submit</button>
	</p>
</fieldset>
</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
	<script src="javascript/jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
    $('#addtag, .deltag').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/managerreport-tags.php',
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
				$('#ajax').html('error loading data, please refresh.');
    			}
			});
       e.preventDefault();
       return false;
    });
  	</script>

