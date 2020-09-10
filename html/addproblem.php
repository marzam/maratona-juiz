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
           <h1 align="center"> Adicionar problema </h1>
           <br>
           <form action="saveproblem.php"  method="post">
             <label >ID: xx</label>
             <label >Problema:</label><input type="text" id="id_name" name="id_name" value="" maxlength = "32">
             <br>
             <label >Arquivo fonte: </label>   <input type="file"  accept=".tar.gz" name="id_file_problem" id="id_file_problem">
             <br>
             <label >Descrição: </label>
             <br>
             <textarea id="id_description" rows = "5"  cols = "82"  maxlength = "256"  name = "id_description"  style="resize: none;"></textarea><br>
             <br>
             <label >Parâmetros: </label><br>
             <textarea id="id_description" rows = "5"  cols = "82"  maxlength = "256"  name = "id_description"  style="resize: none;"></textarea><br>
             <br>
             <label >Gabarito: </label><br>
             <input type="checkbox" id="id_stdout" name="id_stdout" value="Saída padrão"><br>
             <input type="checkbox" id="id_fileout" name="id_fileout" value="Arquivo">
             <textarea id="id_description" rows = "5"  cols = "82"  maxlength = "256"  name = "id_description"  style="resize: none;"></textarea><br>


              <br>

             <input id="id_submit" type="submit" value="Cadastrar">
             <button id="id_clear" type="button" >Limpa</button>

           </form>


    </div>

  </body>
</html>
