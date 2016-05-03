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

        <table>
        <thead>
          <tr>
            <th>
              Location Name
            </th>
            <th>
              Location Icon
            </th>
            <th>
              Location Shorthand
            </th>
            <th>
              Manage
            </th>
          </tr>
        </thead>
        <tbody>
        <?php
          if (isset($pagedata->listoflocations)) {
              foreach ($pagedata->listoflocations as $key => $value) { ?>
                <tr>
                  <td>
                    <?php echo $value["locationName"]; ?>
                  </td>
                  <td>
                    <img src="/public/images/<?php echo $value["iconlocation"]; ?>" alt="<?php echo $value["iconlocation"]; ?>" title="<?php echo $value["iconlocation"]; ?>" width="16" height="16" />&nbsp;<?php echo $value["iconlocation"]; ?>
                  </td>
                  <td>
                    <?php echo $value["shorthand"]; ?>
                  </td>
                  <td>
                    <?php echo $value["id"]; ?>
                  </td>
                </tr>
        <?php  }
          }
        ?>
        </tbody>
        </table>


      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
