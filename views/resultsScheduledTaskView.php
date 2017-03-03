<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <h3>Yearly Frequency</h3>
        <hr />
        <div id="frequencymap">
        <?php
          $spacers = date("w", strtotime(date("Y")."-01-01"));
          for($i = 1; $i<=$spacers; $i++) { ?>
            <span class="dayspacer"></span>
        <?php } ?>
        <?php
          for($i = 0; $i<=364; $i++) {
          $opacity = 0;
          $opacity = number_format($pagedata->frequency[$i] / max($pagedata->frequency), 2);
          $opacity -= number_format(min($pagedata->frequency)/100, 2);
          $date = DateTime::createFromFormat('z Y', strval($i) . ' ' . strval(date("Y")));
          ?>
        <span class="day" title="(<?php echo $date->format("D jS M") ;?>) tasks scheduled:<?php echo $pagedata->frequency[$i]; ?>">
          <span class="colourfill" style="opacity: <?php echo $opacity ?>;"></span>
        </span>
        <?php } ?>
        </div>
        <hr />
        <div class="frequencykey">
          <span>More &nbsp;&nbsp;</span>
          <span class="day"><span class="colourfill" style="opacity: 1;"></span></span>
          <span class="day"><span class="colourfill" style="opacity: .8;"></span></span>
          <span class="day"><span class="colourfill" style="opacity: .6;"></span></span>
          <span class="day"><span class="colourfill" style="opacity: .4;"></span></span>
          <span class="day"><span class="colourfill" style="opacity: .2;"></span></span>
          <span>&nbsp;&nbsp; Less</span>
        </div>


        <h3>Task Details</h3>
        <p><form action="#" method="post" id="addForm">
            <input type="hidden" id="button_value" name="button_value" value="" />
            <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">Add Scheduled Task</button>
            <button name="enableall" value="enableall" type="submit" onclick="this.form.button_value.value = this.value;">Enable All</button>
            <button name="disableall" value="disableall" type="submit" onclick="this.form.button_value.value = this.value;">Disable All</button>
        </form></p>
        <table id="changecontrol">
          <thead>
            <tr class="head">
              <th>#</th>
              <th>Enabled</th>
              <th>Title</th>
              <th>Scheduled</th>
              <th>Update</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pagedata->reportResults as $key => $value) { ?>
              <tr>
                <td><?php echo $value["callid"] ?></td>
                <td><?php echo (boolval($value["enabled"]) ? '&#10003;' : '&#10006;') ?></td>
                <td><?php echo $value["title"]?></td>
                <td><?php echo $value["frequencytype"]?></td>
                <td>
                  <form action="#" method="post" id="modifyForm">
                      <input type="hidden" id="button_modify_value" name="button_modify_value" value="" />
                      <input type="hidden" id="callid" name="callid" value="<?php echo $value["callid"] ?>" />
                      <button name="delete" value="delete" type="submit" onclick="this.form.button_modify_value.value = this.value;" style="width:90px">Delete</button>
                      <button name="modify" value="modify" type="submit" onclick="this.form.button_modify_value.value = this.value;" style="width:90px">Modify</button>
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
