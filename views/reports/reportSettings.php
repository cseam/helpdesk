<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <?php require_once "views/partials/leftside/".$left->sideData["partial"] ?>
  </div>

  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->details ?></p>
        <form action="/reports/settings/" method="post" enctype="multipart/form-data" id="addForm">
        <input type="hidden" id="button_value" name="button_value" value="" />
        <fieldset>
          <legend>Custom Report Date Range</legend>
          <label for="date-range" title="select a date range">Select a date range</label>
          <link rel="stylesheet" href="/public/css/daterangepicker.min.css">
          <script type="text/javascript" src="/public/javascript/moment.js"></script>
          <script type="text/javascript" src="/public/javascript/jquery.daterangepicker.min.js"></script>
          <input id="date-range" size="60" value="">
          <script type="text/javascript">
          $('#date-range').dateRangePicker({
            startOfWeek: 'monday',
            separator : ' ~ ',
            format: 'DD/MM/YYYY',
            autoClose: true
          });
          </script>
        </fieldset>
        <fieldset>
          <legend>Helpdesk Filter</legend>
          <label for="helpdesks" title="which helpdesks should report show">Helpdesk Filter</label>
          <select id="helpdesks" name="helpdesks">
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
