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

  $sql = 'INSERT INTO submission (user_id, problem_id, moment, file, score) VALUES ("' . $user_id . '", "' . $prob_id . '", "' . $curr . '", "' . $target_dir . $target_file . '", "'. $score .'");';
  $result = execQuery($sql);
//  echo $sql .'<br><br>' . $result . '<br>';

//  echo 'target  file:' . $target_file . '<br>';
//  echo 'source file:'  . basename($_FILES["fileToUpload"]["name"]) . '<br>';

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
    <div>
      <h1 align="center"> <?php echo $eventTitle1; ?> </h1>
      <h1 align="center"> <?php echo $eventTitle2; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle;  ?> </h2>

    </div>
    <div class="loginborda" >
      <?php
      if ((move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) && ($result == 1)) {
        echo '<br><br>';
        echo '<h3  align="left"> <strong>Arquivo</strong>:'. basename($_FILES["fileToUpload"]["name"]). '</h3>';
        echo '<br>';
        echo '<h3  align="center"><a href="javascript:window.open(\'mainteam.php\', \'_self\');"> Submissão realizada com sucesso! </a></h2>';

        //echo '<script>';
        //echo 'window.open("mainteam.php","_self")';
        //echo '</script>';
      }else{
        echo '<br><br><br><br>';
        echo '<h2>Houve um erro na submissão <a href="javascript:window.open(\'mainteam.php\', \'_self\');"> Tente novamente</a> </h2>';
      }
      ?>
    </div>
  </body>
</html>
