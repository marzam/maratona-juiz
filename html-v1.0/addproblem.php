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
  $id_prob = '-1';
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
      $id_prob = $_POST['id_id'];
      $sql = 'SELECT * FROM problem WHERE id = "' . $id_prob. '"';
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

  function submitDel(opt){
    
    if (opt == 'yes')
      if (!confirm("Deseja apagar o problema ?"))  
        return;

    document.getElementById("id_deloutput").value = opt;
    document.getElementById('id_probform').submit();
  }
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
      <h3 align="center">Equipe: <strong><?php echo $team; ?></strong></h3>
      <h3 align="center">Usuário: <?php echo $username; ?></h3>

      <hr>
<?php      
        if ($id_prob == '-1')
          echo '<h1 align="center"> Adicionar problema </h1>';
        else
          echo '<h1 align="center"> Atualizar problema </h1>';
?>
           
           <br>
           <form action="saveproblem.php"  id="id_probform" method="post" enctype="multipart/form-data">
<?php
            echo '<input type="hidden" id="id_id" name="id_id" value="'.$id_prob.'">';
            echo '  <table style="width: 100%" border="0" align="center">';
            echo '      <colgroup>';
            echo '          <col span="1" style="width: 20%;">';
            echo '          <col span="1" style="width: 80%;">';
            echo '      </colgroup>';
            echo '      <tr>';
            echo '          <td align = "right">Problema:</td> <td><input type="text" id="id_name" name="id_name" value="'.$problem.'"  size="20"> </td>';
            echo '      </tr>';
            echo '      <tr>';
            echo '          <td align = "right">Tempo:</td> <td><input type="text" id="id_time" name="id_time" value="'.$time.'"   size="12" onkeypress="return isNumberKey(event);" > </td>';
            echo '      </tr>';
            echo '      <tr>';
            echo '          <td align = "right" >Arquivo:</td> <td> <input type="file"  accept=".tar.gz" name="id_file_problem" id="id_file_problem"> </td>';
            echo '      </tr>';
            echo '  </table>';
            echo ' <label >Descrição: </label>';
            echo ' <br>';
            echo ' <textarea id="id_description" rows = "10"  cols = "82"  maxlength = "2048"  name = "id_description"  style="resize: none;">'.$desc.'</textarea><br>';
            echo ' <br>';
            echo '  <table style="width: 100%" border="0" align="center">';
            echo '      <tr>';
            echo '          <td align = "right" >Parâmetros HPC:</td> <td><input type="text" id="id_parametros_hpc" name="id_parametros_hpc" value="'.$paramHPC.'"   size="20" > </td>';
            echo '      </tr>';
            echo '  </table>';
            echo '  <table style="width: 50%" border="0" align="center"> ';
            echo '      <tr>';
            echo '          <td align = "left" > ';
            if ($stdout == 'video'){
              echo '             <input type="radio" id="id_video" name="output" value="video" onclick="radioButtonEvent(\'video\');" checked>';  
            }else{
              echo '             <input type="radio" id="id_video" name="output" value="video" onclick="radioButtonEvent(\'video\');">';
            }
            echo '                <label for="video">Saípa para vídeo</label><br>';

            if ($stdout == 'file'){
              echo '              <input type="radio" id="id_file" name="output" value="file" onclick="radioButtonEvent(\'file\');" checked>';
            }else{
              echo '              <input type="radio" id="id_file" name="output" value="file" onclick="radioButtonEvent(\'file\');">';
            }

            
            echo '                <label for="arquivo">Saída para arquivo</label><br> ';
            echo '          </td> ';
            echo '      </tr>';
            echo '  </table>';

            echo '  <div id="id_div_video">';
            echo '    <table style="width: 100%" border="0" align="center"> ';
            echo '        <tr>';
            echo '              <td align = "right" > ';
            echo '                Entrada:';
            echo '              </td> ';
            echo '              <td align = "left" > ';
            echo '                <input type="text" id="id_output_video_in" name="id_output_video_in" value="'.$inputvideo.'"  size="20">';
            echo '              </td>';

            echo '            <td align = "right" > ';
            echo '              Saída:';
            echo '            </td> ';
            echo '            <td align = "left" > ';
            echo '              <input type="text" id="id_output_video_out" name="id_output_video_out" value="'.$outputvideo.'"  size="20">';
            echo '            </td>';
            echo '        </tr>';
            echo '    </table>';
            echo '  </div>';

            echo '  <div id="id_div_file" style ="visibility:hidden;">';
            echo '    <table style="width: 100%" border="0" align="center"> ';
            echo '        <tr>';
            echo '              <td align = "right" > ';
            echo '                Entrada:';
            echo '              </td> ';
            echo '              <td align = "left" > ';
            echo '                <input type="text" id="id_output_file_in" name="id_output_file_in" value="'.$inputfile.'"  size="20">';
            echo '              </td>';

            echo '            <td align = "right" > ';
            echo '              Arquivo:';
            echo '            </td> ';
            echo '            <td align = "left" > ';
            echo '              <input type="file"  accept="*" name="id_output_file_out" id="id_output_file_out">';
            echo '            </td>';
            echo '        </tr>';
            echo '    </table>';
            echo '  </div>';

            $checked = '';
            if ($visible == '1'){
              $checked = 'checked';
            }
            echo ' <input type="checkbox" id="id_visible" name="id_visible" value="Yes" '.$checked.'>';

            echo '<label for="Visivel">Visível</label><br><br><hr>';
            echo ' <input type="hidden" id="id_output" name="id_output" value="video">';
            echo ' <input type="hidden" id="id_deloutput" name="id_deloutput" value="no">';
            if ($id_prob == '-1'){
              echo ' <input id="id_submit" type="submit" value="Cadastrar">';
              echo ' <button id="id_clear" type="button" onclick="initState();" >Limpa</button>';
            }
            else{
              echo ' <button id="id_update" type="button" onclick="submitDel(\'no\');" >Atualizar</button>';
              echo ' <button id="id_del" type="button" onclick="submitDel(\'yes\');" >Apagar</button>';
            }
            
              //echo ' <input id="id_delete" type="button" value="Apagar">';

?>
           </form>


    </div>
<?php
  echo '<script>';
  if ($stdout == 'video'){
    echo 'radioButtonEvent(\'video\');';
  }else{
    echo 'radioButtonEvent(\'file\');';
  }
  echo '</script>';
  ?>
  </body>
</html>
