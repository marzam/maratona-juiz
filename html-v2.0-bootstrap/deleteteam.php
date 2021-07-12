<?php

  include 'vars.php';
  include 'p-judge-lib.php';
  $team_id     = $_COOKIE['delete_team'];

  $result   = checkLoginJudge();
  if ($result == 0) echo '<script type="text/javascript"> window.open("login.php", "_self"); </script>';

  //$sql = 'SELECT id,team_id, type, username, fasscess FROM login WHERE username = "' . $user . '" AND password = "' . md5($passwd) . '";';
  $sql = 'DELETE FROM teams WHERE ID=' . $team_id . ';' ;
  $result = execQuery($sql);
  echo '<script> window.open("addteam.php","_self") </script>';

?>
