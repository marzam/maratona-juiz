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
                    <a class="dropdown-item" href="#">Maratonista</a>
                    <!-- <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="#">Problemas</a>
                  </div>
                </li>

              </ul>
            </div>
          </nav>



              <div class="container-fluid">

                <div class="p-3 mb-1 text-center" >
                  <table style="width:100%">
                    <tr>
                      <th><h2> Cadastro de equipes/time </h3></th>
                    </tr>
                  </table>
                  <br><br>
                  <form method="post" id="id_team" action="#" >
                    <div>
                      <div> <input id="idTeam" name="idTeam" type="text" placeholder="nome da equipe/time" required autofocus> </div>
                    </div>
                      <p class="mt-4"> <input class = "btn btn-lg btn-dark btn-block" value="Adicionar" type="submit"> </p>
                 </form>

          </div>


          <div class="container">
                    <?php

                                    $sql = 'SELECT * FROM teams;';
                                    $result   = execQuery($sql);
                                    if ($result->num_rows > 0) {
                                      echo '  <table class="table table-striped table-hover">';
                                      echo '<thead>';
                                      echo '<tr>';
                                      echo '<th scope="col">#</th>';
                                      echo '<th scope="col">Equipe</th>';
                                      echo '<th scope="col">Apagar</th>';
                                      //echo '<th scope="col">Editar</th>';
                                      echo '</tr>';
                                      echo '</thead>';
                                      echo '<tbody>';

                                      $index = 1;
                                      while($row = $result->fetch_assoc()) {
                                          echo '<tr> <td>' . $row['id'] .  '</td> <td> ' .  $row['name'] . '</td> <td> <input type="checkbox" id="id_delteam_' . $index . '" name="id_delteam_' . $index . '"> </td>';
                                      }//end-if($row = $result->fetch_assoc()) {
                                        echo '</tbody>';
                                      echo '</table>';
                                      echo '<br>';
                                      echo '<input type="hidden" id="id_index_value"  name="numberrow" value="' . ($index-1) . '">';
                                    }//end-
                       ?>

<!-- Example of table
              <table class="table table-striped table-hover">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Customer-ID</th>
                          <th>Email</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>1</td>
                          <td>John Pate</td>
                          <td>AUSXYZ1481</td>
                          <td>johnpate@mydomain.com</td>
                      </tr>
                      <tr>
                          <td>2</td>
                          <td>Gina Ray</td>
                          <td>AUSXYZ2932</td>
                          <td>ginaray@mydomain.com</td>
                      </tr>
                      <tr>
                          <td>3</td>
                          <td>Paul Smith</td>
                          <td>AUSXYZ6381</td>
                          <td>paulsmith@mydomain.com</td>
                      </tr>
                      <tr>
                          <td>4</td>
                          <td>Darryl Rob</td>
                          <td>AUSXYZ7264</td>
                          <td>darrylrob@mydomain.com</td>
                      </tr>
                      <tr>
                          <td>5</td>
                          <td>Tina Michael</td>
                          <td>AUSXYZ8330</td>
                          <td>tinamichael@mydomain.com</td>
                      </tr>
                  </tbody>
              </table>
          </div>
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
