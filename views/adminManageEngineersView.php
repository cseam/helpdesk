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
            <button name="add" value="add" type="submit" onclick="this.form.button_value.value = this.value;">Add New Engineer</button>
          </form>
        </p>
        <table>
        <thead>
          <tr>
            <th>Engineer Name</th>
            <th>Helpdesk</th>
            <th>sAMAccountName</th>
            <th>Engineer Level</th>
            <th>Disabled</th>
            <th>Superuser</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
        <?php
          if (isset($pagedata->listofengineers)) {
              foreach ($pagedata->listofengineers as $key => $value) { ?>
                <tr>
                  <td><?php echo $value["engineerName"]; ?></td>
                  <td><?php echo $value["helpdesk"]; ?></td>
                  <td><?php echo $value["sAMAccountName"]; ?></td>
                  <td><?php echo $value["engineerLevel"]; ?></td>
                  <td><?php echo ($value["disabled"]? 'yes' : 'no'); ?></td>
                  <td><?php echo ($value["superuser"]? 'yes' : 'no') ; ?></td>
                  <td>
                    <form action="#" method="post" id="modifyForm" class="modifyconfirm">
                        <input type="hidden" id="button_modify_value" name="button_modify_value" value="" />
                        <input type="hidden" id="id" name="id" value="<?php echo $value["idengineers"] ?>" />
                        <button name="modify" value="modify" type="submit" onclick="this.form.button_modify_value.value = this.value;">Modify</button>
                        <button name="delete" value="delete" type="submit" onclick="this.form.button_modify_value.value = this.value;">Disable</button>
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
