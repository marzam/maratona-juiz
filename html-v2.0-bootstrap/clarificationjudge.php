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
                <a class="nav-link" href="mainjudge.php">Jugar</a>
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
              <a class="nav-link" href="#">[Dúvidas]<span class="sr-only"></span></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="score-judge.php">Pontuação</a>
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
              <!-- begin content --------------------------------------------------------------------------------------------------- -->
              <!-- Any button on top and right position - any event -->
              <!--
              <div  class="d-flex flex-row-reverse pt-2">
                <button class = "btn btn-sm btn-dark btn-block " type="button" onclick="updateSubmissionsCSV();">Voltar</button>
              </div> -->

<!--- Inserting content -->

          <h3 align="center"> Esclarecimento </h3>
           <table >
             <!--
             <colgroup>
                <col style="width:50%;">
                <col style="width:50%;">
             </colgroup>
           -->
             <?php

               $index = 1;
               $sql = 'SELECT id, doubt, answer FROM clarification WHERE answered = "0" ORDER BY datetime ASC;';
               $result   = execQuery($sql);

               if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                   $bgColor = '#dfdfdf';
                   if (($index % 2) == 0)
                    $bgColor = '#d0d0d0';

                   $idopt = 'id_doubt_' . $index;
                   echo '<tr bgcolor="'. $bgColor .'" > <td  align="justify">' . $row['doubt'] .  '</a> </td> <td align="justify">  <input type="hidden" id="' . $idopt . '" name="' . $idopt . '" value="' . $row['id'] . '"> <input type="checkbox" id="id_check_'.$index.'" name="id_check_'.$index.'"  onclick="checkboxClickJudgeClarrification(this);" />&nbsp; </td>  </tr>';
                  $index += 1;
                 }//end-if($row = $result->fetch_assoc()) {

               }//end-if ($result->num_rows > 0) {
               $index -= 1;
             ?>
           </table>
           <?php
              echo '<input type="hidden" id="id_numberrow" name="numberrow" value="'. $index .'">';
           ?>
           <br>
           <form action="saveclarificationjudge.php"  method="post">
             <?php echo '<input type="hidden" id="id_user" name="id_user" value="'. $id . '">'; ?>
             <textarea id="id_answer" rows = "5" cols = "82"  maxlength = "2048"  name = "id_answer"  style="resize: none;"></textarea><br>
             <input type="hidden" id="id_answerCheck" name="id_answerCheck" value="-1">
             <input id="id_submit" type="submit" value="Enviar">
             <!-- <button  type="button" onclick="onSubmit();">Enviar</button> -->
             <button id="id_clear" type="button" onclick="onClearJudgeClarrification();">Limpa</button>

           </form>


<!--- End inserting content -->


          </div> <!-- <div class="container-fluid"> -->
    </div><!-- <div id="page-content-wrapper"> -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script> $("#menu-toggle").click(function(e) { e.preventDefault(); $("#wrapper").toggleClass("toggled"); }); </script>

  </div> <!-- <div class="d-flex" id="wrapper"> -->





</body>

</html>
