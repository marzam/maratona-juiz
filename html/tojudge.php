<?php
  include 'vars.php';
  include 'db.php';

  $result   = checkLoginJudge();
  //$result   = execQuery($sql);


  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $name     = $row['name'];
        $team     = $row['team'];
      }//end-if($row = $result->fetch_assoc()) {
  }//end-if ($result->num_rows > 0) {
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
    <script type="text/javascript">
      function readBody(xhr) {
        var data;
        if (!xhr.responseType || xhr.responseType === "text") {
            data = xhr.responseText;
        } else if (xhr.responseType === "document") {
            data = xhr.responseXML;
        } else {
            data = xhr.response;
        }
        return data;
      }
      function setSelect(index){
          //document.getElementById("myText").select();
         var idelement = 'id_updated_' + index.toString();
          document.getElementById(idelement).value = '1';
        
      }
      function updateSendXML(){
          var doc = document.implementation.createDocument("", "", null);
          var record = doc.createElement("record");
          var data = doc.createElement("data");
          
          var mIndex = document.getElementById('id_index_value').value;
          //alert('update:' + mIndex.toString());
          var flag = 0;
          //id_updated_
          for (var i = 0; i < mIndex; i++){
            var id = 'id_updated_' +  i.toString();
            var opt = document.getElementById(id).value;
            var recID = '';
            var recAnswer = '';
            var recElapsedtime = '';
            
            if (opt == '1'){
              flag = 1;
              var data = doc.createElement("data");
              recID           = document.getElementById('id_submissionID_' +  i.toString()).value;
              recAnswer       = document.getElementById('id_answser_' +  i.toString()).value;
              recElapsedtime  = document.getElementById('id_elapsedtime_' +  i.toString()).value;
              recPElapsedtime = document.getElementById('id_p_elapsedtime_' +  i.toString()).value;
              
              recInfo  = document.getElementById('id_info_' +  i.toString()).value;
              data.setAttribute('id', recID);
              data.setAttribute('answer', recAnswer);
              data.setAttribute('elapsedtime', recElapsedtime);
              data.setAttribute('score', (recPElapsedtime / recElapsedtime));
              data.setAttribute('info', recInfo);
              record.appendChild(data);
              //alert('Registro: ' + recID + '\n' + recAnswer + '\n' + recElapsedtime);
              //alert('Atualizado em:' + i.toString());
            }//end-if (opt == '1'){
              
          }//end-for (var i = 0; i < mIndex; i++){
          doc.appendChild(record);
          if (flag == 1){
              var xmlHttp = new XMLHttpRequest();
              //          xmlHttp.open("POST", "http://192.168.1.21/toupdatesubmmity.php", true); // true for asynchronous
             // alert("fim");
             xmlHttp.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                  console.log(readBody(xmlHttp));
                }
              }
              xmlHttp.open("POST", "toupdatesubmmity.php", true); // true for asynchronous
              
              xmlHttp.setRequestHeader('Content-type', 'application/xml; charset=utf-8');
              var myXML = new XMLSerializer();
              var msg = myXML.serializeToString(doc);
              //alert(msg);
              var ret = xmlHttp.send(msg);
              alert('Atualizado com sucesso');
              //window.history.back();
          }else{
            alert('Não existe registros para serem atualizados!');
          }
          
          

          
      }
      function isNumberKey(evt, index){
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          var idelement = 'id_updated_' + index.toString();
       
          document.getElementById(idelement).value = '1';
       
          if ( ((charCode >= 48) && (charCode <= 57)) || (charCode == 46))
              return true;
          return false;
      }

      function pInfo(index){
        var info_id  = 'id_info_' + index.toString();
        var info_text = document.getElementById(info_id).value;
        var output = prompt("info:", info_text);
        document.getElementById(info_id).value = output;
        var idelement = 'id_updated_' + index.toString();
        document.getElementById(idelement).value = '1';



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
      <h3 align="center">Equipe: <strong><?php echo $team; ?></strong></h3>
      <h3 align="center">Usuário: <?php echo $username; ?></h3>

         <br>
         <hr>
         <button type="button" onclick="updateSendXML();">Update</button> 
         <?php
           //$sql = 'SELECT submission.*,problem.name  FROM submission INNER JOIN problem ON problem.id = submission.problem_id ORDER by submission.moment DESC;';
           $sql = 'SELECT login.username, submission.*,problem.name, problem.time  FROM submission  INNER JOIN problem ON problem.id = submission.problem_id  INNER JOIN login ON login.id = submission.user_id  ORDER by submission.moment DESC;';
           $result   = execQuery($sql);
           if ($result->num_rows > 0) {
             echo '<h1 align="center"> Submissões realizadas </h1>';
             echo '<table border="0" style="width:100%;">';
             $index = 1;
             while($row = $result->fetch_assoc()) {
                 $bgColor = '#dfdfdf';
                 if (($index % 2) == 0)
                   $bgColor = '#d0d0d0';
               $phpdate = strtotime( $row['moment'] );
//               echo '<tr bgcolor="'. $bgColor .'" > <th>' . $row['id'] .  '</th><th> ' .  $row['username'] . '</th><th> ' . date( 'd/m/Y H:i:s', $phpdate ) . ' </th><th> ' . $row['name'] . ' </th> <th> ' . $row['answer'] . ' </th> <th> ' . number_format($row['score'] , 5, '.', ','). ' </th> </tr>';
//               echo '<tr bgcolor="'. $bgColor .'" > <th>' . $row['id'] .  '</th><th> ' .  $row['username'] . '</th><th> ' . date( 'd/m/Y H:i:s', $phpdate ) . ' </th><th> ' . $row['name'] . ' </th> <th> ';
                echo '<tr bgcolor="'. $bgColor .'" > <th><a href="' . $row['file'] . '">' . $row['id'] .  '</a> </th> <th> ' .  $row['username'] . '</th><th> ' . date( 'd/m/Y H:i:s', $phpdate ) . ' </th><th> ' . $row['name'] . ' </th> <th> ';
//               echo $row['answer'] ;
               $answers = array( 'accepted' , 'wrong answer', 'runtime error', 'compilation error', 'pending', 'submitted file corrupted', 'time out');
               echo '<select id="id_answser_' . ($index-1) . '" onchange="setSelect(' . ($index-1) . ')">>';
               for ($i = 0; $i < 7; $i++){
                  $selected = '';
                  if ( $answers[$i] == $row['answer'] )
                    $selected = 'selected ';
                  echo '<option value="' . $answers[$i] . '"  '. $selected .' >' . $answers[$i]  . '</option>';
               }
              echo '</select>';
               // <option value="accepted">accepted</option> <option value="wrong answer" selected>wrong answer</option> <option value="runtime error">runtime error</option> <option value="compilation error">compilation error</option> <option value="pending">pending</option></select>';
               echo '</th><th> <a href="javascript:pInfo('.  ($index - 1) .');"> info </a> <input type="hidden" id="id_info_'.  ($index - 1) .'" name="numberrow" value="'.   $row['info'] .'"> </th>';
               echo '<th> ' . number_format($row['score'] , 3, '.', ','). ' </th>';
               echo ' </th> <th> <input type="text" id="id_elapsedtime_'.  ($index - 1) .'" value="' . number_format($row['elapsedtime'] , 5, '.', ','). '" maxlength="20" size="10" onkeypress="return isNumberKey(event, '. ($index - 1) .')" > <input type="text" id="id_p_elapsedtime_'.  ($index - 1) .'" value="' . number_format($row['time'] , 5, '.', ','). '" size="10" readonly> </th> <th> <input type="hidden" id="id_updated_' . ($index-1) . '"  name="numberrow" value="0"> <input type="hidden" id="id_submissionID_'.  ($index - 1) .'" name="numberrow" value="'.   $row['id'] .'"> </th> </tr>';
               $index++;
             }//end-if($row = $result->fetch_assoc()) {
             echo '</table>';
             echo '<br>';
             echo '<input type="hidden" id="id_index_value"  name="numberrow" value="' . ($index-1) . '">';
           }//end-
         ?>

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
