<?php
//set cookie to username so engineer forms know who you are 
// for testing this is a static engineer id in this case 8 but in production would use ntml or login to set id
setcookie("engineerid", "8", time()+3600, "/");

// need to write code to set id using ntml or email login form.

?>