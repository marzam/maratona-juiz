<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
  include 'db.php';
  $user   = $_POST['idLogin'];
  $passwd = $_POST['idPasswd'];
  $sql = 'SELECT id,team_id, type, username, fasscess FROM login WHERE username = "' . $user . '" AND password = "' . md5($passwd) . '";';
  //echo $sql . '<br>';
  $result = execQuery($sql);


  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) 
      {
        if ($row['fasscess'] == '0')
        {
          if ($row['type'] == '0'){//Judge
            setcookie('login-judge', $row['id'], time() + (60*60*24*1000));
            echo '<script>';
            echo 'window.open("mainjudge.php","_self")';
            echo '</script>';
          }else if ($row['type'] == '1'){//team
            //echo 'team<br>'  ;
            $info = $row['id'].';'.$row['team_id'];
            setcookie('login-team', $info , time() + (60*60*24*1000));
           // setcookie('login-team', $row['id'], time() + (60*60*24*1000));
            echo '<script>';
            echo 'window.open("mainteam.php","_self")';
            echo '</script>';
          }else if ($row['type'] == '2'){//execnode
            //echo 'team<br>'  ;
            setcookie('login-node', $row['id'], time() + (60*60*24*1000));
            echo 'Ok';
            //echo '<script>';
            //echo 'window.open("mainteam.php","_self")';
            //echo '</script>';
          }else {
            echo 'Outros casos... <hr>';;
          }  
        }//end-if ($row['fasscess'] == '0'){
        else{ //First access, change password
          setcookie('change-passwd-id', $row['id'], time() + (60*60*24*1000));
          setcookie('change-passwd-username', $row['username'], time() + (60*60*24*1000));
          echo '<script>';
          echo 'window.open("changepasswd.php","_self")';
          echo '</script>';
        }
      }//end-if($row = $result->fetch_assoc()) {
  
  }//end-if ($result->num_rows > 0) {
 

?>
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
      <hr>
      <h3 align="center"> Login e/ou senha incorretos! </h3>
      <hr>
    
  </body>
</html>
