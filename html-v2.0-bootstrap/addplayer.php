<?php

      include 'vars.php';
      include 'p-judge-lib.php';
      $result   = checkLoginJudge();
      if ($result == 0) echo '<script type="text/javascript"> window.open("login.php", "_self"); </script>';
      if ($_GET['all'])
        $all = 'checked';
      else
        $all = '';
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
  <script type="text/javascript" src="js-p-judge/p-judge.js"></script>
  <script type="text/javascript">
    function deleteTeam(id){

      var answer = window.confirm('Deseja apagar mesmo o registro #' + id + ' ?');
      if (answer) {
          //some code
          //document.cookie = "username=John Doe";
          document.cookie = "delete_team=" + id;
          window.open("deleteteam.php", "_self");
          //alert('Deletado!');
      }
      return;
    }
  </script>

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
              <a class="nav-link" href="#">[Jugar] <span class="sr-only"></span></a>
            </li>
<!--
            <li class="nav-item">
              <a class="nav-link" href="#">Submissões realizadas</a>
            </li>
-->
            <li class="nav-item">
              <a class="nav-link" href="listproblems.php">Lista de problemas</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="clarificationjudge.php">Dúvidas</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="score-judge">Pontuação</a>
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
                <a class="dropdown-item" href="addteam.php">Times</a>
                <a class="dropdown-item" href="addplayer.php">Maratonista</a>
                <!-- <div class="dropdown-divider"></div> -->
                <a class="dropdown-item" href="addproblem.php">Problemas</a>
              </div>
            </li>

          </ul>
        </div>
      </nav>



          <div class="container-fluid">
            <div class="p-3 mb-1 text-center" >
              <table style="width:100%">
                <tr>
                  <th><h2>Cadastro do maratonista</h2></th>
                </tr>
              </table>
              <br><br>
            </div> <!-- <div class="p-3 mb-1 text-center" > -->
<!------------------------------------------------------------------------------>
<form>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@exemplo.com">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Senha</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="Senha">
    </div>
  </div>
</form>

<!--------------------------------------------------------------------------------->



<!------------------------------------------------------------------------------>

      <div class="container">
                <?php

                                $sql = 'SELECT * FROM login;';
                                $result   = execQuery($sql);
                                if ($result->num_rows > 0) {
                                  echo '  <table class="table table-striped table-hover">';
                                  echo '<thead>';
                                  echo '<tr>';
                                  echo '<th scope="col">#</th>';
                                  echo '<th scope="col">Maratonista</th>';
                                  echo '<th scope="col">&nbsp;</th>';
                                  //echo '<th scope="col">Editar</th>';
                                  echo '</tr>';
                                  echo '</thead>';
                                  echo '<tbody>';

                                  $index = 1;
                                  while($row = $result->fetch_assoc()) {
                                    //<div class="modal-footer"> <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-danger">Delete</button> </div>
                                    echo '<tr>';
                                      echo '<td>'. $row['id'] .  '</td>';
                                      echo '<td>'. $row['name'] .  '</td>';
                                      //echo '<td> <input type="checkbox" id="id_delteam_' . $index . '" name="id_delteam_' . $index . '"> </td>';
                                      echo '<td> <button onclick="deletePlayer('. $row['id'] .  ')" type="button" id="id_deletePlayer_' . $index . '" name="id_delteam_' . $index . '" class="btn btn-danger">Apagar</button> </td>';
                                    echo '</tr>';
//                                          echo '<tr> <td>' . $row['id'] .  '</td> <td> ' .  $row['name'] . '</td> <td> <input type="checkbox" id="id_delteam_' . $index . '" name="id_delteam_' . $index . '"> </td>';
                                  }//end-if($row = $result->fetch_assoc()) {
                                    echo '</tbody>';
                                  echo '</table>';
                                  echo '<br>';
                                  echo '<input type="hidden" id="id_index_value"  name="numberrow" value="' . ($index-1) . '">';
                                }//end-
                   ?>
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
