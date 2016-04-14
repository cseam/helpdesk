<div id="stats">
  <p>
    <?php include "views/partials/graphs/engineerStats.php" ?>
  </p>
</div>
<div id="engineerControls" class="engineersubnav">
  <a href="#" onclick="$('.engineerReports').hide();$('#calllist').slideDown('fast')"><img src="/public/images/ICONS-yourcalls.svg" alt="your tickets" title="your tickets" width="16" height="17"> Assigned</a>
  <a href="#" onclick="$('.engineerReports').hide();$('#deptlist').slideDown('fast')"><img src="/public/images/ICONS-allcalls.svg" alt="department tickets" title="department tickets" width="16" height="17"> Department</a>
  <a href="#" onclick="$('.engineerReports').hide();$('#objlist').slideDown('fast')"><img src="/public/images/ICONS-objective.svg" alt="performance objectives" title="performance objectives" width="16" height="17"> Objectives</a>
  <a href="#" onclick="$('.engineerReports').hide();$('#morelist').slideDown('fast')"><img src="/public/images/ICONS-workrate.svg" alt="more" title="more" width="16" height="17"> More </a>
</div>
<div id="calllist" class="engineerReports"><?php ($left->sideData["listdata"] ? include "views/partials/assignedtickets.php" : print("<h3>Assigned Tickets</h3><p>0 assigned tickets</p>")) ?></div>
<div id="deptlist" class="engineerReports"><?php ($left->sideData["deptdata"] ? include "views/partials/departmenttickets.php" : print("<h3>Department Tickets</h3><p>0 department tickets</p>")) ?></div>
<div id="objlist" class="engineerReports"><?php ($left->sideData["objdata"] ? include "views/partials/myobjectives.php" : print("<h3>Performance Objectives</h3><p>0 performance objectives set</p>")) ?></div>
<div id="morelist" class="engineerReports">
  <div id="reportlinks">
    <br/>
    <a href="/engineer/search"><img src="/public/images/ICONS-search.svg" alt="" title="" width="24" height="25" />Search</a>
    <a href="/engineer/lockers"><img src="/public/images/ICONS-lockers.svg" alt="" title="" width="24" height="25" />Lockers</a>
    <a href="/engineer/changecontrol"><img src="/public/images/ICONS-changecontrol.svg" alt="" title="" width="24" height="25" />Change Control</a>
    <a href="/engineer/outofhours"><img src="/public/images/ICONS-outofhours.svg" alt="" title="" width="24" height="25" />Out Of Hours</a>
    <a href="/engineer/workrate"><img src="/public/images/ICONS-workrate.svg" alt="" title="" width="24" height="25" />Work Rate</a>
  </div>
</div>
