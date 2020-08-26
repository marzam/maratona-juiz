<?php
  include 'vars.php';
  include 'db.php';

  $id       = $_COOKIE['login-team'];
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
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
    <div>
      <h1 align="center"> <?php echo $eventTitle1; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle; ?> </h2>
    </div>

    <div style="border: 2px solid #dadada; background-color: #dadada; height: 100px; width: 600px; border-radius: 8px; margin-left: auto; margin-right: auto;">
      <h3 align="center">Equibe: <strong><?php echo $name; ?></strong></h3>
      <h3 align="center"><?php echo $username; ?></h3>
      <br>
           <h1 align="center"> Lista de problemas </h1>
           <table border="4">
             <colgroup>
                <col style="width:20%;">
                <col style="width:80%;">
             </colgroup>

             <?php
               $sql = 'SELECT * FROM problem ORDER BY name;';
               $result   = execQuery($sql);
               if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                    echo '<tr> <th> <a href="' . $row['path'] . '">' . $row['name'] .  '</a> </th> <th align="justify"> ' . $row['description'] . ' </th>  </tr>';

                 }//end-if($row = $result->fetch_assoc()) {

             }//end-if ($result->num_rows > 0) {
             ?>
           </table>
    </div>
<!--
    <div>
      <ul>
        <li><a href="problems.html"> Problemas </a></li>
        <li><a href="submit.html"> Submissão </a></li>
        <li><a href="clarification.html"> Esclarecimento </a></li>
        <li><a href="score.html"> Pontuação </a></li>
        <li><a href="logout.html"> Sair </a></li>
      </ul>
    </div>
-->
  </body>
</html>
