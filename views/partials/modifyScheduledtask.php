<?php if (!$_POST) { ?>
<h3><?php echo $pagedata->title; ?></h3>
<p><?php echo $pagedata->details; ?></p>
<?php } else { ?>
<h3>Scheduled Task Changed</h3>
<p>Thank you your scheduled task has been updated.</p>
<?php } ?>
