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
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
     <script type="text/javascript">
      function onSubmit(){
         alert("Submit");
       }
       function onClear(){
           document.getElementById("id_doubt").value = "";
          document.getElementById("id_answerCheck").value = "-1";
        }

        function checkboxClick(obj){

          var obj_id = obj.id;
          var checkbox = document.getElementById(obj_id);
          var checked = checkbox.checked;
          var size = document.getElementById('id_numberrow').value;
          var opt = -1;
          for (i = 1; i <= size; i++){
            var checkid = 'id_check_' + i.toString();
            if ( checkid != obj_id){
              //document.getElementById(checkid)
              document.getElementById(checkid).disabled = checked;
            }//end-if (document.getElementById(checkid) != obj_id){
            else { opt = i; }
          }//end-for (i = 1; i <= size; i++){

          var option = 'id_doubt_' + opt.toString();
          if (checked){
            document.getElementById('id_answerCheck').value = document.getElementById(option).value;

          }else{
            document.getElementById('id_answerCheck').value = '-1';
          }//end-if (checked){
        }//end-function checkboxClick(obj){

     </script>
  </head>
  <body >
    <div>
      <h1 align="center"> <?php echo $eventTitle1; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle; ?> </h2>
    </div>

    <div style="border: 2px solid #dadada; background-color: #dadada; height: 100px; width: 600px; border-radius: 8px; margin-left: auto; margin-right: auto;">
      <a align="left" href="javascript:history.back()"> Voltar </a>
      <h3 align="center">Juiz: <strong><?php echo $name; ?></strong></h3>
      <h3 align="center"><?php echo $username; ?></h3>

      <br>
           <h1 align="center"> Esclarecimento </h1>
           <table border="0">
             <!--
             <colgroup>
                <col style="width:50%;">
                <col style="width:50%;">
             </colgroup>
           -->
             <?php

               $index = 1;
               $sql = 'SELECT id, doubt, answer FROM clarification WHERE answered = "0" ORDER BY datetime ASC;';
               $result   = execQuery($sql);

               if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                   $bgColor = '#dfdfdf';
                   if (($index % 2) == 0)
                    $bgColor = '#d0d0d0';

                   $idopt = 'id_doubt_' . $index;
                   echo '<tr bgcolor="'. $bgColor .'" > <th  align="justify">' . $row['doubt'] .  '</a> </th> <th align="justify">  <input type="hidden" id="' . $idopt . '" name="' . $idopt . '" value="' . $row['id'] . '"> <input type="checkbox" id="id_check_'.$index.'" name="name1" onclick="checkboxClick(this);" />&nbsp; </th>  </tr>';
                  $index += 1;
                 }//end-if($row = $result->fetch_assoc()) {

               }//end-if ($result->num_rows > 0) {
               $index -= 1;
             ?>
           </table>
           <?php
              echo '<input type="hidden" id="id_numberrow" name="numberrow" value="'. $index .'">';
           ?>
           <br>
           <form action="saveclarificationjudge.php"  method="post">
             <?php echo '<input type="hidden" id="id_user" name="id_user" value="'. $id . '">'; ?>
             <textarea id="id_answer" rows = "5" cols = "82"  maxlength = "2048"  name = "id_answer"  style="resize: none;"></textarea><br>
             <input type="hidden" id="id_answerCheck" name="id_answerCheck" value="-1">
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
