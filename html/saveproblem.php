<?php
    echo 'Salvando problemas! <br>';
    $target_dir = "uploads/";

    $id   = $_POST['id_id']; 
    $name = $_POST['id_name']; 
    $probfile = $target_file = $target_dir . basename($_FILES['id_file_problem']['name']);
    $time = $_POST['id_time']; 
    $desc = $_POST['id_description']; 
    $input_hpc = $_POST['id_parametros_hpc']; 
    $output  = $_POST['id_output']; 
    $output_in  = '';
    $output_out = '';
    if ($output == 'file'){
        $output_in = $_POST['id_output_file_in'];
        $output_out = $target_file = $target_dir . basename($_FILES['id_output_file_out']['name']);
    }else{
        $output_in = $_POST['id_output_video_in'];
        $output_out = $_POST['id_output_video_out'];
    }

    echo $_POST['id_id'];
    echo $_POST['id_name'];
?>