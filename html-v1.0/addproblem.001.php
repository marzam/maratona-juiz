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

  $problem = '';
  $time = '';
  $desc = '';
  $paramHPC = '';
  $stdout = '';
  $inputvideo = '';
  $outputvideo = '';
  $inputfile = '';
  $outputfile = '';
  $visible = '';
  if (isset($_POST['id_id']) && $_POST['id_id'] != '-1'){
       
      $sql = 'SELECT * FROM problem WHERE id = "' . $_POST['id_id'] . '"';
      $result   = execQuery($sql);
      if($row = $result->fetch_assoc()){
        $problem = $row['name'];
        $time = $row['time'];
        $desc = $row['description'];
        $paramHPC = $row['inputHPC'];
        $stdout = $row['stdout'];

        if ($stdout == 'video'){
          $inputvideo = $row['input'];
          $outputvideo = $row['output'];
        }else{
          $inputfile = $row['input'];
          $outputfile = $row['output'];
        }

        $visible = $row['visible'];

      }//end-if($row = $result->fetch_assoc()){
  }//end-if (isset($_POST['id_id']) && $_POST['id_id'] != '-1'){


?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <script>
  function initState(){
    if (!confirm("Deseja limpar todos os campos ?"))  
      return;
  
    document.getElementById('id_output').value = 'video';
    document.getElementById('id_visible').checked = false;
    document.getElementById('id_video').checked = true;
    
    document.getElementById('id_name').value = '';
    document.getElementById('id_time').value = '';
    document.getElementById('id_file_problem').value = '';
    document.getElementById('id_description').value = '';
    document.getElementById('id_parametros_hpc').value = '';

    document.getElementById('id_output_video_in').value = '';
    document.getElementById('id_output_video_out').value = '';

    document.getElementById('id_output_file_in').value = '';
    document.getElementById('id_output_file_out').value = '';

    radioButtonEvent('video');


  }
  function radioButtonEvent(opt){
    var mDIV;
    document.getElementById('id_output').value = opt;
    if (opt == 'file'){
      
      mDIV = document.getElementById('id_div_video');
      mDIV.style.visibility = 'hidden';
      mDIV = document.getElementById('id_div_file');
      mDIV.style.visibility = 'visible';
      return;
    }
    if (opt == 'video'){
      
      mDIV = document.getElementById('id_div_video');
      mDIV.style.visibility = 'visible';
      mDIV = document.getElementById('id_div_file');
      mDIV.style.visibility = 'hidden';
      return;
    }
  }

  function isNumberKey(evt){
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if ( ((charCode >= 48) && (charCode <= 57)) || (charCode == 46))
              return true;
          return false;
      }
  </script>
  <body >
    <div>
      <h1 align="center"> <?php echo $eventTitle1; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle; ?> </h2>
    </div>

    <div style="border: 2px solid #dadada; background-color: #dadada; height: 100px; width: 600px; border-radius: 8px; margin-left: auto; margin-right: auto;">
      <a align="left" href="javascript:history.back()"> Voltar </a>
      <h3 align="center">Juiz: <strong><?php echo $name; ?></strong></h3>
      <h3 align="center"><?php echo $username; ?></h3>

      <hr>
           <h1 align="center"> Adicionar problema </h1>
           <br>
           <form action="saveproblem.php"  method="post" enctype="multipart/form-data">
            <input type="hidden" id="id_id" name="id_id" value="-1">
              <table style="width: 100%" border="0" align="center">
                  <colgroup>
                      <col span="1" style="width: 20%;">
                      <col span="1" style="width: 80%;">
                  </colgroup>
                  <tr>
                      <td align = "right">Problema:</td> <td><input type="text" id="id_name" name="id_name" value="" maxlength = "20" size="20"> </td>
                  </tr>
                  <tr>
                      <td align = "right">Tempo:</td> <td><input type="text" id="id_time" name="id_time" value="" maxlength = "20" size="12" onkeypress="return isNumberKey(event);" > </td>
                  </tr>
                  <tr>
                      <td align = "right" >Arquivo:</td> <td> <input type="file"  accept=".tar.gz" name="id_file_problem" id="id_file_problem"> </td>
                  </tr>
              </table>
             <label >Descrição: </label>
             <br>
             <textarea id="id_description" rows = "10"  cols = "82"  maxlength = "256"  name = "id_description"  style="resize: none;"></textarea><br>
             <br>
              <table style="width: 100%" border="0" align="center">
                  <tr>
                      <td align = "right" >Parâmetros HPC:</td> <td><input type="text" id="id_parametros_hpc" name="id_parametros_hpc" value="" maxlength = "20" size="20" > </td>
                  </tr>
              </table>
              <table style="width: 50%" border="0" align="center"> 
                  <tr>
                      <td align = "left" > 
                         <input type="radio" id="id_video" name="output" value="video" onclick="radioButtonEvent('video');" checked>
                            <label for="video">Saípa para vídeo</label><br>
                          <input type="radio" id="id_file" name="output" value="file" onclick="radioButtonEvent('file');">
                            <label for="arquivo">Saída para arquivo</label><br> 
                      </td> 
                  </tr>
              </table>
              <div id='id_div_video'>
                <table style="width: 100%" border="0" align="center"> 
                    <tr>
                          <td align = "right" > 
                            Entrada:
                          </td> 
                          <td align = "left" > 
                            <input type="text" id="id_output_video_in" name="id_output_video_in" value="" maxlength = "20" size="20">
                          </td>

                        <td align = "right" > 
                          Saída:
                        </td> 
                        <td align = "left" > 
                          <input type="text" id="id_output_video_out" name="id_output_video_out" value="" maxlength = "20" size="20">
                        </td>
                    </tr>
                </table>
              </div>

              <div id='id_div_file' style ='visibility:hidden;'>
                <table style="width: 100%" border="0" align="center"> 
                    <tr>
                          <td align = "right" > 
                            Entrada:
                          </td> 
                          <td align = "left" > 
                            <input type="text" id="id_output_file_in" name="id_output_file_in" value="" maxlength = "20" size="20">
                          </td>

                        <td align = "right" > 
                          Arquivo:
                        </td> 
                        <td align = "left" > 
                          <input type="file"  accept="*" name="id_output_file_out" id="id_output_file_out">
                        </td>
                    </tr>
                </table>
              </div>

<!--                  <tr>
                    <td align = "right" > Arquivo de saída: <td> <input type="file"  name="id_file_problem" id="id_file_problem"> </td>
                    <td align = "right" >   MD5 do arquivo: <td> <input type="text" id="id_parametros_hpc" name="id_parametros_hpc" value="" maxlength = "32"></td>
                    <td align = "right" >  Visível: <td> <input type="checkbox" id="id_stdout" name="id_stdout" value="Saída padrão"></td>
                  </tr>
-->
             <input type="checkbox" id="id_visible" name="id_visible" value="Yes"><label for="Visivel">Visível</label><br><br><hr>
             <input type="hidden" id="id_output" name="id_output" value="video">
             <input id="id_submit" type="submit" value="Cadastrar">
             <button id="id_clear" type="button" onclick="initState();" >Limpa</button>

           </form>


    </div>

  </body>
</html>
