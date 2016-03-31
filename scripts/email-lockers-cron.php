<?php


//TODO ALL THE THINGS

// Email users to remind them to collect stuff from lockers
// Process Lockers
echo ("\n-- Starting Process Lockers : "). date("h:i:s") . "\n";
  echo("* Items in Lockers \n");
  $STH = $DBH->Prepare("SELECT * FROM calls WHERE lockerid IS NOT NULL AND status = '2'");
  $STH->setFetchMode(PDO::FETCH_OBJ);
  $STH->execute();
  if ($STH->rowCount() == 0) { echo("0 Items in lockers");};
    while($row = $STH->fetch()) {
      // Loop each item in lockers
      echo("#" . $row->callid . " emailing user " . $row->email);
        // Construct message
        $to = $row->email;
        $message = "<span style='font-family: arial;'><p>Helpdesk (#" . $row->callid .", " . $row->title . ") item awaiting collection in IT Support</p>";
        $message .= "<p>Please come and collect your device from IT support as soon as possible, To view the details of this ticket please <a href='". HELPDESK_LOC ."'>Visit ". CODENAME ."</a></p>";
        $message .= "<p>This is an automated message please do not reply</p></span>";
        $msgtitle = "Your Helpdesk ticket (#" . $row->callid . ") is awaiting collection.";
        $headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
        $headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
        // In case any of our lines are larger than 70 characters, we wordwrap()
        $message = wordwrap($message, 70, "\r\n");
        // Send email
        mail($to, $msgtitle, $message, $headers);
        echo("(EMAIL SENT)\n");
    }
echo ("\n-- Ending Process Lockers : "). date("h:i:s") . "\n";
