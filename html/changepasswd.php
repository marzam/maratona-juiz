<?php  include 'vars.php';
    $id       = $_COOKIE['change-passwd-id'];
    $username = $_COOKIE['change-passwd-username'];
    setcookie("change-passwd-id", "", time() - 3600);
    setcookie("change-passwd-username", "", time() - 3600);
    
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <script>

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
      <h2 align="center"> Redefinir senha </h2>

    </div>
    <div class="loginborda" >
      <form method="post" action="dologin.php" >
<?php       echo '<input type="hidden" id="id_id" name="id_id" value="'. $id .'">'; ?>
          <table style="width: 90%" border="0" align="center">
                <tr>
                    <td><label for="username">Username:</label> </td>
                </tr>
                <tr>
<?php                echo '<td><input type="text" id="id_username" name="id_username" minlength="60" readonly="readonly" value="'. $username  .'" ></td>'; ?>
                </tr>
                <tr>
                    <td><label for="pass">Password:</label><br>
                </td>
                </tr>
                <tr>
                    <td><input id="id_passwA" name="id_passwA" type="password" maxlength = "30" value="" ></td>
                </tr>
                <tr>
                    <td><label for="pass">Confirm password:</label><br>
                </td>
                </tr>
                <tr>
                    <td><input id="id_passwB" name="id_passwB" type="password" maxlength = "30"  value=""   onkeyup="checkIsOkPasswd();"></td>
                </tr>

            </table>
            <p align="center"> <input value="Aplicar" type="submit"> </p>


      </form>
    </div>
  </body>
</html>
