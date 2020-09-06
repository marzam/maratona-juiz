<?php
  include 'vars.php';
  include 'db.php';

  $id       = $_COOKIE['login-judge'];
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
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Sistema da UFRRJ - Maratona Paralela</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <script>
      function delete_cookie(cookie_name){
          var cookie_date = new Date ( );  // current date & time
          cookie_date.setTime (cookie_date.getTime() - 1);
          document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
      }
      function logout(){
        delete_cookie('login-team');
         window.open("login.php", "_self");
      }

    </script>
  </head>
  <body>
    <div>
      <h1 align="center"> <?php echo $eventTitle1; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle; ?> </h2>
    </div>
    <hr>
    <div class="loginborda">
      <h3 align="center">Juiz adm.: <strong><?php echo $name; ?></strong></h3>
      <h3 align="center"><?php echo $username; ?></h3>
      <ul>
        <li><a href="judge.html"> Jugar </a></li>
        <li><a href="clarificationjudge.php"> Esclarecer dúvidas </a></li>
        <li><a href="submitjudge.php"> Submissões realizadas </a></li>
        <li><a href="score-judged.php"> Pontuação </a></li>
        <li><a href="javascript:logout()"> Sair </a></li>
      </ul>
    </div>
    <!--
    <div>      <ul>
        <li><a href="problems.html"> Problemas </a></li>        <li><a href="submit.html"> Submissão </a></li>
        <li><a href="clarification.html"> Esclarecimento </a></li>        <li><a href="score.html"> Pontuação </a></li>
        <li><a href="logout.html"> Sair </a></li>      </ul>
    </div>-->

  </body>
</html>
