<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
  include 'db.php';
  $user   = $_POST['nameLogin'];
  $passwd = $_POST['namePassed'];
  $sql = 'SELECT id,type FROM login WHERE username = "' . $user . '" AND password = "' . $passwd . '";';
  $result = execQuery($sql);


  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {

        if ($row['type'] == '0'){//Judge
          setcookie('login-judge', $row['id'], time() + (60*60*24*1000));
          echo '<script>';
          echo 'window.open("mainjudge.php","_self")';
          echo '</script>';
        }else if ($row['type'] == '1'){//team
          //echo 'team<br>'  ;
          setcookie('login-team', $row['id'], time() + (60*60*24*1000));
          echo '<script>';
          echo 'window.open("mainteam.php","_self")';
          echo '</script>';

           //readfile("mainteam.php");
        }else {
          echo 'Outros casos... <hr>';;
        }

      }//end-if($row = $result->fetch_assoc()) {

  }//end-if ($result->num_rows > 0) {
  else{
    //readfile("loginerror.html");
    echo 'Usuário não cadastrado';
    echo 'type: ' . $row['type'] . '<hr>' ;
  }


?>
