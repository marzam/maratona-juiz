<?php
  include 'vars.php';
  include 'db.php';
  $result   =checkLoginTeam();
  //$result   = execQuery($sql);


  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $name     = $row['name'];
        $team     = $row['team'];
        $id       = $_COOKIE['login-team'];
      }//end-if($row = $result->fetch_assoc()) {
  }//end-if ($result->num_rows > 0) {
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
     <script type="text/javascript">
      function onSubmit(){
         alert("Submit");
       }
       function onClear(){
           document.getElementById("id_doubt").value = "";
        }
     </script>
  </head>
  <body>
    <div>
      <h1 align="center"> <?php echo $eventTitle1; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle; ?> </h2>
    </div>

    <div style="border: 2px solid #dadada; background-color: #dadada; height: 100px; width: 600px; border-radius: 8px; margin-left: auto; margin-right: auto;">
      <a align="left" href="javascript:history.back()"> Voltar </a>
      <h3 align="center">Equibe: <strong><?php echo $team; ?></strong></h3>
      <h3 align="center">Username:<?php echo $username ;  ?></h3>

      <br>
           <h1 align="center"> Esclarecimento </h1>
           <table border="4">
             <colgroup>
                <col style="width:50%;">
                <col style="width:50%;">
             </colgroup>
             <?php

               $sql = 'SELECT doubt, answer FROM clarification WHERE user_id = '. $id . ' ORDER BY datetime DESC;';
               $result   = execQuery($sql);
               if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                    echo '<tr> <th  align="justify">' . $row['doubt'] .  '</a> </th> <th align="justify"> ' . $row['answer'] . ' </th>  </tr>';

                 }//end-if($row = $result->fetch_assoc()) { 

               }//end-if ($result->num_rows > 0) {
             ?>
           </table>
           <br>
           <form action="saveclarification.php"  method="post">
             <?php echo '<input type="hidden" id="id_user" name="id_user" value="'. $id . '">'; ?>
             <textarea id="id_doubt" rows = "5" cols = "82"  maxlength = "2048"  name = "id_doubt"  style="resize: none;"></textarea><br>
             <input id="id_submit" type="submit" value="Enviar">
             <!-- <button  type="button" onclick="onSubmit();">Enviar</button> -->
             <button id="id_clear" type="button" onclick="onClear();">Limpa</button>

           </form>


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
