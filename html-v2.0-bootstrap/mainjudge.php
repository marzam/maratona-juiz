<?php
  include 'vars.php';
  include 'p-judge-lib.php';

  $result   = checkLoginJudge();
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        $GLOBALS['username'] = $row['username'];
        $GLOBALS['name']  = $row['name'];
        $GLOBALS['team']  = $row['team'];
      }//end-if($row = $result->fetch_assoc()) {
  }//end-if ($result->num_rows > 0) {
    //https://mdbootstrap.com/snippets/jquery/mdbootstrap/888438#
?>
<!DOCTYPE html>
<html>

        <?php printHeader(); ?>
  <body>
    <div class="p-3 mb-1 bg-dark text-white text-center" >
      <h2 > <?php echo $GLOBALS['eventTitle1']; ?> </h3>
      <h3 > <?php echo $GLOBALS['judgeTitle']; ?> </h3>
    </div>
    
    <div class="mt-1 mb-4 text-center">
      <h3>Equipe: <strong><?php echo $GLOBALS['team']; ?></strong></h3>
      <h3>Usuário: <?php echo  $GLOBALS['username']; ?></h3>
    </div>  
    <div>
      <ul>
        <li><a href="addproblem.php"> Cadastrar problema </a></li>
        <li><a href="listproblems.php"> Listar problemas </a></li>
        <li><a href="tojudge.php"> Jugar </a></li>
        <li><a href="clarificationjudge.php"> Esclarecer dúvidas </a></li>
        <li><a href="submitjudge.php"> Submissões realizadas </a></li>
        <li><a href="score-judged.php"> Pontuação </a></li>
        <!--<li><a href="reports.php"> Relatórios </a></li>-->
        <li><a href="javascript:logout()"> Sair </a></li>
      </ul>
    </div>
      <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      <a class="navbar-brand" href="#">Brand</a>
      </div>
    </nav>
    
    <!--
    <div>      <ul>
        <li><a href="problems.html"> Problemas </a></li>        <li><a href="submit.html"> Submissão </a></li>
        <li><a href="clarification.html"> Esclarecimento </a></li>        <li><a href="score.html"> Pontuação </a></li>
        <li><a href="logout.html"> Sair </a></li>      </ul>
    </div>-->

  </body>
</html>
