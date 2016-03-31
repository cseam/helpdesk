<?php
// TODO ALL THE THINGS

// Process Logouts
echo ("\n-- Starting Process Logouts : "). date("h:i:s") . "\n";
  // TODO logout all engineers so when cron is run at 1am all users are logged out
  // List users logged in
  echo ("* Engineers still logged in \n");
  $STH = $DBH->Prepare("
            SELECT *
            FROM engineers_punchcard a1
            inner join
            (
              select max(stamp) as max
              from engineers_punchcard
              group by engineerid
            ) a2
            on a1.stamp = a2.max
            WHERE direction =1
            ");
  //$STH = $DBH->Prepare("SELECT * FROM engineers_punchcard GROUP BY engineerid ORDER BY id DESC");
  $STH->setFetchMode(PDO::FETCH_OBJ);
  $STH->execute();
  if ($STH->rowCount() == 0) { echo "0 engineers logged in\n";};
    while($row = $STH->fetch()) {
      // auto logout each engineer and stamp db so managment know it was a auto logout
      $STHloop = $DBH->Prepare("INSERT INTO engineers_punchcard (engineerid, direction, stamp, note) VALUES (:id, '0', :date, 'auto logout')");
      $STHloop->bindParam(":id", $row->engineerid, PDO::PARAM_INT);
      $STHloop->bindParam(":date", date("c"), PDO::PARAM_STR);
      $STHloop->execute();
      echo("auto logged out " . engineer_friendlyname($row->engineerid)) . "\n";
    }
echo ("\n-- Ending Process Logouts : "). date("h:i:s") . "\n";
