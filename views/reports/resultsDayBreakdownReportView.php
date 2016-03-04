<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <p>
        <?php include "views/partials/graphs/reportStats.php" ?>
      </p>
    </div>
    <div id="calllist">
        <?php include "views/partials/listReportReports.php" ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <table id="tablesorter" class="tablesorter">
          <thead>
            <tr>
              <th class="left">Engineer Name</th>
              <th class="left">Helpdesk</th>
              <th>0-7</th>
              <th>7-8</th>
              <th>8-9</th>
              <th>9-10</th>
              <th>10-11</th>
              <th>11-12</th>
              <th>12-13</th>
              <th>13-14</th>
              <th>14-15</th>
              <th>15-16</th>
              <th>16-17</th>
              <th>17-18</th>
              <th>18-19</th>
              <th>19-24</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($pagedata->reportResults as $key => $value) { ?>
            <tr>
              <td class="left"><?php echo $value["engineerName"] ?></td>
              <td class="left"><?php echo $value["helpdesk_name"] ?></td>
              <td><span class="day" title="<?php echo $value["0-7"] ?>" style="width:<?php echo $value["0-7"] ?>px;height:<?php echo $value["0-7"] ?>px"><?php echo $value["0-7"] ?></span></td>
              <td><span class="day" title="<?php echo $value["7-8"] ?>" style="width:<?php echo $value["7-8"] ?>px;height:<?php echo $value["7-8"] ?>px"><?php echo $value["7-8"] ?></span></td>
              <td><span class="day" title="<?php echo $value["8-9"] ?>" style="width:<?php echo $value["8-9"] ?>px;height:<?php echo $value["8-9"] ?>px"><?php echo $value["8-9"] ?></span></td>
              <td><span class="day" title="<?php echo $value["9-10"] ?>" style="width:<?php echo $value["9-10"] ?>px;height:<?php echo $value["9-10"] ?>px"><?php echo $value["9-10"] ?></span></td>
              <td><span class="day" title="<?php echo $value["10-11"] ?>" style="width:<?php echo $value["10-11"] ?>px;height:<?php echo $value["10-11"] ?>px"><?php echo $value["10-11"] ?></span></td>
              <td><span class="day" title="<?php echo $value["11-12"] ?>" style="width:<?php echo $value["11-12"] ?>px;height:<?php echo $value["11-12"] ?>px"><?php echo $value["11-12"] ?></span></td>
              <td><span class="day" title="<?php echo $value["12-13"] ?>" style="width:<?php echo $value["12-13"] ?>px;height:<?php echo $value["12-13"] ?>px"><?php echo $value["12-13"] ?></span></td>
              <td><span class="day" title="<?php echo $value["13-14"] ?>" style="width:<?php echo $value["13-14"] ?>px;height:<?php echo $value["13-14"] ?>px"><?php echo $value["13-14"] ?></span></td>
              <td><span class="day" title="<?php echo $value["14-15"] ?>" style="width:<?php echo $value["14-15"] ?>px;height:<?php echo $value["14-15"] ?>px"><?php echo $value["14-15"] ?></span></td>
              <td><span class="day" title="<?php echo $value["15-16"] ?>" style="width:<?php echo $value["15-16"] ?>px;height:<?php echo $value["15-16"] ?>px"><?php echo $value["15-16"] ?></span></td>
              <td><span class="day" title="<?php echo $value["16-17"] ?>" style="width:<?php echo $value["16-17"] ?>px;height:<?php echo $value["16-17"] ?>px"><?php echo $value["16-17"] ?></span></td>
              <td><span class="day" title="<?php echo $value["17-18"] ?>" style="width:<?php echo $value["17-18"] ?>px;height:<?php echo $value["17-18"] ?>px"><?php echo $value["17-18"] ?></span></td>
              <td><span class="day" title="<?php echo $value["18-19"] ?>" style="width:<?php echo $value["18-19"] ?>px;height:<?php echo $value["18-19"] ?>px"><?php echo $value["18-19"] ?></span></td>
              <td><span class="day" title="<?php echo $value["19-24"] ?>" style="width:<?php echo $value["19-24"] ?>px;height:<?php echo $value["19-24"] ?>px"><?php echo $value["19-24"] ?></span></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

        <script>
        // activate table sorting jquery library
        $(document).ready(function() {
                $("#tablesorter").tablesorter();
        });
        </script>


      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
