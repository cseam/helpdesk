<?php require_once "views/partials/header.php"; ?>

  <div id="leftpage">
    <fieldset id="login">
      <legend>log in to <?php echo CODENAME ?></legend>
        <form action="/login" method="post" enctype="multipart/form-data" id="checkPassword">
          <label for="username">Username</label><input id="username" type="text" name="username" value="" autofocus>
          <label for="password">Password</label><input id="password" type="password" name="password" value="">
          <input id="btnLogin" type="submit" name="btnLogin" value="LOG IN" />
          <?php if (isset($pagedata->message)) { ?>
            <div class="note urgent">
              <h3 style="padding-left: 35px;">Error</h3>
              <p style="padding-left: 35px;"><?php echo $pagedata->message ?>, check your details and try again.</p>
            </div>
          <?php  }; ?>
        </form>
        <p>Welcome to <?php echo CODENAME ?>. To begin please log in with your standard College username and password.</p>
        <p>You do not need to prefix your username with CLC\. Login like you would to one of the College computers, e.g. username: smitha</p>
        <p>If you have any issues with <?php echo CODENAME ?>, please contact IT Support.</p>
			</fieldset>
  </div>
  <div id="rightpage">
    <div id="call">
      <div id="ajax">
        <h2>FAQs</h2>
        <h3>What is  <?php echo CODENAME ?>?</h3>
        <p><?php echo CODENAME ?> is a way for users at College to quickly and easily report issues they have noticed around campus to the correct department for action.</p>
        <h3>Who Can use  <?php echo CODENAME ?>?</h3>
        <p><?php echo CODENAME ?> is open to both staff and students. If you notice a bulb has blown, a tap is dripping, a computer isn't working, a sign has fallen down, etc. then don't wait for someone else to report it - you can. </p>
        <h3>What should I report?</h3>
        <p>Anything you feel isn't working correctly. Engineers from the correct department will then be able to ask you questions about your ticket - your report on Helpdesk - to help resolve the problem. Please include as much information as possible. For example, reporting that a radiator isn't working but not supplying the location, or requesting ink for a printer without including the printer model or ink colour, will slow down the process.  </p>
        <h3>Why should i log a <?php echo CODENAME ?>?</h3>
        <p>It is a swift process and will ensure that the problem is looked at as soon as possible. With College being such a large environment, engineers may not notice a problem straight away, but with Helpdesk you can bring it to their attention immediately. </p>
        <h3>Why not just send an email?</h3>
        <p>If you do not know who to specifically contact, or an engineer is on holiday, <?php echo CODENAME ?> takes care of that for you and directs your problem to the appropriate department and / or person. Not only that, it provides department managers with statistical data, helping them troubleshoot larger issues and even spot patterns. Emailing individuals may solve your issue, but Helpdesk can warn of future problems as well. </p>
        <h3>How do i use Helpdesk?</h3>
        <p>Helpdesk is designed to be a simple as possible, to help new users familiarise themselves with the process a illustrated step by step guide for users is available to read <a href="/documentation/Helpdesk%20-%20User%20Helpdesk%20Procedure.pdf" alt="documentation">here</a>.</p>
      </div>
    </div>
  </div>

<?php require_once "views/partials/footer.php"; ?>
