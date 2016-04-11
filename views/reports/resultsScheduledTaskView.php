<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php ($stats ? include "views/partials/graphs/managerStats.php" : print("no data")) ?>
      </p>
    </div>
    <div id="calllist">
        <?php include "views/partials/listManagerReports.php" ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <p><form action="#" method="post" id="addForm">
            <input type="hidden" id="button_value" name="button_value" value="" />
            <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">Add Scheduled Task</button>
        </form></p>
        <table id="changecontrol">
          <thead>
            <tr class="head">
              <th>#</th>
              <th>Title</th>
              <th>Scheduled</th>
              <th>Update</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
              <tr>
                <td><?php echo $value["callid"] ?></td>
                <td><?php echo $value["title"]?></td>
                <td><?php echo $value["frequencytype"]?></td>
                <td>
                  <form action="#" method="post" id="modifyForm">
                      <input type="hidden" id="button_modify_value" name="button_modify_value" value="" />
                      <input type="hidden" id="callid" name="callid" value="<?php echo $value["callid"] ?>" />
                      <button name="modify" value="modify" type="submit" onclick="this.form.button_modify_value.value = this.value;">Modify</button>
                      <button name="delete" value="delete" type="submit" onclick="this.form.button_modify_value.value = this.value;">Delete</button>
                  </form>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
