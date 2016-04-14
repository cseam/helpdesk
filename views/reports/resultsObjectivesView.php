<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <p><form action="/manager/objectives/" method="post" id="addForm">
            <input type="hidden" id="button_value" name="button_value" value="" />
            <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">Add Objective</button>
        </form></p>
        <table id="changecontrol">
              <thead>
                <tr>
                  <th>Objective</th>
                  <th>Engineer</th>
                  <th>Due</th>
                  <th>Progress</th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
              <tr>
                <td><a href="/manager/objectives/<?php echo $value["id"] ?>"><?php echo substr(strip_tags($value["title"]), 0, 50) ?></a></td>
                <td><?php echo $value["engineerName"] ?></td>
                <td><?php echo date("M Y", strtotime($value["datedue"]))  ?></td>
                <td><?php echo $value["progress"] ?>%</td>
                <td><a href="/manager/objectives/<?php echo $value["id"] ?>"><img src="/public/images/ICONS-view.svg" width="24" height="25" class="icon" alt="view ticket" /></a></td>
              </tr>
            <?php } ?>
            </tbody>
        </table>

      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
