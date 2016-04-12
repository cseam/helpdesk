<br/>
<table id="yourcalls">
  <thead>
    <tr>
      <th>My Performance Objectives</th>
      <th>Progress</th>
      <th>Due</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($left->sideData["objdata"] as $key => $value) { ?>
      <tr>
        <td><a href="/engineer/objectives/<?php echo $value["id"] ?>"><?php echo substr(strip_tags($value["title"]), 0, 50) ?></a></td>
        <td><?php echo $value["progress"] ?>%</td>
        <td><?php echo date("M/Y", strtotime($value["datedue"])) ?></td>
        <td><a href="/engineer/objectives/<?php echo $value["id"] ?>"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
