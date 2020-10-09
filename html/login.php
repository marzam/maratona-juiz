<?php  include 'vars.php'; ?>
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
      <h1 align="center"> <?php echo $eventTitle2; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle;  ?> </h2>

    </div>
    <div class="loginborda" >
      <form method="post" action="dologin.php" >
        <table style="width: 90%" border="0" align="center">
            <tr>
              <td>Login da equipe:</td>
            </tr>
            <tr>
              <td><input id="idLogin" name="nameLogin" type="text"   style="width: 96%;" > </td>
            </tr>
            <tr>
              <td>Senha:<br>
              </td>
            </tr>
            <tr>
              <td><input id="idPasswd" name="namePassed" type="password" style="width: 96%;"> </td>
            </tr>

        </table>
        <p align="center"> <input value="Logar" type="submit"> </p>
        <!-- <p align="center"> <a href="forgot.html">esqueceu sua senha ?</a> </p>
        <p align="center"> <a href="register.php">novo usuário ?</a> </p> -->
      </form>
    </div>
  </body>
</html>
