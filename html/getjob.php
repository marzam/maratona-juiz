<?php
//INSERT INTO login (name, password, score, type, username) values ('Marcelo', '12345', '0', '1', 'mzamith')
  include 'db.php';
  $user   = $_POST['nameLogin'];
  $passwd = $_POST['namePassed'];

  # blocks other accesses to submission table to handle concurrency
  $sql = "LOCK TABLE submission WRITE";
  $result = execQuery($sql);

  //SELECT submission.*,problem.path,problem.param,problem.time FROM submission
  //INNER JOIN problem ON problem.id = submission.problem_id WHERE  submission.answer = "pending" DES submission.od LIMIT 1;
  # find first pending submission
  //$sql = 'SELECT submission.*,problem.path,problem.param,problem.time FROM problem,submission WHERE submission.answer = "pending" AND problem.id = submission.problem_id LIMIT 1;';
  $sql = 'SELECT submission.*,problem.file as file_prob,problem.param,problem.stdout,problem.time, problem.template FROM submission INNER JOIN problem ON problem.id = submission.problem_id WHERE  submission.answer = "pending" ORDER BY submission.id ASC LIMIT 1;';
  $result = execQuery($sql);
  if ($result->num_rows > 0) {
	  if($row = $result->fetch_assoc()) {
		  header('Content-Type: application/json');
		  echo json_encode($row);
		  $subid = $row['id'];
	  }
  }

  # update submission to executing state
  #$sql = 'UPDATE submission SET answer = "executing" WHERE id = "' . $subid . '";';
  #$result = execQuery($sql);

  # release table
  #$sql = "UNLOCK TABLES";
  #$result = execQuery($sql);

?>
