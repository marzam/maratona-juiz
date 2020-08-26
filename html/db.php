<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
function execQuery($mysql){
    $servername = "localhost";
    $username   = "localuser";
    $password   = "localuser";

    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
       die('ERROR: ' . $conn->error);
       return;
    }

    if (!$conn->set_charset("utf8")) {
        die('ERROR: ' . $conn->error);
        return;
    }


    $sql = "USE dbMaratona;";
    $conn->query($sql);
    $result = $conn->query($mysql);
    $conn->close();
    return $result;
}

  


?>
