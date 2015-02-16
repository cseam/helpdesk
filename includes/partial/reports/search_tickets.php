<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Search Tickets</h3>
<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="search" class="searchform">
<fieldset>
		<legend>Search all tickets</legend>
		<label for="term">Search Query</label>
		<input type="text" id="term" name="term" value=""  required />
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Go</button>
</p>
</form>

<div id="resultspost" style="clear: both;">
</div>

<script type="text/javascript">
    $('.searchform').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: 'includes/partial/post/search_tickets.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#resultspost').html('<img src="/public/images/ICONS-spinny.gif" alt="loading" class="loading"/>');
    			},
				success: function(data)
				{
				$('#resultspost').html(data);
    			},
				error: function()
				{
				$('#resultspost').html('error loading data, please refresh.');
    			}
			});
       e.preventDefault();
       return false;
    });
</script>
<script src="/public/javascript/jquery.validate.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$("#search").validate({
			rules: {}
		});
</script>
