<?php
  include 'vars.php';
  include 'db.php';
  $id       = $_COOKIE['login-team'];
  $username = 'desconhecido';
  $name     = 'desconhecido';
  $sql      = 'SELECT username, name FROM login WHERE id = "' . $id . '"; ';
  $result   = execQuery($sql);
  $logged   = 0;
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $name     = $row['name'];
        $logged  = 1;
       
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

    
      <?php
        $ret = getContinue($deadlinescore);
        echo '<div style="border: 2px solid #dadada; background-color: #dadada; height: 100px; width: 600px; border-radius: 8px; margin-left: auto; margin-right: auto;">';
        if( $logged  == 1){
          echo '<a align="left" href="javascript:history.back()"> Voltar </a>';
          echo '<h3 align="center">Equibe: <strong>' . $name. '</strong></h3>';
          echo '<h3 align="center">' . $username . '</h3>';
          /*
          if ($ret == 1){
            echo '<div style="border: 2px solid #dadada; background-color: #dadada; height: 100px; width: 600px; border-radius: 8px; margin-left: auto; margin-right: auto;">';
            echo '<a align="left" href="javascript:history.back()"> Voltar </a>';
            echo '<h3 align="center">Equibe: <strong>' . $name. '</strong></h3>';
            echo '<h3 align="center">' . $username . '</h3>';
          }else
            echo '<div style=" height: 150px; width: 100px; border-radius: 8px; margin-left: auto; margin-right: auto;">';
          */
        }
        if ($ret == 1){
          echo '<br>';
          simpleScoreTable();
          echo '<br> </div>';
        }else{
          //echo '<div style=" height: 150px; width: 100px; border-radius: 8px; margin-left: auto; margin-right: auto;">';  
            echo '<div><h3 align="center"> Score suspenso até o fim evento ! <span style="font-size:100px;align:center;">&#129296;</span> </h3> </div>';
            //echo '<span style="font-size:100px;align:center;">&#129296;</span>';
            echo '<br> <hr>';
        }
        
      ?>
    

  </body>
</html>

