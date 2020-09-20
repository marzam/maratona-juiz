<?php  include 'vars.php';
  $record =  $_COOKIE['register'];
  setcookie('register', '', time() - 3600, '/'); // empty value and old timestamp
  $name = '';
  $login = '';
  $email = '';
  $error = (!empty($record));
  if ($error){
    $line = explode(";", $record);
    $name = $line[0];
    $login = $line[1];
    $email = $line[2];

  }


?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <script>
  function checkEmail(){
      var email = document.getElementById("id_email").value;
      alert(email);
  }
  function checkIsOkPasswd(){
    var p1 = document.getElementById("id_passwA").value;
    var p2 = document.getElementById("id_passwB").value;
    //str.length
    if (p1 == p2){
      document.getElementById("id_passwA").style = "background-color:green";
      document.getElementById("id_passwB").style = "background-color:green";
      document.getElementById("id_aux").value = "0";
    }else{
      document.getElementById("id_passwA").style = "background-color:white";
      document.getElementById("id_passwB").style = "background-color:white";

      //código de error 1 -> senha não confere
      document.getElementById("id_aux").value = "1";
    }
  }
  </script>
  <body>
    <div>
      <h1 align="center"> <?php echo $eventTitle1; ?> </h1>
      <h1 align="center"> <?php echo $eventTitle2; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle;  ?> </h2>
      <?php
        if ($error){
          echo '<h3  align="center" style="color:red"> Login ou email já cadastrados </h3>';
          echo '<h3  align="center" style="color:red"> Verifique seus dados </h3>';
        }
      ?>

    </div>
    <fieldset>
          <legend>&nbsp; Registro da equipe  &nbsp; </legend>
         <form method="post" action="doregister.php">
          <br>

          <div> <label>Nome da equipe</label>
            <?php echo '<div> <input id="id_name" name="id_name" type="text"   value = "'. $name .'" > </div>'  ?>
            <!-- <div> <input id="id_name" name="id_name" type="text"  > </div> -->
          </div>
          <br>

          <div> <label>Login</label>
            <?php echo '<div> <input id="id_login" name="id_login" type="text" maxlength = "30" value = "'. $login .'"> </div>'  ?>

          </div>
          <br>

          <div> <label>Senha</label>
            <div> <input id="id_passwA" name="id_passwA" type="password" maxlength = "30" value="" > </div>
          </div>
          <br>

          <div> <label>Senha (confirma) </label>
          <!--  <div> <input id="id_passwB" name="id_passwB" type="password" maxlength = "30" onkeyup="checkIsOkPasswd();"  style="background-color:green;" > </div> -->
            <div> <input id="id_passwB" name="id_passwB" type="password" maxlength = "30"  value=""   onkeyup="checkIsOkPasswd();"  > </div>
          </div>
          <br>
          <input type="hidden" id="id_aux" name="id_aux" value="0">
          <div> <label>e-mail </label>
<!--            <div><input type="email" id="id_email" onblur="checkEmail();"> </div>-->
            <?php echo '  <div><input type="email" id="id_email"  name="id_email" value="'. $email . '"  > </div>'  ?>

          </div><br>
          <div> <input value="Registrar" type="submit"> </div>
          <!-- <div> <input value="Registrar" type="button" onclick=""> </div>-->
      </form>
    </fieldset>
  </body>
</html>
