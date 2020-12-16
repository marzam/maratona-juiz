<?php
  include 'vars.php';
  include 'db.php';

  $id       = $_COOKIE['login-team'];
  $username = 'desconhecido';
  $name     = 'desconhecido';
  $sql      = 'SELECT * FROM login WHERE id = "' . $id . '"; ';

  $result   = execQuery($sql);

  if (($result->num_rows > 0) || (!filter_var($_POST['id_email'], FILTER_VALIDATE_EMAIL))) {
    $sql = 'UPDATE login SET name="' . $_POST['id_name'] . '", username="'. $_POST['id_login'] .'", password="'. md5($_POST['id_passwA']) .'", email="' . $_POST['id_email'] .'"  WHERE id = "'. $id .'";';
    //echo $sql;

    $result   = execQuery($sql);

    echo '<script>';
    echo 'window.open("mainteam.php","_self")';
    echo '</script>';

  }
?>
