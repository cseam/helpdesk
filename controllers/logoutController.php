<?php

class logoutController {
  public function __construct()
  {
    // process Logouts
      // update engineers status as out
        //TODO create model for enginners and logout method
      // update engineer punchcard with date and time stamp
        //TODO create update punchcard method
      // get some stats to show on logout page
        //TODO create stats method
      // destory existing sessions
      session_destroy();
      // render page
    require_once "views/logoutView.php";
  }

}
