<?php
  include 'vars.php';
  include 'db.php';
  $result   =checkLoginJudge();
  //$result   = execQuery($sql);


  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $name     = $row['name'];
        $team     = $row['team'];
      }//end-if($row = $result->fetch_assoc()) {
  }//end-if ($result->num_rows > 0) {ssoc()) {
  else{
    echo ' <script type="text/javascript"> window.open("login.php", "_self"); </script>';
  }
  
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
      <a align="left" href="javascript:history.back()"> Voltar </a>
      <h3 align="center">Equipe: <strong><?php echo $team; ?></strong></h3>
      <h3 align="center">Usuário: <?php echo $username; ?></h3>
      <br>

        <?php simpleScoreTable(); ?>
      <br>
    </div>

  </body>
</html>
