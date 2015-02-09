<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
		<?php
		include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
		// check authentication
		if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); }; ?>
	<head>
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
	</head>
	<body>
	<div class="section">
		<div id="branding">
			<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'); ?>
		</div>
		<div id="leftpage">
			<div id="stats">
				<h3>Information</h3>
					<p>Welcome to <?php echo(CODENAME);?>, please use the form to log tickets for engineers, once your ticket is logged you will receive email feedback on your issue, you can also return here at any time to see the status of your ticket.</p>
					<p class="note">Remember the more information you provide the quicker the engineer can fix your problem. For example, your printer is out of ink please include, printer model, colour of ink cartridge, room the printer is in. etc.</p>
			</div>
			<div id="calllist">
				<h3>Your Tickets</h3>
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/yourcalls.php'); ?>
			</div>
		</div>
		<div id="rightpage">
			<div id="addcall">
				<div id="ajax">
				<?php if ($_SERVER['REQUEST_METHOD']== "POST") { ?>
				<h2>Thank you</h2>
				<p>Your ticket has been added and has been assigned to <?php if ($_POST['cmn-toggle-selfassign'] !== null) { echo engineer_friendlyname(check_input($_POST['cmn-toggle-selfassign'])); } else { echo engineer_friendlyname(next_engineer(check_input($_POST['helpdesk']))); }; ?>, the engineer will be in touch shortly if they require additional information, any correspondence will be emailed to the contact address you entered in the form.</p>
				<p>Please check your email for further details.</p>
				<ul>
					<li><a href="/">Home</a></li>
				</ul>
				<?php
					// Upload attachments
					if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
					$salt = "HD" . substr(md5(microtime()),rand(0,26),5);
					$name_of_uploaded_file = $salt . basename($_FILES['attachment']['name']);
					//move the temp. uploaded file to uploads folder and salt for duplicates
					$folder = "/var/www/html/helpdesk/uploads/" . $name_of_uploaded_file;
					$tmp_path = $_FILES["attachment"]["tmp_name"];
					move_uploaded_file($tmp_path, $folder);
					$upload_img_code = "<img src=/uploads/" . $name_of_uploaded_file . " width=100% />";
					}
					// Calculate Urgency
					$urgencystr = round( (check_input($_POST['callurgency']) + check_input($_POST['callseverity'])) / 2 );
					// Create Query
					$sqlstr = "INSERT INTO calls ";
					$sqlstr .= "(name, email, tel, details, assigned, opened, lastupdate, status, closed, closeengineerid, urgency, location, room, category, owner, helpdesk, title, lockerid) ";
					$sqlstr .= "VALUES (";
					$sqlstr .= " '" . check_input($_POST['name']) . "',";
					$sqlstr .= " '" . check_input($_POST['email']) . "',";
					$sqlstr .= " '" . check_input($_POST['tel']) . "',";
					$sqlstr .= " '<div class=original>" . $upload_img_code . check_input($_POST['details']) . "</div>',";
						if ($_POST['cmn-toggle-selfassign'] !== null) {
						$sqlstr .= " '" . check_input($_POST['cmn-toggle-selfassign']) . "',";
						} else {
						$sqlstr .= " '" . next_engineer(check_input($_POST['helpdesk'])) . "',";
						};
					$sqlstr .= " '" . date("c") . "',";
					$sqlstr .= " '" . date("c") . "',";
					 	if ($_POST['cmn-toggle-retro'] !== null) {
					 	$sqlstr .= " '2',";
					 	$sqlstr .= " '". date("c") ."',";
					 	$sqlstr .= " '". check_input($_POST['cmn-toggle-selfassign']) ."',";
						} else {
						$sqlstr .= " '1',";
						$sqlstr .= " null,";
						$sqlstr .= " null,";
						};
					$sqlstr .= " '" . $urgencystr . "',";
					$sqlstr .= " '" . check_input($_POST['location']) . "',";
					$sqlstr .= " '" . check_input($_POST['room']) . "',";
					$sqlstr .= " '" . check_input($_POST['category']) . "',";
					$sqlstr .= " '" . $_SESSION['sAMAccountName'] . "',";
					$sqlstr .= " '" . check_input($_POST['helpdesk']) . "',";
					$sqlstr .= " '" . check_input($_POST['title']) . "',";
						if ($_POST['category'] != '11' ) {
						$sqlstr .= " " . "null" . " ";
						} else {
						$lockerid = random_locker();
						$sqlstr .= " '". $lockerid ."' ";
						// Print locker number to screen
						echo("<fieldset><legend>Engineer Note</legend><p class='lockernotice'>store laptop in locker #". $lockerid ."</p></fieldset>");
						};
					$sqlstr .= ")";
					// Run Query
					mysqli_query($db, $sqlstr);
					// Create Addition Fields Query
					//Get call id
					$helpdeskcallid = mysqli_insert_id($db);
					// find out how many fields to insert
					$additionalfieldstoinsert = mysqli_query($db, "SELECT * FROM call_additional_fields WHERE typeid =".$_POST['category']." ;");
					//for each field insert its value
					while($loop = mysqli_fetch_array($additionalfieldstoinsert))  {
						$insertname = "label" . $loop['id'];
						$sqladditional = "INSERT INTO call_additional_results (callid, label, value) VALUES ";
						$sqladditional .= "('".$helpdeskcallid."','".$loop['label']."','".$_POST[$insertname]."')";
						mysqli_query($db, $sqladditional);
					};
					// Update engineers assignment (id hard coded for dev needs to be specific to department if they want round robin)
					mysqli_query($db, "UPDATE assign_engineers SET engineerId = '". next_engineer(check_input($_POST['helpdesk'])) ."' WHERE id='".$_POST['helpdesk']."'");
					// Close Connection
					mysqli_close($db);
	 } else {?>
		<h1>Add Ticket</h1>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="addForm">
		<fieldset>
			<legend>Your contact details</legend>
				<label for="name" title="Contact name for this call">Your Name</label>
				<input type="text" id="name" name="name" value="<?php echo $_SESSION['sAMAccountName'];?>"  required />
				<label for="email" title="Contact email so engineer can comunicate">Your Email</label>
				<input type="text" id="email" name="email" value="<?php echo $_SESSION['sAMAccountName']."@". COMPANY_SUFFIX;?>"  required />
				<label for="tel" title="Contact telephone so engineer can comunicate">Telephone/Mobile Number</label>
				<input type="text" id="tel" name="tel" value=""  required />
		</fieldset>
		<fieldset>
			<legend>Location of issue</legend>
				<label for="location" title="location on campus of issue">Location on campus</label>
				<select id="location" name="location">
					<option value="" SELECTED>Please Select</option>
					<?php
						$locations = mysqli_query($db, "SELECT * FROM location ORDER BY locationName;");
							while($option = mysqli_fetch_array($locations))  { ?>
								<option value="<?php echo $option['id'];?>"><?php echo $option['locationName'];?></option>
					<? }; ?>
				</select>
				<label for="room" title="Room where issue is">Room or Place</label>
				<input type="text" id="room" name="room" value="" />
		</fieldset>
		<fieldset>
			<legend>Scope of issue</legend>
				<label for="callurgency" title="how the issue effects me">Urgency</label>
				<select id="callurgency" name="callurgency">
					<option value="1">An alternative is available</option>
					<option value="2">This is affecting my work</option>
					<option value="3">I cannot work</option>
				</select>
				<label for="callseverity" title="how the issue effects me">Severity</label>
				<select id="callseverity" name="callseverity">
					<option value="1">This problem affects only me</option>
					<option value="2">This problem affects multiple people</option>
					<option value="3">This problem affects all of <?php echo(COMPANY_NAME);?> and boarding houses</option>
				</select>
		</fieldset>
		<fieldset>
			<legend>Department</legend>
				<label for="helpdesk" title="select the college department">Report to this department</label>
				<select id="helpdesk" name="helpdesk" required>
					<option value="" SELECTED>Please Select</option>
						<?php
						$helpdesks = mysqli_query($db, "SELECT * FROM helpdesks ORDER BY helpdesk_name");
							while($option = mysqli_fetch_array($helpdesks)) { ?>
								<option value="<?php echo $option['id'];?>"><?php echo $option['helpdesk_name'];?></option>
						<? } ?>
				</select>
				<script type="text/javascript">
				$("#helpdesk").change(function(e) {
				$.post('includes/helpdeskdescription.php?id=' + $("#helpdesk").val(), $(this).serialize(), function(resp) {
					$('#helpdesk_description').hide();
					$('#helpdesk_description').html(resp);
					$('#helpdesk_description').slideDown();
				});
				e.preventDefault();
				$('#category :not(.helpdesk-' + $("#helpdesk").val() +' )').remove();
				return false;
				});
				</script>
				<div id="helpdesk_description"></div>
		</fieldset>
		<fieldset>
			<legend>Details of problem</legend>
				<label for="category" title="what type of issue do you have?">Type of issue</label>
				<select id="category" name="category">
					<option value="" SELECTED>Please Select</option>
						<?php
							$categories = mysqli_query($db, "SELECT * FROM categories ORDER BY categoryName;");
								while($option = mysqli_fetch_array($categories))  { ?>
									<option value="<?php echo $option['id'];?>" class="helpdesk-<?php echo $option['helpdesk'];?>"><?php echo $option['categoryName'];?></option>
						<? }; ?>
				</select>
				<script type="text/javascript">
				$("#category").change(function(e) {
					$.post('includes/additionalfields.php?id=' + $("#category").val(), $(this).serialize(), function(resp) {
						$('#additional_fields').hide();
						$('#additional_fields').html(resp);
						$('#additional_fields').slideDown();
					});
					e.preventDefault();
					return false;
				});
				</script>
				<div id="additional_fields"></div>
				<label for="title" title="short one line title of your problem">Short description of issue (Title)</label>
				<input type="text" id="title" name="title" value="" required />
				<label for="details" title="enter the full details of your problem">Describe issue in details</label>
				<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
		</fieldset>
		<fieldset>
			<legend>Attachments (optional)</legend>
				<label for="attachment" title="add attachments if required">Picture or Screenshot</label>
				<input type="file" name="attachment" accept="image/*">
		</fieldset>
		<?php if ($_SESSION['engineerId'] !== null) {?>
		<fieldset>
			<legend>Engineer Controls</legend>
			<table>
				<tr>
					<td style="border-bottom: 0;">
						<label for="cmn-toggle-selfassign" title="assign call to myself" style="width: 200px; padding: 4px 0;">Assign ticket to myself</label>
						<input type="checkbox" name="cmn-toggle-selfassign" id="cmn-toggle-selfassign" value="<?php echo $_SESSION['engineerId'];?>" class="cmn-toggle cmn-toggle-round"><label for="cmn-toggle-selfassign"></label>
					</td>
					<td style="border-bottom: 0;">
						<label for="cmn-toggle-retro" title="open call closed work already complete" style="width: 200px; padding: 4px 0;">Instantly close ticket</label>
						<input type="checkbox" name="cmn-toggle-retro" id="cmn-toggle-retro" value="1" class="cmn-toggle cmn-toggle-round">
						<label for="cmn-toggle-retro"></label>
					</td>
				</tr>
			</table>
		</fieldset>
		<?php }; ?>
		<p class="buttons">
			<button name="submit" value="submit" type="submit" title="Submit">Submit</button>
			<button name="clear" value="clear" type="reset" title="Clear">Clear</button>
		</p>
		</form>
	<?php }; ?>
			</div>
		</div>
	</div>
</div>
	<script src="/javascript/jquery.validate.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$("#addForm").validate({
			rules: {
				email: {
					required: true,
					email: true
					},
				location: {
					required: true,
					},
				category: {
					required: true,
					}
				}
		});
	</script>
	</body>
</html>