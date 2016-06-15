<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <form action="/report/settings/" method="post" enctype="multipart/form-data" id="addForm">
        <input type="hidden" id="button_value" name="button_value" value="" />
        <?php if (isset($pagedata->success)) { echo "<span class=\"urgent\">" . $pagedata->success . "</span>"; } ?>
        <fieldset>
          <legend>Custom Report Date Range</legend>
          <label for="date-range" title="select a date range">Select a date range</label>
          <link rel="stylesheet" href="/public/css/daterangepicker.min.css">
          <script type="text/javascript" src="/public/javascript/moment.js"></script>
          <script type="text/javascript" src="/public/javascript/jquery.daterangepicker.min.js"></script>
          <input id="date-range" name="date-range" size="60" value="<?php isset($_SESSION['customReportsRangeStart']) ? print($_SESSION['customReportsRangeStart'] . " - " . $_SESSION['customReportsRangeEnd']) : null;  ?>">
          <script type="text/javascript">
          $('#date-range').dateRangePicker({
            startOfWeek: 'monday',
            separator : ' / ',
            format: 'YYYY-MM-DD',
            autoClose: true
          });
          </script>
        </fieldset>
        <fieldset>
          <legend>Helpdesk Filter</legend>
          <label for="helpdesks" title="which helpdesks should report show">Helpdesk Filter</label>
          <select id="helpdesks" name="helpdesks[]" multiple="multiple" style="height: 220px;">
            <option value="<?php echo $_SESSION['engineerHelpdesk']?>" SELECTED>My Helpdesks</option>
            <?php foreach ($pagedata->helpdesks as $key => $value) { echo "<option value=\"".$value["id"]."\">".$value["helpdesk_name"]."</option>";} ?>
          </select>
        </fieldset>
        <p class="buttons">
          <button name="save" value="save" type="submit" title="save" onclick="this.form.button_value.value = this.value;">Save</button>
        </p>
        </form>
      </div>
    </div>
  </div>

<?php require_once "views/partials/footer.php"; ?>
