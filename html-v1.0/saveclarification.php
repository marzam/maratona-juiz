<?php
  include 'vars.php';
  include 'db.php';
  $result   =checkLoginTeam();
  //$result   = execQuery($sql);


  if ($result->num_rows > 0) {
    if($row = $result->fetch_assoc()) {
      $username = $row['username'];
      $name     = $row['name'];
      $team     = $row['team'];
      $team_id  = $row['team_id'];
      $id = $row['id'];
    }//end-if($row = $result->fetch_assoc()) {
  }//end-if ($result->num_rows > 0) {

  $doubt      = $_POST['id_doubt'];
  $user_id    = $_POST['id_user'];

  $username = 'desconhecido';
  $name     = 'desconhecido';
  $sql      = 'SELECT username, name FROM login WHERE id = "' . $id . '"; ';
  $result   = execQuery($sql);
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $name     = $row['name'];
      }//end-if($row = $result->fetch_assoc()) {
  }//end-if ($result->num_rows > 0) {


  $sql = 'INSERT INTO clarification (user_id, team_id, doubt) VALUES ('. $user_id .', '. $team_id .',"'. $doubt .'");';
  $result   = execQuery($sql);
  //echo $sql . '<br>';
  echo ' <script type="text/javascript"> window.open("clarification.php", "_self"); </script>';
?>
