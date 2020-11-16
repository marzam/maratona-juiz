<?php
  include 'vars.php';
  include 'db.php';
  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">

  </head>
  <script>
 
      function timedRefresh(timeoutPeriod) {
        setTimeout("location.reload(true);",timeoutPeriod);
      }

      window.onload = timedRefresh(5000);

  </script>
  <body>
    <div>
      <h1 align="center"> <?php echo $eventTitle1; ?> </h1>
      <h2 align="center"> <?php echo $judgeTitle; ?> </h2>
    </div>

    <div style="border: 2px solid #dadada; background-color: #dadada; height: 100px; width: 600px; border-radius: 8px; margin-left: auto; margin-right: auto;">
        <?php simpleScoreTable(); ?>
    </div>

  </body>
</html>
