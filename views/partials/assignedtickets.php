<h3>Assigned Tickets</h3>
<table id="yourcalls">
  <tbody>
    <?php
    foreach($listdata as $key => $value) { ?>
    <tr>
      <td>#<?php echo $value["callid"] ?></td>
      <td><span class="status<?php echo $value["status"] ?>"><?php echo $value["statusCode"] ?></span></td>
      <td><?php echo date("d/m/y", strtotime($value["opened"])) ?></td>
      <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><?php echo $value["title"] ?></a></td>
      <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
