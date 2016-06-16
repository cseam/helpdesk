<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/reports.php" ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <table>
          <thead>
            <tr>
              <th style="width: 150px;">Satisfaction</th>
              <th>Customer</th>
              <th>Comment</th>
              <th style="width: 100px;">View ticket</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($pagedata->reportResults)) { foreach($pagedata->reportResults as $key => $value) { ?>
            <tr>
              <td><?php for ($i = 0; $i < round($value["satisfaction"]); $i++) { echo "<img src='/public/images/ICONS-star.svg' alt='star' height='24' width='auto' />"; } ?></td>
              <td><?php echo $value["owner"] ?></td>
              <td><?php echo $value["details"] ?></td>
              <td><a href="/ticket/view/<?php echo $value["callid"] ?>" alt="view ticket"><img src="/public/images/ICONS-view.svg" width="24" height="25" alt="view ticket" /></a></td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
