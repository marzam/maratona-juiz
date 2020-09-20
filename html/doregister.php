<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
  include 'db.php';
  echo $_POST['id_name']  . '<br>';
  echo $_POST['id_login']  . '<br>';
  echo $_POST['id_passwA']  . '<br>';
  echo $_POST['id_aux']  . '<br>';
  echo $_POST['id_email']  . '<br>';
  //clear cookie
  setcookie('register', '', time() - 3600, '/'); // empty value and old timestamp
  //SELECT id FROM login WHERE username = "mzamith1" OR email = 'mzamith@hotmail.com';
  $sql = 'SELECT id FROM login WHERE username = "' . $_POST['id_login'] . '" OR email = "' . $_POST['id_email'] . '";';
  //echo '> ' . $sql . '<br>';
  $result   = execQuery($sql);

  if (($result->num_rows > 0) || (!filter_var($_POST['id_email'], FILTER_VALIDATE_EMAIL))) {
    $text = $_POST['id_name'] . ';' . $_POST['id_login'] . ';' . $_POST['id_email'];
    setcookie('register', $text); // empty value and old timestamp
    echo ' <script type="text/javascript"> window.open("register.php", "_self"); </script>';
  }//end-if ($result->num_rows > 0) {
  else{
    $sql = 'INSERT INTO login (name, username, password, email, type) VALUES ("' . $_POST['id_name'] . '","'. $_POST['id_login'] .'", "'. md5($_POST['id_passwA']) .'","' . $_POST['id_email'] .'","1");';
    $result   = execQuery($sql);
    $sql = 'SELECT id,type FROM login WHERE username = "' . $_POST['id_login'] . '" AND password = "' . md5($_POST['id_passwA']) . '";';
    $result = execQuery($sql);

    if ($result->num_rows > 0) {
        if($row = $result->fetch_assoc()) {
            setcookie('login-team', $row['id'], time() + (60*60*24*1000));
            echo '<script>';
            echo 'window.open("mainteam.php","_self")';
            echo '</script>';
          }
    }
  }
?>
