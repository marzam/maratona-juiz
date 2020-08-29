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
      <a align="left" href="javascript:history.back()"> Voltar </a>
      <h3 align="center">Equibe: <strong><?php echo $name; ?></strong></h3>
      <h3 align="center"><?php echo $username; ?></h3>

      <br>
           <h1 align="center"> Pontuação </h1>
           <table border="0" style="width:100%;">
             <colgroup>
                <col style="width:80%;">
                <col style="width:20%;">
             </colgroup>
             <?php
               $index = 1;
               $sql = 'SELECT SUM(speedup) as speedup, login.name as team FROM (SELECT MAX(score.speedup) as speedup, problem_id, user_id from score GROUP BY score.user_id, score.problem_id) AS temp INNER JOIN login ON login.id = temp.user_id GROUP BY user_id ORDER BY speedup DESC;';
               $result   = execQuery($sql);
               if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                   $bgColor = '#dfdfdf';
                   if (($index % 2) == 0)
                    $bgColor = '#d0d0d0';

                   echo '<tr bgcolor="'. $bgColor .'" > <th  align="left">' . $row['team'] .  '</a> </th> <th align="right"> ' . $row['speedup'] . ' </th>  </tr>';
                   $index++;

                 }//end-if($row = $result->fetch_assoc()) {

               }//end-if ($result->num_rows > 0) {
             ?>
           </table>
           <br>
    </div>

  </body>
</html>
