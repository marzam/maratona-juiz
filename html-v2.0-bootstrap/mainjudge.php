<?php

      include 'vars.php';
      include 'p-judge-lib.php';
      $result   = checkLoginJudge();
      if ($result == 0) echo '<script type="text/javascript"> window.open("login.php", "_self"); </script>';
      //end-if ($result->num_rows > 0) {
        //https://mdbootstrap.com/snippets/jquery/mdbootstrap/888438#
        
?>

<!DOCTYPE html>
<html lang="br">

<head>
  <link rel="shortcut icon" href="#" /> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $GLOBALS['pageTitle'] ?> </title>

  <!-- Bootstrap core CSS -->
  <!--  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="css-bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="css-p-judge/simple-sidebar.css" rel="stylesheet">
  <script type="text/javascript" src="p-judge.js"></script>

</head>

<body>

  <div class="p-3 mb-1 bg-dark text-white text-center" >
    <table style="width:100%">
      <tr>
        <th><h2> <?php echo $GLOBALS['eventTitle1']; ?> </h3></th>
        <th><h5>Equipe: [<strong class="text-muted"> <?php echo $GLOBALS['team']; ?> </strong>]</h5></th>
      </tr>
      <tr>
        <td><h3> <?php echo $GLOBALS['judgeTitle']; ?> </h3></td>
        <td><h5>Usuário: [<strong class="text-muted"> <?php echo  $GLOBALS['username']; ?> </strong>] </h5></td>
      </tr>
    </table> 
  </div>

  <div class="d-flex" id="wrapper">
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="#">Jugar <span class="sr-only">  &#8592; </span></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Submissões realizadas</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Lista de problemas</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Esclarecimento de dúvidas</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Pontuação</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Relatórios</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="javascript:logout()">Sair</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Cadastro
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Times</a>
                <a class="dropdown-item" href="#">Maratonista</a>
                <!-- <div class="dropdown-divider"></div> -->
                <a class="dropdown-item" href="#">Problemas</a>
              </div>
            </li>
            
          </ul>
        </div>
      </nav>
 

          
          <div class="container-fluid">
              <!-- begin content --------------------------------------------------------------------------------------------------- -->
              <div  class="d-flex flex-row-reverse pt-2">   
              <button class = "btn btn-sm btn-dark btn-block " type="button" onclick="updateSubmissionsXML();">Update</button> 
              </div> 

              
              <?php
                      //$sql = 'SELECT submission.*,problem.name  FROM submission INNER JOIN problem ON problem.id = submission.problem_id ORDER by submission.moment DESC;';
                      $sql = 'SELECT login.username, submission.*,problem.name, problem.time  FROM submission  INNER JOIN problem ON problem.id = submission.problem_id  INNER JOIN login ON login.id = submission.user_id  ORDER by submission.moment DESC;';
                      $result   = execQuery($sql);
                      if ($result->num_rows > 0) {
                        echo '<h3> Juiz / submissões </h3>';
                        echo '<table class="table table-condensed">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th scope="col">ID</th>';
                        echo '<th scope="col">Usuário</th>';
                        echo '<th scope="col">Data/Hora</th>';
                        echo '<th scope="col">Problema</th>';
                        echo '<th scope="col">Decisão</th>';
                        echo '<th scope="col">INFO</th>';
                        echo '<th scope="col">Acel.</th>';
                        echo '<th scope="col">Tempo p. / Tempo s.</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        
                        $index = 1;
                        while($row = $result->fetch_assoc()) {
                            $bgColor = '#eeeeee';
                            if (($index % 2) == 0)
                              $bgColor = '#dadada';
                          $phpdate = strtotime( $row['moment'] );
            //               echo '<tr bgcolor="'. $bgColor .'" > <th>' . $row['id'] .  '</th><th> ' .  $row['username'] . '</th><th> ' . date( 'd/m/Y H:i:s', $phpdate ) . ' </th><th> ' . $row['name'] . ' </th> <th> ' . $row['answer'] . ' </th> <th> ' . number_format($row['score'] , 5, '.', ','). ' </th> </tr>';
            //               echo '<tr bgcolor="'. $bgColor .'" > <th>' . $row['id'] .  '</th><th> ' .  $row['username'] . '</th><th> ' . date( 'd/m/Y H:i:s', $phpdate ) . ' </th><th> ' . $row['name'] . ' </th> <th> ';
                            echo '<tr bgcolor="'. $bgColor .'" > <th><a href="' . $row['file'] . '">' . $row['id'] .  '</a> </th> <th> ' .  $row['username'] . '</th><th> ' . date( 'd/m/Y H:i:s', $phpdate ) . ' </th><th> ' . $row['name'] . ' </th> <th> ';
            //               echo $row['answer'] ;
                          $answers = array( 'accepted' , 'wrong answer', 'runtime error', 'compilation error', 'pending', 'submitted file corrupted', 'time out');
                          echo '<select id="id_answser_' . ($index-1) . '" onchange="setSelect(' . ($index-1) . ')">>';
                          for ($i = 0; $i < 7; $i++){
                              $selected = '';
                              if ( $answers[$i] == $row['answer'] )
                                $selected = 'selected ';
                              echo '<option value="' . $answers[$i] . '"  '. $selected .' >' . $answers[$i]  . '</option>';
                          }
                          echo '</select>';
                          // <option value="accepted">accepted</option> <option value="wrong answer" selected>wrong answer</option> <option value="runtime error">runtime error</option> <option value="compilation error">compilation error</option> <option value="pending">pending</option></select>';
                          echo '</th><th> <a href="javascript:pInfo('.  ($index - 1) .');"> info </a> <input type="hidden" id="id_info_'.  ($index - 1) .'" name="numberrow" value="'.   $row['info'] .'"> </th>';
                          echo '<th> ' . number_format($row['score'] , 3, '.', ','). ' </th>';
                          echo ' </th> <th> <input type="text" id="id_elapsedtime_'.  ($index - 1) .'" value="' . number_format($row['elapsedtime'] , 5, '.', ','). '" maxlength="20" size="10" onkeypress="return isNumberKey(event, '. ($index - 1) .')" > <input type="text" id="id_p_elapsedtime_'.  ($index - 1) .'" value="' . number_format($row['time'] , 5, '.', ','). '" size="10" readonly> </th> <th> <input type="hidden" id="id_updated_' . ($index-1) . '"  name="numberrow" value="0"> <input type="hidden" id="id_submissionID_'.  ($index - 1) .'" name="numberrow" value="'.   $row['id'] .'"> </th> </tr>';
                          $index++;
                        }//end-if($row = $result->fetch_assoc()) {
                          echo '</tbody>';
                        echo '</table>';
                        echo '<br>';
                        echo '<input type="hidden" id="id_index_value"  name="numberrow" value="' . ($index-1) . '">';
                      }//end-
         ?>







              <!-- end content --------------------------------------------------------------------------------------------------- -->
              <!--
                <h1 class="mt-4">Simple Sidebar</h1>
                <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
                <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>
      -->
          </div>
    </div>

            
 
  
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

      <script>
          $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#wrapper").toggleClass("toggled");
          });
      </script>

  </div>


  


</body>

</html>
