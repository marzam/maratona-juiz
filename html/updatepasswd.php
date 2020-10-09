<?php
    include 'db.php';
    $id = $_POST['id_id'];
    $passwd = $_POST['id_passwA'];
    echo '> ' . $id . '<br>';
    echo '> ' . $passwd . '<br>';

    $sql = 'UPDATE login SET  password = "'.  md5($passwd)  .'", fasscess = "0" WHERE id = "'. $id .'" ';
    $result   = execQuery($sql);

    echo '<script>';
    echo 'window.open("login.php","_self")';
    echo '</script>';
?>