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
           <h1 align="center"> Submissão: </h1>
           <form action="upload.php" method="post" enctype="multipart/form-data">
              <label for="problem" style="font-weight:bold">Selecione o problema:</label>
              <select name="cmbProblem" id="id_cmbProblem">
              <?php
                   $sql = 'SELECT * FROM problem ORDER BY name;';
                   $result   = execQuery($sql);
                   if ($result->num_rows > 0) {
                     while($row = $result->fetch_assoc()) {
                        //echo '<tr> <th> <a href="' . $row['path'] . '">' . $row['name'] .  '</a> </th> <th align="justify"> ' . $row['description'] . ' </th>  </tr>';
                       echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option> ';
                     }//end-if($row = $result->fetch_assoc()) {

                 }//end-if ($result->num_rows > 0) {
             ?>
            </select>
            <br><br>
            <!--
            <label for="problem" style="font-weight:bold">Selecione a arquitetura:</label>
              <select name="cmbarchitecture" id="id_cmbarchitecture">
              <option value="C" selected>CPU - OpenMP/pThread</option> 
              <option value="C">GPU - CUDA</option> 
              
            </select>
            <br><br>
            -->
            <label for="problem" style="font-weight:bold">Selecione o arquivo: </label>
            <input type="file"  accept=".tar.gz" name="fileToUpload" id="fileToUpload">
            <br><br>
            <div align="center"><input type="submit" value="Enviar código" name="submit"></div>
         </form>
         <br>
         <hr>
         <?php
           $sql = 'SELECT submission.*,problem.name  FROM submission INNER JOIN problem ON problem.id = submission.problem_id WHERE user_id = "' . $id . '" ORDER by submission.moment DESC;';
           $result   = execQuery($sql);
           if ($result->num_rows > 0) {
             echo '<h1 align="center"> Submissões realizadas </h1>';
             echo '<table border="0" style="width:100%;">';
             echo '<tr bgcolor="#afafaf"> <th> ID </th><th> data/hora </th><th> problemas </th> <th> resposta </th> <th> pontuação </th> </tr>';
             $index = 1;
             while($row = $result->fetch_assoc()) {
                 $bgColor = '#dfdfdf';
                 if (($index % 2) == 0)
                   $bgColor = '#d0d0d0';
               $phpdate = strtotime( $row['moment'] );
               echo '<tr bgcolor="'. $bgColor .'" > <th>' . $row['id'] .  '</th><th> ' . date( 'd/m/Y H:i:s', $phpdate ) . ' </th><th> ' . $row['name'] . ' </th> <th> ' . $row['answer'] . ' </th> <th> ' . number_format(($row['score']) , 5, '.', ','). ' </th> </tr>';
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
