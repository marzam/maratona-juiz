!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <script>
    function nextPage(){;
        window.open("mainjudge.php","_self");
    }
  </script>
  <body >

<?php
   // echo 'Salvando problemas! <br>';
    include 'db.php';
    $problem_dir = "downloads/";
    $answer_dir  = "answers/";
    $id   = $_POST['id_id']; 
    $fileprefix = date('Y-m-d') . '.';
    $name = $_POST['id_name']; 
    $description = $_POST['id_description']; 
    $time = $_POST['id_time']; 
    if (isset($_POST['id_visible']) && $_POST['id_visible'] == 'Yes'){
        $visible = '1';
    }else{
        $visible = '0';
    }
    $file = $target_file = $problem_dir . $fileprefix . $_FILES['id_file_problem']['name'];
    move_uploaded_file($_FILES['id_file_problem']['tmp_name'], $file);
    $input_hpc = $_POST['id_parametros_hpc']; 

    $stdout  = $_POST['id_output']; 
    $input  = '';
    $output = '';

    if ($stdout == 'file'){
        $input = $_POST['id_output_file_in'];
        $output = $answer_dir . $fileprefix . $_FILES['id_output_file_out']['name'];
        move_uploaded_file($_FILES['id_output_file_out']['tmp_name'], $output);
    }else{
        $input = $_POST['id_output_video_in'];
        $output = $_POST['id_output_video_out'];
    }

    $sql = '';
    if ($id == '-1'){
        $sql = 'INSERT INTO problem (name, description, time, visible, file, inputHPC, stdout, input, output) VALUES ';
        $sql .= '("' . $name . '", "' . $description . '", "' . $time . '", "' . $visible . '", "' . $file . '", "' . $input_hpc . '", "' . $stdout . '", "' . $input . '", "' . $output . '");';
    }

    $result   = execQuery($sql);
     /*   
    echo 'SQL: ' . $sql . '<br><hr>';
    echo 'Now:       '. date('Y-m-d') ."\n";
    echo $_POST['id_visible'];
    echo $_POST['id_id'];
    echo $_POST['id_name'];

 */
    echo '<h1>Problema cadastrado</hr><br>';
    echo '<script>';    
    echo 'setTimeout(nextPage(), 10000);';
    echo '</script>';

?>
</body >