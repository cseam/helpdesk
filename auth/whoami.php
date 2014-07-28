<?php
//set cookie to username so engineer forms know who you are 
// thinking of using apache ntml mod to auth set session var then redirect for dev going to set cookie i can check
// for testing this is a static engineer id but would lookup in db from ntml
setcookie("engineerid", "8", time()+3600, "/");
Header("Location: http://localhost:8888/helpdesk/");
?>