<?php require_once "views/partials/header.php"; ?>

  <div id="leftpage" style="overflow: scroll;">
    <br />
    <h3>Did you know</h3>
    <p>
      You have logged <span class="logoutstats"><?php echo number_format($pagedata->stats["countTicketsByOwner"]) ?></span> tickets on the helpdesk
    </p>
    <p>
      Total tickets logged by users <span class="logoutstats"><?php echo number_format($pagedata->stats["countAllTickets"]) ?></span>
    </p>
    <ul style="font-size: 0.9rem;">
    <?php
      foreach($pagedata->logoutstats as &$value) {
          echo "<li style=\"margin-bottom: 10px;margin-right: 50px;\">";
          echo $value["Name"];
          echo " have ";
          echo number_format($value["outstanding"]["outstanding"]);
          echo " outstanding tickets, on average tickets take ";
          echo number_format($value["avgCloseTime"]["avg_days"]);
          echo " days to close. " . $value["Name"] . "'s ";
          echo number_format($value["totalclosed"]["countTotal"]);
          echo " closed tickets have a average feedback of ";
          echo round($value["avgfeedback"]["FeedbackAVG"],2) . "&nbsp;&nbsp;";
          for ($i = 0; $i < round($value["avgfeedback"]["FeedbackAVG"]); $i++) {
            echo "<img src='/public/images/ICONS-star.svg' alt='star' height='16' width='auto' />";
            }
          echo "</li>";
      }
    ?>
    </ul>
  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h2>Good Bye</h2>
        <p>You have sucessfully logged out of <?php echo CODENAME ?>, see you soon!</p>
      </div>
    </div>
  </div>


<?php require_once "views/partials/footer.php"; ?>
