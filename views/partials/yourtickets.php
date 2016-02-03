<h3>Your Tickets</h3>

<table id="yourcalls">
  <tbody>
    <?php foreach($listdata as $key => $value) { ?>
    <tr>
      <td>#<?= $value["callid"] ?></td>
      <td><?= $value["status"] ?></td>
      <td><?= date("d/m/y", strtotime($value["opened"])) ?></td>
      <td><?= $value["title"] ?></td>
      <td><input type="image" name="submit" value="submit" src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="View ticket" title="View ticket"/></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
