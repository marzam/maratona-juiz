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
              data.setAttribute('id', recID);
              data.setAttribute('answer', recAnswer);
              data.setAttribute('elapsedtime', recElapsedtime);
              record.appendChild(data);
              //alert('Registro: ' + recID + '\n' + recAnswer + '\n' + recElapsedtime);
              //alert('Atualizado em:' + i.toString());
            }//end-if (opt == '1'){
              
          }//end-for (var i = 0; i < mIndex; i++){
          doc.appendChild(record);
          if (flag == 1){
              var xmlHttp = new XMLHttpRequest();
              //          xmlHttp.open("POST", "http://192.168.1.21/toupdatesubmmity.php", true); // true for asynchronous
              xmlHttp.open("POST", "toupdatesubmmity.php", true); // true for asynchronous
              xmlHttp.setRequestHeader('Content-type', 'application/xml; charset=utf-8');
              var myXML = new XMLSerializer();
              var msg = myXML.serializeToString(doc);
              xmlHttp.send(msg);
              window.history.back();
          }else{
            alert('Não existe registros para serem atualizados!');
          }
          
          //alert("fim");

          
      }
      function isNumberKey(evt, index){
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          var idelement = 'id_updated_' + index.toString();
       
          document.getElementById(idelement).value = '1';
       
          if ( ((charCode >= 48) && (charCode <= 57)) || (charCode == 46))
              return true;
          return false;
      }

      function mySubmit(id){
            document.getElementById("id_id").value = id;
            document.getElementById('listForm').submit();
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
        <form action="addproblem.php"  method="post" enctype="multipart/form-data" id="listForm">
            <br>
            <hr>
            <!-- <button type="button" onclick="updateSendXML();">Update</button>  -->
            <?php
                //$sql = 'SELECT submission.*,problem.name  FROM submission INNER JOIN problem ON problem.id = submission.problem_id ORDER by submission.moment DESC;';

                $sql = 'SELECT * from problem;';
                $result   = execQuery($sql);
                if ($result->num_rows > 0) {
                    echo '<h1 align="center"> Problemas cadastrados </h1>';
                    echo '<table border="0" style="width:100%;">';
                    echo '<tr  bgcolor="#afafaf"> <th>ID</th> <th>Nome</th> <th>Tempo (s)</th> <th>Visível</th> <th>Saída</th></tr>';
                    $index = 1;
                    while($row = $result->fetch_assoc()) {
                        $bgColor = '#dfdfdf';
                        if (($index % 2) == 0)
                        $bgColor = '#d0d0d0';

        // <a align="left" href="javascript:history.back()"> Voltar </a>
                    echo '<tr bgcolor="'. $bgColor .'" > <th>' . $row['id'] .  '</th><th>  <a href="javascript:mySubmit(' . $row['id'] .  ')">' .  $row['name'] . '</a></th><th> ' .  number_format($row['time'] , 5, '.', ',') . ' </th><th> ' . $row['visible'] . ' </th><th> ' . $row['stdout'] . ' </th>';

        //               echo '<tr bgcolor="'. $bgColor .'" > <th>' . $row['id'] .  '</th><th>  <a href="#" onclick="document.getElementById('myForm').submit();">Submit</a>' .  $row['name'] . '</th><th> ' . $row['time'] . ' </th><th> ' . $row['visible'] . ' </th><th> ' . $row['stdout'] . ' </th>';

                    $index++;
                    }//end-if($row = $result->fetch_assoc()) {
                    echo '</table>';
                    echo '<br>';
                    echo '<input type="hidden" id="id_id"  name="id_id" value="-1">';
        //             echo '<input type="hidden" id="id_index_value"  name="numberrow" value="' . ($index-1) . '">';
                }//end-
            ?>
        </form>
    </div>


  </body>
</html>