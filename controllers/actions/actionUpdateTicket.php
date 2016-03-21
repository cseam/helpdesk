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
      SWITCH ($_POST["button_value"]) {
        //TODO need to sort the button toggles if already on hold etc
        CASE "feedback":
            // reroute to feedback form
            header('Location: /ticket/feedback/'.$_POST["id"]);
            exit;
          break;
        CASE "forward":
            // reroute to forward form
            header('Location: /ticket/forward/'.$_POST["id"]);
            exit;
          break;
        CASE "assign":
            // reroute to assign form
            header('Location: /ticket/assign/'.$_POST["id"]);
            exit;
          break;
        CASE "locker":
          $lockerid = random_locker();
          $lockersModel->updateTicketLockerById($_POST["id"], $lockerid);
          $ticketModel->updateTicketDetailsById($_POST["id"], "open", $_SESSION["sAMAccountName"] , "Item added to locker ".$lockerid);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your item has been stored in locker " . $lockerid .".</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Assigned to locker (".$lockerid.")";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and added to locker ".$lockerid.", the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "invoice":
          $ticketModel->updateTicketRequireInvoiceById($_POST["id"]);
          $ticketModel->updateTicketDetailsById($_POST["id"], "open", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been marked as awaiting invoice.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Marked for Invoice";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and marked for invoice, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "sendaway":
          $ticketModel->updateTicketStatusById($_POST["id"], 5);
          $ticketModel->updateTicketDetailsById($_POST["id"], "sendaway", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Sent Away";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and sent away, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "escalate":
          $ticketModel->updateTicketStatusById($_POST["id"], 4);
          $ticketModel->updateTicketDetailsById($_POST["id"], "escalated", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Escalated";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and escalated to managment, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "hold":
          $ticketModel->updateTicketStatusById($_POST["id"], 3);
          $ticketModel->updateTicketDetailsById($_POST["id"], "hold", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - On Hold";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and put on hold, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "close":
          $ticketModel->updateTicketDetailsById($_POST["id"], "closed", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been closed.</p>";
          $ticketModel->closeTicketById($_POST["id"], $_SESSION["engineerId"], $_POST["callreason"]);
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Closed";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and closed, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "update":
          $ticketModel->updateTicketDetailsById($_POST["id"], "open", $_SESSION["sAMAccountName"] , $_POST["updatedetails"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
      }

      if ($emailmessage) {
      //if message set email user to update them
      $to = $_POST["contact_email"];
      $from = "helpdesk@cheltladiescollege.org";
      $title = "Helpdesk update";
      $emailmessage .= "<p>To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
      $emailmessage .= "<p>This is an automated message please do not reply</p></span>";
      email_user($to, $from, $title, $emailmessage);
      }

    }
    // render page
    require_once "views/updateTicketView.php";
  }

}
