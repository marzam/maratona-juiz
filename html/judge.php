<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
function execQuery($mysql){
    $servername = "localhost";
    $username   = "localuser";
    $password   = "localuser";

    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
       die('ERROR: ' . $conn->error);
       return;
    }

    if (!$conn->set_charset("utf8")) {
        die('ERROR: ' . $conn->error);
        return;
    }


    $sql = "USE dbMaratona;";
    $result = $conn->query($mysql);
    $conn->close();
    return $result;
}
if(!isset($_COOKIE['login'])) {
    header("index.php");
} else {
  echo "Value is: " . $_COOKIE['login'];
}

/*
  $sql = 'SELECT name FROM login WHERE username = "' . $user . '" AND password = "' . $passwd . '";';
  $result = execQuery($sql);
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        setcookie('login', $row['id'], time() + (60*60*24*1000);
        if ($row['type'] == '1'){//Judge
           header("judge.php");
        }
      }//end-if($row = $result->fetch_assoc()) {

  }//end-if ($result->num_rows > 0) {
  else{
    readfile("loginerror.html");
    //echo 'Usuário não cadastrado'

  }
*/

?>
