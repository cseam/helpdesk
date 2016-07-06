<?php

class loginController {
  private $error;
  private $formusername;
  private $formpassword;
  private $ldap_loc;
  private $ldap_port;

  public function __construct()
  {
    // load crypto library for hashing
    require_once "libraries/pbkdf2.php";
    // if user submitted form process login
    if ($_POST) {
      // reset session details
      $_SESSION['engineerLevel'] = 0;
      $_SESSION['engineerId'] = null;
      $_SESSION['superuser'] = null;
      $_SESSION['engineerHelpdesk'] = null;
      $_SESSION['sAMAccountName'] = null;
      // form inputs
      $explode_username = explode('.',$_POST['username']);
      $localusr = end($explode_username);
      $formusername = $_POST['username'] . "@" . COMPANY_SUFFIX;
      $formpassword = $_POST['password'];
      // check password isnt blank as ldap allows anon login that result in true
      if ($formpassword == "") {
        // throw error
        $error->message = "enter a password";
      } else {
        // process logins
        // check if local logins are allowed and proc
        if (LOCALLOGIN == true) {
          // check if username is local login
          if ($localusr == "local") {
            // query engineers model to get login hash for this login to compare to form inputs
            $engineerModel = new engineerModel();
            $dbUserDetails = $engineerModel->getDetailsByUsername($_POST['username']);
            if ($dbUserDetails) {
              // validate hash vs form input
              if (validate_password($formpassword,$dbUserDetails->localHash) == 1) {
                // valid so setup session with details
                  $_SESSION['sAMAccountName'] = $dbUserDetails->sAMAccountName;
                  $_SESSION['engineerLevel'] = $dbUserDetails->engineerLevel;
                  $_SESSION['engineerId'] = $dbUserDetails->idengineers;
                  $_SESSION['superuser'] = $dbUserDetails->superuser;
                  $_SESSION['engineerHelpdesk'] = $dbUserDetails->helpdesk;
                // log engineer logon
                  $engineerModel->logEngineerAccess($dbUserDetails->idengineers, 1);
                // reroute
                  header('Location: /');
                  exit;
              } else {
                // throw error
                $error->message = "please check your password";
              }
            }
          }
        }
        // process ldap login
        // connect to ldap using php-ldap
        $ldap_loc = LDAP_SERVER;
        $ldap_port = 389;
        $ldap = ldap_connect($ldap_loc, $ldap_port) or die("Could not connect to LDAP server.");
          if ($ldap) {
            // bind to ldap server
            $ldapbind = ldap_bind($ldap, $formusername, $formpassword);
              //verify binding
              if ($ldapbind) {
                // bind succesful authenticate username
                  // check if they are enginner and populate if they are
                $engineerModel = new engineerModel();
                $dbUserDetails = $engineerModel->getDetailsByUsername($_POST['username']);
                  if ($dbUserDetails) {
                    $_SESSION['sAMAccountName'] = $dbUserDetails->sAMAccountName;
                    $_SESSION['engineerLevel'] = $dbUserDetails->engineerLevel;
                    $_SESSION['engineerId'] = $dbUserDetails->idengineers;
                    $_SESSION['superuser'] = $dbUserDetails->superuser;
                    $_SESSION['engineerHelpdesk'] = $dbUserDetails->helpdesk;
                    // log engineer logon
                    $engineerModel->logEngineerAccess($dbUserDetails->idengineers, 1);
                    // update engineer status
                    $engineerModel->updateEngineerStatus($dbUserDetails->idengineers, 1);
                    // reroute
                      isset($_SESSION['entrypoint']) ? header('Location: ' . $_SESSION['entrypoint'] ) : header('Location: /');
                      exit;
                  } else {
                    // assume user isnt engineer
                    $_SESSION['sAMAccountName'] = $_POST['username'];
                    // reroute
                      isset($_SESSION['entrypoint']) ? header('Location: ' . $_SESSION['entrypoint'] ) : header('Location: /');
                      exit;
                  }
              } else {
                // bind failed
                $error->message = "Password incorrect, account locked, or user does not exist";
              }
          }
      // end process logins
      }
    }
    // render page
    require_once "views/loginView.php";
  }

}
