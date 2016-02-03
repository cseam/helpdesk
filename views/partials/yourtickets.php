<h3>Your Tickets</h3>
<table id="yourcalls">
  <tbody>
    <?php
    foreach($listdata as $key => $value) { ?>
    <tr>
      <td>#<?= $value["callid"] ?></td>
      <td><span class='status<?= $value["status"] ?>'><?= $value["statusCode"] ?></span></td>
      <td><?= date("d/m/y", strtotime($value["opened"])) ?></td>
      <td><a href="/ticket/view/<?= $value["callid"] ?>" alt="view ticket"><?= $value["title"] ?></a></td>
      <td><a href="/ticket/view/<?= $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
