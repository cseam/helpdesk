<?php
new authentication();
// check users is authenticated else route to login
class authentication
{
  function __construct()
  {
    // start sessions
    session_start();
    // check session contains authentication info
    if (empty($_SESSION['sAMAccountName'])) {
      // session looks empty route to login page if not already there
        $baseurl = explode('/',$_SERVER['REQUEST_URI']);
        if (!$_POST) {
          // needs some work to stop post to pages other than login working but in principal posts to login need to not reroute
          if (!preg_match("%login%", $baseurl[1])) {
            // reroute
            header('Location: /login/');
            exit;
          }
        }
    }
  }
}
