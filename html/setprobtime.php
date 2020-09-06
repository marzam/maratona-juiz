<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
  include 'db.php';
  $user    = $_POST['nameLogin'];
  $passwd  = $_POST['namePassed'];
  $prob_id = $_POST['prob_id'];
  $time    = $_POST['time'];
  nodelogin($user, $passwd);

  $sql = 'UPDATE problem SET time = "'. $time .'" WHERE id = "'. $prob_id .'"';
  $result = execQuery($sql);
  if ($result != NULL)
    echo 'Ok' . PHP_EOL;
  else
    echo 'ERROR: ' . $sql . PHP_EOL;
?>
