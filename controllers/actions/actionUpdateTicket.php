<?php

class actionUpdateTicket {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $lockersModel = new lockersModel();
    $pagedata = new stdClass();
    //set page defaults
    $pagedata->button_value = $_POST["button_value"];
    if ($_POST) {
      // check post button behaviour to confirm action
      SWITCH ($_POST["button_value"]) {
        CASE "feedback":
          //render feedback form
          //TODO render form
          break;
        CASE "forward":
          //render forward form
          //TODO render form
          break;
        CASE "assign":
          //render assign form
          //TODO render form
          break;
        CASE "locker":
          //generate locker number and update ticket
          $lockerid = random_locker();
          $lockersModel->updateTicketLockerById($_POST["id"], $lockerid);
          //update ticket details
          $ticketModel->updateTicketDetailsById($_POST["id"], "open", $_SESSION["sAMAccountName"] , "Item added to locker ".$lockerid);
          //email user to notify
            $to = $_POST["contact_email"];
            $from = "helpdesk@cheltladiescollege.org";
            $title = "Your item has been stored in locker: " . $lockerid;
            $message = "<span style=\"font-family: arial;\"><p>Your item has been stored in locker " . $lockerid .".</p>";
            $message .= "<p>To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
            $message .= "<p>This is an automated message please do not reply</p></span>";
          email_user($to, $from, $title, $message);
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Assigned to locker (".$lockerid.")";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and added to locker ".$lockerid.", the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "invoice":
          //update ticket to mark for invoice required
          $ticketModel->updateTicketRequireInvoiceById($_POST["id"]);
          //update ticket details
          $ticketModel->updateTicketDetailsById($_POST["id"], "open", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Marked for Invoice";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and marked for invoice, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "sendaway":
          //update ticket status to sent away (5)
          $ticketModel->updateTicketStatusById($_POST["id"], 5);
          //update ticket details
          $ticketModel->updateTicketDetailsById($_POST["id"], "sendaway", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          //email user to notify
            $to = $_POST["contact_email"];
            $from = "helpdesk@cheltladiescollege.org";
            $title = "Your item has been updated - sent away.";
            $message = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #". $_POST["id"] ."has been updated.</p>";
            $message .= "<p>To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
            $message .= "<p>This is an automated message please do not reply</p></span>";
          email_user($to, $from, $title, $message);
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Sent Away";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and sent away, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "escalate":
          //update ticket status to escalated (4)
          $ticketModel->updateTicketStatusById($_POST["id"], 4);
          //update ticket details
          $ticketModel->updateTicketDetailsById($_POST["id"], "escalated", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          //email user to notify
            $to = $_POST["contact_email"];
            $from = "helpdesk@cheltladiescollege.org";
            $title = "Your item has been updated - escalated.";
            $message = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #". $_POST["id"] ."has been updated.</p>";
            $message .= "<p>To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
            $message .= "<p>This is an automated message please do not reply</p></span>";
          email_user($to, $from, $title, $message);
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Escalated";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and escalated to managment, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "hold":
          //update ticket status to hold (3)
          $ticketModel->updateTicketStatusById($_POST["id"], 3);
          //update ticket details
          $ticketModel->updateTicketDetailsById($_POST["id"], "hold", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          //email user to notify
            $to = $_POST["contact_email"];
            $from = "helpdesk@cheltladiescollege.org";
            $title = "Your item has been updated - hold.";
            $message = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #". $_POST["id"] ."has been updated.</p>";
            $message .= "<p>To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
            $message .= "<p>This is an automated message please do not reply</p></span>";
          email_user($to, $from, $title, $message);
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - On Hold";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and put on hold, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "close":
          //update ticket details
          $ticketModel->updateTicketDetailsById($_POST["id"], "closed", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          //email user to notify
            $to = $_POST["contact_email"];
            $from = "helpdesk@cheltladiescollege.org";
            $title = "Your item has been updated - closed.";
            $message = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #". $_POST["id"] ."has been closed.</p>";
            $message .= "<p>To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
            $message .= "<p>This is an automated message please do not reply</p></span>";
          email_user($to, $from, $title, $message);
          //process ticket close
          $ticketModel->closeTicketById($_POST["id"], $_SESSION["engineerId"], $_POST["callreason"]);
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Closed";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and closed, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "update":
          //update ticket details
          $ticketModel->updateTicketDetailsById($_POST["id"], "open", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          //email user to notify
            $to = $_POST["contact_email"];
            $from = "helpdesk@cheltladiescollege.org";
            $title = "Your item has been updated.";
            $message = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #". $_POST["id"] ."has been updated.</p>";
            $message .= "<p>To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
            $message .= "<p>This is an automated message please do not reply</p></span>";
          email_user($to, $from, $title, $message);
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
      }
    }
    // render page
    require_once "views/updateTicketView.php";
  }

}
