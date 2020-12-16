<?php
$src = md5($_POST['idLogin']).md5($_POST['idPasswd']);

$file = fopen("upload.ini", "r");
$dst  = fread($file, filesize("upload.ini"));
fclose($file);
if (strcmp($src,trim($dst)) == 0){
    //echo $_FILES["fileToUpload"]["tmp_name"] . '<br>';
    echo 'File: ' . $_FILES['fileToUpload']['name'] . ' is updated <br>';
    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $_FILES['fileToUpload']['name']);
    //echo ' <script type="text/javascript"> window.open("upload-update.php", "_self"); </script>';
    echo 'OK!';
}else
    echo 'Error <br>' ;



?>