<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
?>
<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="search" class="searchform">
<p>Search all calls in database for following details</p>
	<fieldset>
		<legend>Search Term</legend>
		<label for="term">Look For</label>
		<input type="text" id="term" name="term" value=""  required />
	</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Search</button>
</p>
</form>

<div id="resultspost" style="clear: both;">
</div>

<script type="text/javascript">
    // Ajax form submit
    $('.searchform').submit(function(e) {
        // Post the form data to viewcall
        $.post('includes/searchpost.php', $(this).serialize(), function(resp) {
            // return response data into div
            $('#resultspost').html(resp);
        });
        // Cancel the actual form post so the page doesn't refresh
        e.preventDefault();
        return false;
    });     
</script>

<script src="javascript/jquery.validate.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$("#search").validate({
			rules: {
				}
		});
</script>
