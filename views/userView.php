<?php require_once "views/partials/header.php"; ?>


  <div id="leftpage">
    <div id="stats">
      <h3>Information</h3>
      <p>Welcome to <?php echo(CODENAME);?>. Please use the form to log tickets for engineers. Once your ticket is logged you will receive email feedback on your issue.</p><p>Return here any time to see the status of your ticket, clicking the ticket title under 'Your Tickets' to view updates.</p>
      <p class="note">Remember, the more information you provide, the quicker the engineer can fix your problem. For example, if your printer is out of ink, please include the location of the printer, the printer model, the colour of the ink cartridge, etc.</p>
    </div>
    <div id="calllist">
      <?php include "views/partials/yourtickets.php"; ?>
    </div>
    </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h1><?php echo $pagedata->title ?></h1>
        <p><?php echo $pagedata->summary ?></p>
        <p>
          //TODO add new ticket
        </p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
