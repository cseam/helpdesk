<form action="#" method="post" enctype="multipart/form-data" id="schedule" class="scheduleform">
<fieldset>
		<legend>Schedule Ticket #<?php echo $pagedata->ticketid ?></legend>
		<p>This ticket will be scheduled for the time selected, the ticket will automatically reopen on the selected date, reports will then calculate from the reopened time.</p>
		<label for="date-range" title="select a date range">Schedule for</label>
		<link rel="stylesheet" href="/public/css/daterangepicker.min.css">
		<script type="text/javascript" src="/public/javascript/moment.js"></script>
		<script type="text/javascript" src="/public/javascript/jquery.daterangepicker.min.js"></script>
		<input id="date-for" name="date-for" size="60" value="" REQUIRED>
		<script type="text/javascript">
		$('#date-for').dateRangePicker({
			startOfWeek: 'monday',
			format: 'YYYY-MM-DD',
			autoClose: true,
			singleDate : true,
			singleMonth: true
		});
		</script>
		<p>
			The owner of the ticket will be notified why the ticket has been scheduled for a future time.
		</p>
		<label for="reason">Reason</label>
		<textarea name="reason" id="reason" rows="10" cols="40" REQUIRED></textarea>
</fieldset>
<p class="buttons">
	<button name="submit" value="submit" type="submit">Schedule</button>
</p>
</form>

<script type="text/javascript">
	$(function() {
		$("#schedule").validate({});
	});
</script>
