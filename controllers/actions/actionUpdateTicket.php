<?php

class actionUpdateTicket {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $pagedata = new stdClass();
    //set page defaults
    $pagedata->button_value = $_POST["button_value"];
    if ($_POST) {
      // check post button behaviour to confirm action
      SWITCH ($_POST["button_value"]) {
        CASE "assign":
          break;
        CASE "invoice":
          //update ticket to mark for invoice required
          $ticketModel->updateTicketRequireInvoiceById($_POST["id"]);
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Marked for Invoice";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and marked for invoice, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "locker":
          break;
        CASE "sendaway":
          //update ticket status to sent away (5)
          $ticketModel->updateTicketStatusById($_POST["id"], 5);
          //update ticket details
          //TODO ticket update method
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Sent Away";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and sent away, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "escalate":
          //update ticket status to escalated (4)
          $ticketModel->updateTicketStatusById($_POST["id"], 4);
          //update ticket details
          //TODO ticket update method
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Escalated";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and escalated to managment, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "hold":
          //update ticket status to hold (3)
          $ticketModel->updateTicketStatusById($_POST["id"], 3);
          //update ticket details
          //TODO ticket update method
          //update page message from default
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - On Hold";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and put on hold, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "close":
          //update ticket status to hold (2)
          $ticketModel->updateTicketStatusById($_POST["id"], 2);
          //update ticket details
          //TODO ticket update method
          //update page message from default
          //TODO copy from other actions
          break;
        CASE "update":
          break;
        CASE "feedback":
          break;
      }
    }
    // render page
    require_once "views/updateTicketView.php";
  }

}
