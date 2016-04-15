<?php require_once "views/partials/header.php"; ?>

  <div id="leftpage">
    <br />
    <h3>Did you know</h3>
    <br/>
    <p>
      You have logged <span class="logoutstats"><?php echo number_format($stats["countTicketsByOwner"]) ?></span> tickets on the helpdesk
    </p>
    <br/>
    <p>
      Total tickets logged by users <span class="logoutstats"><?php echo number_format($stats["countAllTickets"]) ?></span>
    </p>
    <br/>
    <p>
      Open outstanding tickets on helpdesk <span class="logoutstats"><?php echo number_format($stats["countAllOpenTickets"]) ?></span>
    </p>
    <br/>
    <p>
      Average feedback for tickets on helpdesk is <span class="logoutstats"><?php echo round($stats["FeedbackAVG"],2)?></span> <?php for ($i = 0; $i < round($stats["FeedbackAVG"]); $i++) { echo "<img src='/public/images/ICONS-star.svg' alt='star' height='24' width='auto' />"; } ?>
    </p>
    <br/>
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
