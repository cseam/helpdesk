<?php

class actionUpdateTicket {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $lockersModel = new lockersModel();
    $helpdeskModel = new helpdeskModel();
    $engineerModel = new engineerModel();
    $additionalModel = new additionalModel();
    $pagedata = new stdClass();

    //set page defaults
    $pagedata->button_value = $_POST["button_value"];

    // on post process form
    if ($_POST) {

      // check if files uploaded in form
      $upload_code = "";
      if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
        //rename file to random name to avoid file name clash
        $name_of_uploaded_file = substr(md5(microtime()),rand(0,26),10);
        //define uploads folder from config
        $folder = ROOT . UPLOAD_LOC . $name_of_uploaded_file;
        //define temp upload location
        $tmp_path = $_FILES["attachment"]["tmp_name"];
        //move file from temp location to uploads folder
        move_uploaded_file($tmp_path, $folder);
        //create html img tag for images else just add link to file in ticket details
        if (mime_content_type($folder) == "image/jpeg") {
          $upload_code = "<img src=" . UPLOAD_LOC . $name_of_uploaded_file . " alt=\"upload\" style=\"width: 100%;\" />";
        } else {
          $upload_code = "<a href=\"" . UPLOAD_LOC . $name_of_uploaded_file . "\" class=\"uploadfile\">Uploaded file ref: #".$name_of_uploaded_file."</a>";
        }
      }
      $ticketdetails = $upload_code . htmlspecialchars($_POST["updatedetails"]);
      // check which button is pressed and process correctly
      SWITCH ($_POST["button_value"]) {
        CASE "add":
            //process ticket add
              //calculate ticket urgency
                $urgency = round(($_POST['callurgency'] + $_POST['callseverity']) / 2 );
              //generate locker number if needed for specific categorys (clown fiesta: note to future self, put this in the db!)
                $lockerid = null;
                if ($_POST['category'] == 11 || $_POST['category'] == 41 || $_POST['category'] == 73 ) { $lockerid = random_locker(); };
              //generate ticket details including any images/files uploaded in wrapper
                $ticketdetails = "<div class=\"original\">" . $ticketdetails . "</div>";
              //check if helpdesk is auto assign and assign engineer if required
                $autoassigncheck = $helpdeskModel->isHelpdeskAutoAssign($_POST['helpdesk']);
                $autoassigncheck["auto_assign"] == 0 ? $assignedengineer = NULL : $assignedengineer = $engineerModel->getNextEngineerIdByHelpdeskId($_POST['helpdesk']);
              //check if helpdesk manager required email on new tickets
                $emailmanagers = $helpdeskModel->isHelpdeskEmailEnabled($_POST['helpdesk']);
                if ($emailmanagers) {
                  foreach($emailmanagers as $key => $value) {
                    //email managers letting them know a new ticket has been added.
                    $to = $value["engineerEmail"];
                    $from = "helpdesk@cheltladiescollege.org";
                    $title = "New Helpdesk Ticket Added";
                    $emailmanagersmessage .= "<p>A new ticket has been added to your helpdesk, To view the details of this ticket please <a href=\"". HELPDESK_LOC ."\">Visit ". CODENAME ."</a></p>";
                    $emailmanagersmessage .= "<p>This is an automated message please do not reply</p></span>";
                    email_user($to, $from, $title, $emailmanagersmessage);
                  }
                }
              //check engineer hasnt assigned to themselfs
                $_POST['cmn-toggle-selfassign'] !== null ? $assigned = $_POST['cmn-toggle-selfassign'] : $assigned = $assignedengineer;
              //check auto close
                if ($_POST['cmn-toggle-retro'] !== null) {
                  $status = '2';
                  $closed = date("c");
                  $closeengineerid = $_POST['engineerid'];
                } else {
                  $status = '1';
                  $closed = null;
                  $closeengineerid = null;
                };
              //check ticket is pm (premtive maintanence)
                $_POST['cmn-toggle-pm'] !== null ? $pm=1 : $pm=0 ;
              //insert ticket base detail
                $baseTicket = new stdClass();
                $baseTicket->name = htmlspecialchars($_POST['name']);
                $baseTicket->contact_email = htmlspecialchars($_POST['contact_email']);
                $baseTicket->tel = htmlspecialchars($_POST['tel']);
                $baseTicket->details = $ticketdetails;
                $baseTicket->assigned = $assigned;
                $baseTicket->opened = date("c");
                $baseTicket->lastupdate = date("c");
                $baseTicket->status = htmlspecialchars($status);
                $baseTicket->closed = $closed;
                $baseTicket->closeengineerid = htmlspecialchars($closeengineerid);
                $baseTicket->urgency = htmlspecialchars($urgency);
                $baseTicket->location = htmlspecialchars($_POST['location']);
                $baseTicket->room = htmlspecialchars($_POST['room']);
                $baseTicket->category = htmlspecialchars($_POST['category']);
                $baseTicket->owner = htmlspecialchars($_SESSION['sAMAccountName']);
                $baseTicket->helpdesk = htmlspecialchars($_POST['helpdesk']);
                $baseTicket->invoice = null;
                $baseTicket->callreason = null;
                $baseTicket->title = htmlspecialchars($_POST['title']);
                $baseTicket->lockerid = $lockerid;
                $baseTicket->pm = htmlspecialchars($pm);
                $ticketid = $ticketModel->createNewTicket($baseTicket);
              //insert additional ticket details
                $fieldIdentify = $additionalModel->getListOfAdditionalFieldsByCategorys(htmlspecialchars($_POST['category']));
                foreach ($fieldIdentify as $key => $value) {
                  $fieldname = "label".$value["id"];
                  $labelname = "labelname".$value["id"];
                  $additionalModel->addAdditionalResult($ticketid, htmlspecialchars($_POST[$labelname]), htmlspecialchars($_POST[$fieldname]));
                }
              //update engineers assignment table
                $engineerModel->updateAutoAssignEngineerByHelpdeskId($_POST['helpdesk'], $assignedengineer);
              //get SLA if helpdesk has one and update message for view
                $pagedata->sla = $helpdeskModel->getSLADetailsByUrgencyId($urgency, $_POST['helpdesk']);
              //get Out of hours message and update view
                $pagedata->outofhourscontact = $helpdeskModel->getOutOfHoursContactDetailsByHelpdeskId($_POST['helpdesk']);
              //update page details for view
                $pagedata->title = "Ticket Created";
                $pagedata->details = "Thank you, your ticket has been created an engineer will be in touch shortly regarding your request.";
              //TODO populate graphs and my tickets for view
          break;
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
          $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]);
          $ticketModel->updateTicketDetailsById($_POST["id"], "update", $_SESSION["sAMAccountName"] , "Awaiting invoice:".$ticketdetails);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been marked as awaiting invoice.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Marked for Invoice";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and marked for invoice, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "invoicearrived":
          $ticketModel->updateTicketInvoiceReceivedById($_POST["id"]);
          $ticketModel->updateTicketDetailsById($_POST["id"], "update", $_SESSION["sAMAccountName"] , "Invoice received:".$ticketdetails);
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Invoice Arrived";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and marked as invoice received.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "sendaway":
          $ticketModel->updateTicketStatusById($_POST["id"], 5);
          $ticketModel->updateTicketDetailsById($_POST["id"], "sendaway", $_SESSION["sAMAccountName"] , $ticketdetails);
          $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Sent Away";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and sent away, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "return":
          $ticketModel->updateTicketStatusById($_POST["id"], 1);
          $ticketModel->updateTicketDetailsById($_POST["id"], "returned", $_SESSION["sAMAccountName"] , $ticketdetails);
          $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Returned";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and returned, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "escalate":
          $ticketModel->updateTicketStatusById($_POST["id"], 4);
          $ticketModel->updateTicketDetailsById($_POST["id"], "escalated", $_SESSION["sAMAccountName"] , $ticketdetails);
          $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Escalated";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and escalated to managment, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "deescalate":
          $ticketModel->updateTicketStatusById($_POST["id"], 1);
          $ticketModel->updateTicketDetailsById($_POST["id"], "deescalated", $_SESSION["sAMAccountName"] , $ticketdetails);
          $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - De-Escalated";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and de-escalated, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "hold":
          $ticketModel->updateTicketStatusById($_POST["id"], 3);
          $ticketModel->updateTicketDetailsById($_POST["id"], "hold", $_SESSION["sAMAccountName"] , $ticketdetails);
          $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - On Hold";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and put on hold, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "unhold":
          $ticketModel->updateTicketStatusById($_POST["id"], 1);
          $ticketModel->updateTicketDetailsById($_POST["id"], "unhold", $_SESSION["sAMAccountName"] , $ticketdetails);
          $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been updated.</p>";
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Un Hold";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and taken off hold, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "close":
          $ticketModel->updateTicketDetailsById($_POST["id"], "closed", $_SESSION["sAMAccountName"] , $ticketdetails);
          $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]);
          $emailmessage = "<span style=\"font-family: arial;\"><p>Your helpdesk ticket #".$_POST["id"]." has been closed.</p>";
          $ticketModel->closeTicketById($_POST["id"], $_SESSION["engineerId"], $_POST["callreason"]);
          $pagedata->title = "#".$_POST["id"]." Ticket Updated - Closed";
          $pagedata->details = "Ticket " .$_POST["id"] . " has been updated and closed, the ticket owner has been emailed to let them know the update to the ticket.<br /><br /><a href=\"/ticket/view/".$_POST["id"]."\" >Return to ticket</a>";
          break;
        CASE "update":
          $ticketModel->updateTicketDetailsById($_POST["id"], "update", $_SESSION["sAMAccountName"] , $ticketdetails);
          if ($_POST["callreason"]) { $ticketModel->updateTicketReasonById($_POST["id"], $_POST["callreason"]); }
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
