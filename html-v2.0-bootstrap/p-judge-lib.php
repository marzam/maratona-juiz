<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
$id = '';
$username = '';
$name     = '';
$team     = '';

function getContinue($strFinal){
  $t=time();
  $strCurr = date("Y-m-d H:m:s",$t);

  $finalDate = new DateTime($strFinal);
  $currDate  = new DateTime($strCurr);

//      $dteDiff  = $dteStart->diff($dteEnd);

//      return (bool) var_dump($currDate  < $finalDate );  

  return intval($currDate < $finalDate);
}


function printHeader(){
  echo '<head>';
  echo '<link rel="shortcut icon" href="#" />';
  echo '  <meta charset="utf-8">';
  echo '  <meta name="viewport" content="width=device-width, initial-scale=1">';
  echo '  <link rel="stylesheet" href="css-bootstrap/bootstrap.min.css">';
  echo '  <script type="text/javascript" src="js-bootstrap/bootstrap.min.js"></script>';
  echo '  <script type="text/javascript" src="js-jquery/jquery.min.js"></script>';
  echo '  <script type="text/javascript" src="js-p-juge/p-judge.js"></script>';
  echo '  <title> ' . $GLOBALS['pageTitle'] . '</title>';
  echo '</head>';
}


//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function checkLoginTeam(){
  
  $info     = $_COOKIE['login-team'];
  $aux = strpos($info,";");
  $id = substr($info, 0, $aux);
  $team_id = substr($info,$aux+1);
  $username = 'desconhecido';
  $name     = 'desconhecido';
  $team     = '';
   
  $sql = 'select t1.name as team, t1.id as team_id, t2.id as id, t2.username as username, t2.name as name, t2.email as email FROM login as t2 inner join teams as t1 on t2.team_id = t1.id where t2.id="' . $id . '"; ';
 
  return execQuery($sql);


}   



function checkLoginJudge(){
  $ret = 0;
  $GLOBALS['id']       = $_COOKIE['login-judge'];
  $GLOBALS['username'] = 'desconhecido'; 
  $GLOBALS['name']     = 'desconhecido';
  $GLOBALS['team']     = '';

  $sql = 'select t1.name as team, t2.id as id, t2.username as username, t2.name as name FROM login as t2 inner join teams as t1 on t2.team_id = t1.id where t2.id="' . $GLOBALS['id'] . '"; ';
//  echo $sql . '<hr>';
  $result = execQuery($sql);

  if ($result->num_rows > 0) {
    if($row = $result->fetch_assoc()) {
      $GLOBALS['username'] = $row['username'];
      $GLOBALS['name']  = $row['name'];
      $GLOBALS['team']  = $row['team'];
      $ret = 1;
    }
  }

  return $ret;
}


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
  
  $sql = 'SELECT  count(*) as problems FROM problem;';
  $result   = execQuery($sql);
  $nProblems = 0;
  if ($result->num_rows > 0) {
    if($row = $result->fetch_assoc()) {
      $nProblems = $row['problems'];

    }//end-if($row = $result->fetch_assoc()) {

  }//end-if ($result->num_rows > 0) {

/*    
  $sql = 'select count(*) as solved from (SELECT MAX(submission.score) as score, problem_id, user_id FROM submission GROUP BY submission.user_id, submission.problem_id) as aux;';
  $result   = execQuery($sql);
  $sProblems = 0;
  if ($result->num_rows > 0) {
    if($row = $result->fetch_assoc()) {
      $sProblems = $row['solved'];

    }//end-if($row = $result->fetch_assoc()) {

  }//end-if ($result->num_rows > 0) {
*/

  echo '<h3> Pontuação </h3>';
  echo '<table style="width:100%;">';
          echo '<thead>';
          echo '<tr>';
          echo '<th scope="col">Equipe</th>';
          echo '<th scope="col">Problemas resolvidos/total</th>';
          echo '<th scope="col">Pontuação</th>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody>';
      
      $index = 1;
      //$sql = 'SELECT SUM(speedup) as speedup, login.name as team FROM (SELECT MAX(score.speedup) as speedup, problem_id, user_id from score GROUP BY score.user_id, score.problem_id) AS temp INNER JOIN login ON login.id = temp.user_id GROUP BY user_id ORDER BY speedup DESC;';
      //$sql = 'SELECT SUM(score) as score, login.username as team FROM (SELECT MAX(submission.score) as score, problem_id, user_id FROM submission GROUP BY submission.user_id, submission.problem_id) AS temp INNER JOIN login ON login.id = temp.user_id GROUP BY user_id ORDER BY score DESC;';
      //$sql = 'SELECT SUM(score) as score, count(problem_id) as total, login.username as team FROM (SELECT t2.moment, t2.localid, t2.score, t2.user_id, t2.problem_id from (select moment, unix_timestamp(moment) as localid, score, user_id, problem_id from submission) as t2 INNER JOIN (SELECT MAX(unix_timestamp(moment)) as localid, problem_id, user_id FROM submission WHERE answer = "accepted" GROUP BY submission.user_id, submission.problem_id) as t1  ON t2.localid = t1.localid) as temp INNER JOIN login ON login.id = temp.user_id GROUP BY user_id ORDER BY score DESC;';
      //$sql = 'SELECT result.score, result.total, result.id, result.team_id, t3.name as team  FROM (SELECT SUM(score) as score, count(problem_id) as total, login.id as id, login.team_id as team_id FROM (SELECT t2.moment, t2.localid, t2.score, t2.user_id, t2.problem_id from (select moment, unix_timestamp(moment) as localid, score, user_id, problem_id from submission) as t2 INNER JOIN (SELECT MAX(unix_timestamp(moment)) as localid, problem_id, user_id FROM submission WHERE answer = "accepted" GROUP BY submission.user_id, submission.problem_id) as t1  ON t2.localid = t1.localid) as temp INNER JOIN login ON login.id = temp.user_id GROUP BY user_id ORDER BY score DESC) as result INNER JOIN teams as t3 where t3.id=result.team_id;';
      $sql='SELECT SUM(score) as score, count(problem_id) as total, teams.name as team FROM (SELECT t2.moment, t2.localid, t2.score, t2.team_id, t2.problem_id from (select moment, unix_timestamp(moment) as localid, score, team_id, problem_id from submission) as t2 INNER JOIN (SELECT MAX(unix_timestamp(moment)) as localid, problem_id, team_id FROM submission WHERE answer = "accepted" GROUP BY submission.team_id, submission.problem_id) as t1  ON t2.localid = t1.localid) as temp INNER JOIN teams ON teams.id = temp.team_id GROUP BY team_id ORDER BY score DESC;';
      $result   = execQuery($sql);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $bgColor = '#dfdfdf';
          if (($index % 2) == 0)
           $bgColor = '#d0d0d0';

          echo '<tr bgcolor="'. $bgColor .'" > <td  align="left">' . $row['team'] .  '</a> </td><td align="right"> '. $row['total'] .'/'. $nProblems .'  </td> <td align="right"> ' .  number_format(($row['score']) , 5, '.', ',') . ' </td>  </tr>';
          $index++;

        }//end-if($row = $result->fetch_assoc()) {

      }//end-if ($result->num_rows > 0) {
  echo '</tbody>';
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
