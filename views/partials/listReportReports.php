<div id="reportlinks">
  <!-- generic reports -->
  <a href="/report/engineerbreakdown/"><img src="/public/images/ICONS-yourcalls.svg" alt="Engineer Breakdown" title="Engineer Breakdown" width="24" height="25" />Engineer Totals</a>
  <a href="/report/helpdeskbreakdown/"><img src="/public/images/ICONS-viewfulldetails.svg" alt="Helpdesk Breakdown" title="Helpdesk Breakdown" width="24" height="25" />Helpdesk Totals</a>
  <a href="/report/categorybreakdown/"><img src="/public/images/ICONS-unassigned.svg" alt="Category Breakdown" title="Category Breakdown" width="24" height="25" />Category Totals</a>
  <a href="/report/urgencybreakdown/"><img src="/public/images/ICONS-urgent.svg" alt="Urgency Breakdown" title="Urgency Breakdown" width="24" height="25" />Urgency Breakdown</a>
  <a href="/report/daybreakdown/"><img src="/public/images/ICONS-daybreakdown.svg" alt="Day Breakdown" title="Day Breakdown" width="24" height="25" />Day Activity</a>
  <a href="/report/plannedvs/"><img src="/public/images/ICONS-punchcard.svg" alt="Planned vs Reactive" title="Planned vs Reactive" width="24" height="25" />Planned vs Reactive</a>
  <a href="/report/workrate/"><img src="/public/images/ICONS-workrate.svg" alt="Engineer work rate" title="Engineer work rate" width="24" height="25" />Closed Totals</a>
  <a href="/report/assignednumbers/"><img src="/public/images/ICONS-assignnotclosed.svg" alt="View assigned numbers" title="View assigned numbers" width="24" height="25" />Assigned Breakdown</a>
  <a href="/report/reason/"><img src="/public/images/ICONS-reason.svg" alt="reason behind issue" title="reason behind issue" width="24" height="25" />Reason behind issue</a>
  <a href="/report/recentwork/"><img src="/public/images/ICONS-workingon.svg" alt="working on" title="working on" width="24" height="25" />Recent Work</a>
  <a href="/report/outstanding"><img src="/public/images/ICONS-workrate.svg" alt="outstanding" title="outstanding" width="24" height="25" />Outstanding Totals</a>
  <a href="/report/annualgraphs"><img src="/public/images/ICONS-workrate.svg" alt="annualgraphs" title="annualgraphs" width="24" height="25" />Annual Graphs</a>
<?php
  // manager reports
  if ($_SESSION['engineerLevel'] > 1 || $_SESSION['superuser'] == 1) { ?>
  <a href="/report/sla/"><img src="/public/images/ICONS-scheduledtask.svg" alt="SLA Performance" title="SLA Performance" width="24" height="25" />SLA Performance</a>
  <a href="/report/feedback/"><img src="/public/images/ICONS-userfeedback.svg" alt="User Feedback" title="User Feedback" width="24" height="25" />User feedback</a>
<?php } ?>
</div>
