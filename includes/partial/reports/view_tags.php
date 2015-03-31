<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Tag Control</h2>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['tagname'] == TRUE) { ?>
<?php
	$STH = $DBH->Prepare("INSERT INTO changecontrol_tags (tagname) VALUES (:tagname)");
	$STH->bindParam(":tagname", $_POST['tagname'], PDO::PARAM_STR);
	$STH->execute();
	if($STH)
		{
			echo "<p>Your new tag has been added</p>";
		} ?>
<? } ?>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['delthis'] == TRUE) { ?>
<?php
	$STH = $DBH->Prepare("DELETE FROM changecontrol_tags WHERE id = :delthis");
	$STH->bindParam(":delthis", $_POST['delthis'], PDO::PARAM_INT);
	$STH->execute();
	if($STH)
		{
			echo "<p>Selected tag deleted</p>";
		} ?>
<? } ?>
<fieldset>
	<legend>Remove current tag</legend>
<p class="tags  delete">
		<?
			$STH = $DBH->Prepare("SELECT * FROM changecontrol_tags");
			$STH->setFetchMode(PDO::FETCH_OBJ);
			$STH->execute();
			while($row = $STH->fetch()) { ?>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" class="deltag">
					<input type="hidden" id="delthis" name="delthis" value="<?=$row->id ?>" />
					<button name="tag" value="<?=$row->tagname;?>" type="submit"><?=$row->tagname;?></button>
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

<script type="text/javascript">
    $('#addtag, .deltag').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/partial/reports/view_tags.php',
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

