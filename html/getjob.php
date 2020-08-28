<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
  include 'db.php';
  $user   = $_POST['nameLogin'];
  $passwd = $_POST['namePassed'];
  $sql = 'SELECT submission.*,problem.path FROM problem,submission WHERE submission.answer = "pending" AND problem.id = submission.problem_id LIMIT 1;';
  $result = execQuery($sql);

  if ($result->num_rows > 0) {
	  if($row = $result->fetch_assoc()) {
		  header('Content-Type: application/json');
		  echo json_encode($row);
		  #echo $row['id'] . "\n";
		  #echo $row['problem_id'] . "\n";
		  #echo $row['moment'] . "\n";
		  #echo $row['file'] . "\n";
	  }//end-if($row = $result->fetch_assoc()) {
  }//end-if ($result->num_rows > 0) {

?>
