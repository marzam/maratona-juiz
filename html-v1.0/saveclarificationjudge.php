<?php
  include 'vars.php';
  include 'db.php';
  $id       = $_COOKIE['login-judge'];
  echo 'id: ' . $id;

  $username = 'desconhecido';
  $name     = 'desconhecido';


  echo 'ID: '. $_POST['id_answerCheck'] . '<hr>';
  echo 'Answer: '. $_POST['id_answer'] . '<hr>';

  $sql = 'UPDATE clarification SET answer = "' . $_POST['id_answer'] . '", answered = "1" WHERE id = "' . $_POST['id_answerCheck'] . '";';

  $result   = execQuery($sql);
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $name     = $row['name'];
      }//end-if($row = $result->fetch_assoc()) {
  }//end-if ($result->num_rows > 0) {


  $sql = 'INSERT INTO clarification (user_id, doubt) VALUES ('. $user_id .', "'. $doubt .'");';
  $result   = execQuery($sql);
  //echo $sql . '<br>';
  echo ' <script type="text/javascript"> window.open("clarificationjudge.php", "_self"); </script>';
?>
