<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="calllist">
      <?php include "views/partials/listAdminReports.php" ?>
    </div>
  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <p>
          <form action="#" method="post" id="addForm">
            <input type="hidden" id="button_value" name="button_value" value="" />
            <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">Add Location</button>
          </form>
        </p>
        <table>
        <thead>
          <tr>
            <th>Location Name</th>
            <th>Location Icon</th>
            <th>Location Shorthand</th>
            <th>Option Group</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
        <?php
          if (isset($pagedata->listoflocations)) {
              foreach ($pagedata->listoflocations as $key => $value) { ?>
                <tr>
                  <td><?php echo $value["locationName"]; ?></td>
                  <td><img src="/public/images/<?php echo $value["iconlocation"]; ?>" alt="<?php echo $value["iconlocation"]; ?>" title="<?php echo $value["iconlocation"]; ?>" width="16" height="16" />&nbsp;<?php echo $value["iconlocation"]; ?></td>
                  <td><?php echo $value["shorthand"]; ?></td>
                  <td><?php echo $value["optiongroup"]; ?></td>
                  <td>
                    <form action="#" method="post" id="modifyForm" class="modifyconfirm">
                        <input type="hidden" id="button_modify_value" name="button_modify_value" value="" />
                        <input type="hidden" id="id" name="id" value="<?php echo $value["id"] ?>" />
                        <button name="modify" value="modify" type="submit" onclick="this.form.button_modify_value.value = this.value;">Modify</button>
                        <button name="delete" value="delete" type="submit" onclick="this.form.button_modify_value.value = this.value;">Delete</button>
                    </form>
                </tr>
        <?php  }
          }
        ?>
        </tbody>
        </table>
        <script type="text/javascript">
        $('.modifyconfirm').submit(function(event){
          if(!confirm("\nAre you sure?")){
            event.preventDefault();
          }
        });
        </script>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
