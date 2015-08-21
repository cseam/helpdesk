<?php
	// start sessions
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// Process post
	if ($_SERVER['REQUEST_METHOD']== "POST") {
		
		// if assign ticket
		if (isset($_POST['assign'])) {
			//fudge for assign ticket should rewrite this its messy
		?>	
		<script type="text/javascript">
		$(function() {
			$.ajax(
			{
				type: 'post',
				url: '/includes/partial/post/reassign_ticket.php',
				data: "id=<?php echo($_POST['id']) ;?>",
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
			return false;
		});
		</script>
		<?php	
		}
	
		// if Forward ticket
		if (isset($_POST['forward'])) {
			//Create update message for db
			$reason = "<div class=update><h3>Ticket forwarded (".date("l jS \of F Y H:i:s A").")</h3>". htmlspecialchars($_POST['details'])."</div>";
			//PDO Update ticket
			$STH = $DBH->Prepare("UPDATE calls SET helpdesk = :helpdesk, assigned = :assigned, lastupdate = :lastupdate, details = CONCAT(details, :details) WHERE callid = :callid");
			$STH->bindParam(':helpdesk', $_POST['fwdhelpdesk'], PDO::PARAM_STR);
			$STH->bindParam(':assigned', next_engineer($_POST['fwdhelpdesk']), PDO::PARAM_STR);
			$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
			$STH->bindParam(':details', $reason, PDO::PARAM_STR);
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_STR);
			$STH->execute();

			//PDO Update engineers assignment
			$STH = $DBH->Prepare("UPDATE assign_engineers SET engineerId = :engineerid WHERE id = :id");
			$STH->bindParam(':engineerid', next_engineer($_POST['fwdhelpdesk']), PDO::PARAM_STR);
			$STH->bindParam(':id', $_POST['fwdhelpdesk'], PDO::PARAM_STR);
			$STH->execute();

			// Update view
			echo("<h2>Ticket Forwarded</h2>".$reason);
		}

		// if Reassign ticket
		if (isset($_POST['reassign'])) {
			//Create update message for db
			$reason = "<div class=update><h3>Ticket reassigned (".date("l jS \of F Y H:i:s A").")</h3>".htmlspecialchars($_POST['details'])."</div>";
			//PDO update ticket
			$STH = $DBH->Prepare("UPDATE calls SET assigned = :assigned, status = 1, lastupdate = :lastupdate, details = CONCAT(details, :details) WHERE callid = :callid");
			$STH->bindParam(':assigned', $_POST['engineer'], PDO::PARAM_STR);
			$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
			$STH->bindParam(':details', $reason, PDO::PARAM_STR);
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_STR);
			$STH->execute();

			// Update view
			echo("<h2>Ticket Reassigned</h2>".$reason);
		}

		// if Close ticket
		if (isset($_POST['close'])) {

			// Check for image attachments (need to check mime type also)
			if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
				// rename file to random name to avoid file name clash
				$name_of_uploaded_file = substr(md5(microtime()),rand(0,26),10);
				// define uploads folder from config
				$folder = ROOT . UPLOAD_LOC . $name_of_uploaded_file;
				// define temp upload location
				$tmp_path = $_FILES["attachment"]["tmp_name"];
				// move file from temp location to uploads folder
				move_uploaded_file($tmp_path, $folder);
				// create html img tag for ticket detail
				$upload_img_code = "<img src=" . UPLOAD_LOC . $name_of_uploaded_file . " alt=upload width=100% />";
			}

			//Create update message for db
			$reason = "<div class=update>"  . $upload_img_code . htmlspecialchars($_POST['updatedetails']) . "<h3>Closed By ".$_SESSION['sAMAccountName'].", " . date("d/m/y H:i:s") . "</h3></div>'";
			// PDO update ticket
			$STH = $DBH->Prepare("UPDATE calls SET closed = :closed, status = 2, callreason = :callreason, lastupdate = :lastupdate, closeengineerid = :closeengineerid, details = CONCAT(details, :details) WHERE callid = :callid");
			$STH->bindParam(':closed', date("c"), PDO::PARAM_STR);
			$STH->bindParam(':callreason', $_POST['callreason'], PDO::PARAM_STR);
			$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
			$STH->bindParam(':closeengineerid', $_SESSION['engineerId'], PDO::PARAM_STR);
			$STH->bindParam(':details', $reason, PDO::PARAM_STR);
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_STR);
			$STH->execute();

			// Email stakeholder
			// Get email from ticket details
			$STH = $DBH->Prepare('SELECT email FROM calls WHERE callid = :callid');
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_INT);
			$STH->setFetchMode(PDO::FETCH_OBJ);
			$STH->execute();
			$row = $STH->fetch();
			// Construct message
			$to = $row->email;
			$message = "<span style='font-family: arial;'><p>Your Helpdesk ticket (#" . $_POST['id'] .") has been closed.</p>";
			$message .= "<p>To view the details of this ticket please <a href='". HELPDESK_LOC ."'>Visit ". CODENAME ."</a></p>";
			$message .= "<p>This is an automated message please do not reply</p>";
			$message .= "<p>You can provide confidential feedback to the engineers line manager, let us know how well your ticket was dealt with <a href='". HELPDESK_LOC ."/views/feedback.php?id=" . $_POST['id'] ."'>Provide Feedback</a></p></span>";
			$msgtitle = "Your Helpdesk ticket (#" . $_POST['id'] . ") has been closed.";
			$headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion();
			// In case any of our lines are larger than 70 characters, we wordwrap()
			$message = wordwrap($message, 70, "\r\n");
			// Send email
			mail($to, $msgtitle, $message, $headers);

			// Update view
			echo("<h2>Updated & Closed</h2>");
			echo("<p>Ticket #" . $_POST['id'] . " has been updated and closed.</p>");
				SWITCH ($_SESSION['engineerLevel']) {
					CASE 2:
					echo("<script type='text/javascript'>update_div('#calllist','/reports/list_manager_reports.php');</script>");
					break;
					CASE 1:
					echo("<script type='text/javascript'>update_div('#calllist','/reports/list_engineers_tickets.php');</script>");
					echo("<script type='text/javascript'>update_div('#stats','reports/graph_my_performance.php');</script>");
					break;
					DEFAULT:
					echo("<script type='text/javascript'>update_div('#calllist','/reports/list_your_tickets.php');</script>");
					break;
				}
		}

		// if Hold ticket
		if (isset($_POST['hold'])) {
			// Create hold message for database
			$holdreason = "<div class=update>" . htmlspecialchars($_POST['updatedetails']) . "<h3> Call put on HOLD by " . $_SESSION['sAMAccountName'] . ", " . date("d/m/y H:i:s") . "</h3></div>";
			// PDO update ticket and set status to hold (3)
			$STH = $DBH->Prepare("UPDATE calls SET status = 3, lastupdate = :lastupdate, closed = NULL, details = CONCAT(details, :details) WHERE callid = :callid");
			$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
			$STH->bindParam(':details', $holdreason, PDO::PARAM_STR);
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_STR);
			$STH->execute();
			// Update view
			echo("<h2>Ticket put on Hold</h2>".$holdreason);
		}
		
		// if send away ticket
		if (isset($_POST['sendaway'])) {
			// Create hold message for database
			$holdreason = "<div class=update>" . htmlspecialchars($_POST['updatedetails']) . "<h3> Call SENT AWAY for repair " . $_SESSION['sAMAccountName'] . ", " . date("d/m/y H:i:s") . "</h3></div>";
			// PDO update ticket and set status to hold (3)
			$STH = $DBH->Prepare("UPDATE calls SET status = 5, lastupdate = :lastupdate, closed = NULL, details = CONCAT(details, :details) WHERE callid = :callid");
			$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
			$STH->bindParam(':details', $holdreason, PDO::PARAM_STR);
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_STR);
			$STH->execute();
			// Update view
			echo("<h2>Ticket SENT AWAY for repair</h2>".$holdreason);
		}
		
		// if escalate ticket
		if (isset($_POST['escalate'])) {
			// Create hold message for database
			$reason = "<div class=update>" . htmlspecialchars($_POST['updatedetails']) . "<h3> Escalated to Managment by " . $_SESSION['sAMAccountName'] . ", " . date("d/m/y H:i:s") . "</h3></div>";
			// PDO update ticket and set status to hold (3)
			$STH = $DBH->Prepare("UPDATE calls SET status = 4, lastupdate = :lastupdate, closed = NULL, details = CONCAT(details, :details) WHERE callid = :callid");
			$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
			$STH->bindParam(':details', $reason, PDO::PARAM_STR);
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_STR);
			$STH->execute();
			// Update view
			echo("<h2>Ticket escalated to your manager</h2><p>for the following reason<p>".$reason);
		}

		//if Update ticket
		if (isset($_POST['update'])) {
			// Check for image attachments (need to check mime type also)
			if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
				// rename file to random name to avoid file name clash
				$name_of_uploaded_file = substr(md5(microtime()),rand(0,26),10);
				// define uploads folder from config
				$folder = ROOT . UPLOAD_LOC . $name_of_uploaded_file;
				// define temp upload location
				$tmp_path = $_FILES["attachment"]["tmp_name"];
				// move file from temp location to uploads folder
				move_uploaded_file($tmp_path, $folder);
				// create html img tag for ticket detail
				$upload_img_code = "<img src=" . UPLOAD_LOC . $name_of_uploaded_file . " alt=upload width=100% />";
			}

			// Create update message for db
			$reason = "<div class=update>" . $upload_img_code . htmlspecialchars($_POST['updatedetails']) . "<h3> Update By ".$_SESSION['sAMAccountName'].", " . date("d/m/y H:i:s") . "</h3></div>";
			// PDO update ticket
			$STH = $DBH->Prepare("UPDATE calls SET status = 1, lastupdate = :lastupdate, closed = NULL, callreason = :callreason, details = CONCAT(details, :details) WHERE callid = :callid");
			$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
			$STH->bindParam(':callreason', $_POST['callreason'], PDO::PARAM_STR);
			$STH->bindParam(':details', $reason, PDO::PARAM_STR);
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_STR);
			$STH->execute();

			// Get email from ticket details
			$STH = $DBH->Prepare('SELECT email FROM calls WHERE callid = :callid');
			$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_INT);
			$STH->setFetchMode(PDO::FETCH_OBJ);
			$STH->execute();
			$row = $STH->fetch();
			// Construct message
			$to = $row->email;
			$message = "<span style='font-family: arial;'><p>Your Helpdesk ticket (#" . $_POST['id'] .") has been updated.</p>";
			$message .= "<p>An engineer updated your ticket with the following comment: <b>".$reason."</b></p>";
			$message .= "<p>To view the details of this update or update your ticket please <a href='". HELPDESK_LOC ."'>Visit ". CODENAME ."</a></p>";
			$message .= "<p>This is an automated message please <b>do not reply, login to update your ticket</b></p></span>";
			$msgtitle = "Your Helpdesk ticket (#" . $_POST['id'] . ") has been updated.";
			$headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'X-Mailer: PHP/' . phpversion();
			// In case any of our lines are larger than 70 characters, we wordwrap()
			$message = wordwrap($message, 70, "\r\n");
			// Send email
			mail($to, $msgtitle, $message, $headers);
			// update view
			echo("<h2>Ticket updated</h2><p>Ticket #" . $_POST['id'] . " has been updated, email sent to update users.</p>");
		}
	}