<?php
include 'db.php';
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
//------------------------------------------------------------------------------
function accepted($id, $prob_id, $ptime, $speedup){
  $sql = 'SELECT time FROM problem WHERE id = " '. $prob_id .' ";';
  $result = execQuery($sql);
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
          $stime =  $row['time'];
          $speedup = $stime / $ptime;
          if ($speedup < 1.0)
            $speedup = 1.0;
  //Accepted
          echo '***Speedup: ' . $speedup . PHP_EOL;
          $sql = 'UPDATE submission SET elapsedtime = "'. $ptime .'",  score ="'. $speedup .'", answer="accepted"  WHERE id="'. $id .'"';
          $result = execQuery($sql);
          if ($result != NULL)
            echo 'PHP Ok' . PHP_EOL;
          else
            echo 'PHP ERROR: ' . $sql . PHP_EOL;
      }
  }
}
//------------------------------------------------------------------------------
function compilitionError($id, $answer){
  echo '***compiling error ' . PHP_EOL;
  $sql = 'UPDATE submission SET answer="'. $answer .'"  WHERE id="'. $id .'"';
  $result = execQuery($sql);
  if ($result != NULL)
    echo 'PHP Ok' . PHP_EOL;
  else
    echo 'PHP ERROR: ' . $sql . PHP_EOL;

}
//------------------------------------------------------------------------------

  $user    = $_POST['nameLogin'];
  $passwd  = $_POST['namePassed'];
  $id = $_POST['id'];
  $prob_id = $_POST['prob_id'];
  $ptime   = $_POST['time'];
  $answer  = $_POST['answer'];

/*
  echo 'PHP user  : ' . $user .  PHP_EOL;
  echo 'PHP paswd : ' . $passwd .  PHP_EOL;
  echo 'PHP answer: ' . $answer .  PHP_EOL;
*/
  nodelogin($user, $passwd);
/*
  echo '$ptime: ' . $ptime . PHP_EOL;
  echo '$id: '    . $id . PHP_EOL;
  echo '$prob_id: ' . $prob_id . PHP_EOL;
*/
  if ($answer == 'accepted')
    accepted($id, $prob_id, $ptime, $speedup);
  else{
    echo $answer . PHP_EOL;
    compilitionError($id, $answer);
  }

?>
