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
      function setSelect(index){
          //document.getElementById("myText").select();
         var idelement = 'id_updated_' + index.toString();
          document.getElementById(idelement).value = '1';
        
      }
      function update(){
          alert('update');
      }
      function isNumberKey(evt, index){
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          var idelement = 'id_updated_' + index.toString();
       
          document.getElementById(idelement).value = '1';
       
          if ( ((charCode >= 48) && (charCode <= 57)) || (charCode == 46))
              return true;
          return false;
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
      <h3 align="center">Juiz: <strong><?php echo $name; ?></strong></h3>
      <h3 align="center"><?php echo $username; ?></h3>

         <br>
         <hr>
         <button type="button" onclick="update();">Update</button> 
         <?php
           //$sql = 'SELECT submission.*,problem.name  FROM submission INNER JOIN problem ON problem.id = submission.problem_id ORDER by submission.moment DESC;';
           $sql = 'SELECT login.username, submission.*,problem.name  FROM submission  INNER JOIN problem ON problem.id = submission.problem_id  INNER JOIN login ON login.id = submission.user_id  ORDER by submission.moment DESC;';
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
               echo '<tr bgcolor="'. $bgColor .'" > <th>' . $row['id'] .  '</th><th> ' .  $row['username'] . '</th><th> ' . date( 'd/m/Y H:i:s', $phpdate ) . ' </th><th> ' . $row['name'] . ' </th> <th> ';
//               echo $row['answer'] ;
               $answers = array( 'accepted' , 'wrong answer', 'runtime error', 'compilation error', 'pending');
               echo '<select id="id_answser_' . ($index-1) . '" onchange="setSelect(' . ($index-1) . ')">>';
               for ($i = 0; $i < 5; $i++){
                  $selected = '';
                  if ( $answers[$i] == $row['answer'] )
                    $selected = 'selected ';
                  echo '<option value="' . $answers[$i] . '"  '. $selected .' >' . $answers[$i]  . '</option>';
               }
              echo '</select>';
               // <option value="accepted">accepted</option> <option value="wrong answer" selected>wrong answer</option> <option value="runtime error">runtime error</option> <option value="compilation error">compilation error</option> <option value="pending">pending</option></select>';
               echo ' </th> <th> ' . number_format($row['score'] , 3, '.', ','). ' </th>';
               echo ' </th> <th> <input type="text" id="id_elapsedtime_'.  ($index - 1) .'" value="' . number_format($row['elapsedtime'] , 5, '.', ','). '" maxlength="20" size="22" onkeypress="return isNumberKey(event, '. ($index - 1) .')" > </th> <th> <input type="hidden" id="id_updated_' . ($index-1) . '"  name="numberrow" value="0"> </th> </tr>';
               $index++;
             }//end-if($row = $result->fetch_assoc()) {

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
