<?php if (!$_POST) { ?>
<h3><?php echo $pagedata->title; ?></h3>
<p><?php echo $pagedata->details; ?></p>
<?php } else { ?>
<h3>Change Control Added</h3>
<p>Thank you your change control has been added and the team has been emailed to notify them.</p>
<?php } ?>
