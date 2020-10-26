<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
    <div>

<?php  

    include 'vars.php'; 
    include 'db.php';    
    function hideEmail($email){
        for ($i = 3; $i< strlen($email)-7; $i++){
            $email[$i] = '*';
        }
        return $email;
    }

    $sql      = 'SELECT email FROM login WHERE username = "' . $_POST['idLogin'] . '"; ';
    //echo $sql . '<hr>';
    $result = execQuery($sql);
    if ($result->num_rows > 0) {
        if($row = $result->fetch_assoc()) {
            $command = './main-email.py ' . $_POST['idLogin'] . ' ' . $row['email'] ;
            
            $response = shell_exec($command);
            //echo $response;
            echo '<hr>';
            echo '<h3 align="center"> New password was sent to: ' . hideEmail($row['email']) . ' </h3>';
            echo '<hr>';
          
      
            
        }
    }
?>

    </div>
  </body>
</html>
