<h3>Add Ticket</h3>
<form action="ticket/add" method="post" enctype="multipart/form-data" id="addForm">
	<fieldset>
		<legend>Contact details</legend>
			<label for="name" title="Contact name for this call">Your/Contact Name</label>
			<input type="text" id="name" name="name" value=""  required />
			<p class="note">Please enter your name, not a generic house name; then engineer can contact you directly if any problems arise.</p>
			<label for="email" title="Contact email so engineer can comunicate">Contact Email</label>
			<input type="text" id="email" name="email" value="<?php echo $_SESSION['sAMAccountName']."@". COMPANY_SUFFIX;?>"  required />
			<label for="tel" title="Contact telephone so engineer can comunicate">Telephone / Mobile Number</label>
			<input type="text" id="tel" name="tel" value="" />
	</fieldset>
</form>
