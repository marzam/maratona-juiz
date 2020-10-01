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

function simpleScoreTable(){
  echo '<h1 align="center"> Pontuação </h1>';
  echo '<table border="0" style="width:100%;">';
    echo '<colgroup>';
       echo '<col style="width:80%;">';
       echo '<col style="width:20%;">';
    echo '</colgroup>';
      $index = 1;
      //$sql = 'SELECT SUM(speedup) as speedup, login.name as team FROM (SELECT MAX(score.speedup) as speedup, problem_id, user_id from score GROUP BY score.user_id, score.problem_id) AS temp INNER JOIN login ON login.id = temp.user_id GROUP BY user_id ORDER BY speedup DESC;';
      $sql = 'SELECT SUM(score) as score, login.name as team FROM (SELECT MAX(submission.score) as score, problem_id, user_id FROM submission GROUP BY submission.user_id, submission.problem_id) AS temp INNER JOIN login ON login.id = temp.user_id GROUP BY user_id ORDER BY score DESC;';
      $result   = execQuery($sql);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $bgColor = '#dfdfdf';
          if (($index % 2) == 0)
           $bgColor = '#d0d0d0';

          echo '<tr bgcolor="'. $bgColor .'" > <th  align="left">' . $row['team'] .  '</a> </th> <th align="right"> ' . $row['score'] . ' </th>  </tr>';
          $index++;

        }//end-if($row = $result->fetch_assoc()) {

      }//end-if ($result->num_rows > 0) {

  echo '</table>';
}

function nodelogin($user, $passwd){
  $sql = 'SELECT id,type FROM login WHERE username = "' . $user . '" AND password = "' . md5($passwd) . '";';

  $result = execQuery($sql);
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        if ($row['type'] == '2'){//execnode
          echo 'PHP Ok';

        }else {
          die("PHP ERROR: there is not enough permission");
        }

      }//end-if($row = $result->fetch_assoc()) {

  }//end-if ($result->num_rows > 0) {
  else{
     die("PHP ERROR: wrong user or login");
  }

}


?>
