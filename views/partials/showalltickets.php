<h3>Priority Tickets</h3>
<table id="yourcalls">
  <tbody>
    <?php
    foreach ($left->sideData["showalldata"] as $key => $value) { ?>
    <tr>
      <td>#<?php echo $value["callid"] ?></td>
      <td>
        <?php if ($value["userupdate"] === '0') { ?>
          <span class="status7" title="Ticket updated by user">User Updated</span>
        <?php } elseif ($value["userupdate"] === '2') { ?>
          <span class="status7" title="Ticket updated by Manager">Manager Update</span>
        <?php } else { ?>
          <span class="status<?php echo $value["status"] ?>"><?php echo $value["statusCode"] ?></span>
        <?php } ?>
      </td>
      <td><?php echo date("d/m/y", strtotime($value["opened"])) ?></td>
      <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><?php echo $value["title"] ?></a></td>
      <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<br />
