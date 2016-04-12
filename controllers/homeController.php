<?php

class homeController {
  public function __construct()
  {
    // Route to default landing page depending on engineer level.
    SWITCH ($_SESSION['engineerLevel']) {
      CASE 2:
        header('Location: /manager');
        exit;
      CASE 1:
        header('Location: /engineer');
        exit;
      DEFAULT:
        header('Location: /user');
        exit;
    }
  }

}
