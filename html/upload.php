<?php
  include 'vars.php';
  include 'db.php';

  $zeros    = '00000000000';
  $user_id  = $_COOKIE['login-team'];
  $prob_id  = $_POST['cmbProblem'];
  $username = 'desconhecido';
  $name     = 'desconhecido';

  $lid         = substr($zeros . $user_id, -strlen($zeros));
  $problem     = substr($zeros . $prob_id, -strlen($zeros));
  $curr        = date('Y-m-d-H-i-s');
  $target_dir  = "uploads/";
  $target_file = str_replace(' ', '', $lid . '-' .  $problem . '-' . $curr . '.tar.gz');
  $score       = '1';

  $sql = 'INSERT INTO submission (user_id, problem_id, moment, file, score) VALUES ("' . $user_id . '", "' . $prob_id . '", "' . $curr . '", "' . $target_file . '", "'. $score .'");';
  $result = execQuery($sql);
//  echo $sql .'<br><br>' . $result . '<br>';

//  echo 'target  file:' . $target_file . '<br>';
//  echo 'source file:'  . basename($_FILES["fileToUpload"]["name"]) . '<br>';

  if ((move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) && ($result == 1)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }


?>
