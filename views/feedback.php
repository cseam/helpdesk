<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// check authentication
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	?>
	<head>
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
		<script src="/public/javascript/jquery.validate.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="section">
			<div id="branding">
				<img src="/public/images/svg/BRANDING-CLC_Logo_PANTONE.svg" style="width:auto;height:10vh;float:left;margin-left:1rem;" alt="clc logo" />
				<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'); ?>
			</div>
		<div id="leftpage">
			<div id="stats">
				<h3>Feedback</h3>
				<p>We always welcome your comments, your time is appreciated, what have we done well? or how can we improve? all your comments will be provided to the line manager.</p>
				<p>Comments aren't provided to the engineer directly and are confidential.</p>
			</div>
			<div id="calllist">
				<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/list_your_tickets.php'); ?>
			</div>
		</div>
		<div id="rightpage">
			<div id="addcall">
				<div id="ajax">
					<?php if ($_SERVER['REQUEST_METHOD']== "POST") { ?>
					<h2>Thank you</h2>
					<p>your comments have been passed to the engineers line manager Thank you for taking the time to provide feedback.</p>
					<ul>
						<li><a href="/">Home</a></li>
					</ul>
					<?php
					$STH = $DBH->Prepare("INSERT INTO feedback (callid, satisfaction, details, opened) VALUES (:id, :satisfaction, :details, :date)");
					$STH->bindParam(":id", $_POST['callid'], PDO::PARAM_INT);
					$STH->bindParam(":satisfaction", $_POST['satisfaction'], PDO::PARAM_STR);
					$STH->bindParam(":details", $_POST['details'], PDO::PARAM_STR);
					$STH->bindParam(":date", date("c"), PDO::PARAM_STR);
					$STH->execute();
					} else {?>
					<h1>Ticket Feedback</h1>
					<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="addForm">
						<fieldset>
						<legend>Satisfaction</legend>
						<p>Please leave feedback on how you feel your ticket was dealt with, Poor feedback may be followed up by the engineers line manager.</p>
						<table>
						<tr>
							<th>Feedback</th>
							<th>Select</th>
						</tr>
						<tr>
							<td>
								<label for="satisfaction1" style="display: inline-block;">
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
								</label>
							</td>
							<td>
								<input type="radio" id="satisfaction1" name="satisfaction" value="1">
							</td>
						</tr>

						<tr>
							<td>
								<label for="satisfaction1" style="display: inline-block;">
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
								</label>
							</td>
							<td>
								<input type="radio" id="satisfaction2" name="satisfaction" value="2">
							</td>
						</tr>

						<tr>
							<td>
								<label for="satisfaction1" style="display: inline-block;">
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
								</label>
							</td>
							<td>
								<input type="radio" id="satisfaction3" name="satisfaction" value="3">
							</td>
						</tr>

						<tr>
							<td>
								<label for="satisfaction1" style="display: inline-block;">
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
								</label>
							</td>
							<td>
								<input type="radio" id="satisfaction4" name="satisfaction" value="4">
							</td>
						</tr>

						<tr>
							<td>
								<label for="satisfaction1" style="display: inline-block;">
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
									<img src="/public/images/svg/ICONS-star.svg" alt="star" width="24" height="auto"/>
								</label>
							</td>
							<td>
								<input type="radio" id="satisfaction5" name="satisfaction" value="5">
							</td>
						</tr>
						</table>
						<p>Fewer star = Worse feedback / More stars = better feedback</p>
						<input type="hidden" id="callid" name="callid" value="<?=$_GET['id'];?>" />
						</fieldset>
						<fieldset>
						<legend>Details</legend>
							<label for="details">Comments</label>
							<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
						</fieldset>
						<p class="buttons">
							<button name="submit" value="submit" type="submit">Submit</button>
							<button name="clear" value="clear" type="reset">Clear</button>
						</p>
					</form>
					<? } ?>
				</div>
			</div>
		</div>
		</div>
		<script type="text/javascript">
			$("#addForm").validate({
				rules: {}
			});
		</script>
		<a href="/views/changelog.php" target="_blank" class="changelog">changelog</a>
	</body>
</html>