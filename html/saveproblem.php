
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  
  <body >

<?php
   // echo 'Salvando problemas! <br>';
    include 'db.php';

    $problem_dir = "downloads/";
    $answer_dir  = "answers/";
    $problem_id   = $_POST['id_id']; 
    $fileprefix = date('Y-m-d') . '.';
    $name = $_POST['id_name']; 
    $description = $_POST['id_description']; 
    $time = $_POST['id_time']; 
    if (isset($_POST['id_visible']) && $_POST['id_visible'] == 'Yes'){
        $visible = '1';
    }else{
        $visible = '0';
    }
    if ($_FILES['id_file_problem']['name'] != '' ){
        $file = $problem_dir . $fileprefix . $_FILES['id_file_problem']['name'];
        move_uploaded_file($_FILES['id_file_problem']['tmp_name'], $file);
    }else
        $file = '';
    
    $input_hpc = $_POST['id_parametros_hpc']; 

    $stdout  = $_POST['id_output']; 
    $input  = '';
    $output = '';

    if ($stdout == 'file'){
        $input = $_POST['id_output_file_in'];
        if ($_FILES['id_output_file_out']['name'] != ''){
            $output = $answer_dir . $fileprefix . $_FILES['id_output_file_out']['name'];
            move_uploaded_file($_FILES['id_output_file_out']['tmp_name'], $output);
        }else
            $output = '';
    
        
    }else{
        $input = $_POST['id_output_video_in'];
        $output = $_POST['id_output_video_out'];
    }

    $sql = '';
    if ($id == '-1'){   
        $sql = 'INSERT INTO problem (name, description, time, visible, file, inputHPC, stdout, input, output) VALUES ';
        $sql .= '("' . $name . '", "' . $description . '", "' . $time . '", "' . $visible . '", "' . $file . '", "' . $input_hpc . '", "' . $stdout . '", "' . $input . '", "' . $output . '");';
    }else{
        if ($_POST['id_deloutput']=='no'){
            $sql = 'UPDATE  problem SET name = "' . $name . '" , description = "' . $description . '", time = "' . $time . '", visible = "' . $visible . '", ';
            if ($file != '')
                $sql .= 'file = "' . $file . '",';
            
            $sql .=  'inputHPC = "' . $input_hpc . '", stdout =  "' . $stdout . '", ';
            if ($output != '')
                $sql .= 'output = "' . $output . '", '; 
            
            $sql .=  ' input = "' . $input . '" WHERE ID ="'.$problem_id.'";';
        }
        else{
            $sql = 'DELETE FROM problem WHERE ID ="'.$problem_id.'";';
        }//end-if ($_POST['']=='no'){
        
    }//end-if ($id == '-1'){   

    
    $result   = execQuery($sql);

    echo 'SQL: ' . $sql . '<br><hr>';
/*
    echo 'Now:       '. date('Y-m-d') ."\n";
    echo $_POST['id_visible'];
    echo $_POST['id_id'];
    echo $_POST['id_name'];

 */
/*
    echo '<h1>Problema cadastrado</hr><br>';
    usleep(2000000);
    */
    echo '<script>';    
    echo '      window.open("mainjudge.php","_self");';
    echo '</script>';

?>
</body >