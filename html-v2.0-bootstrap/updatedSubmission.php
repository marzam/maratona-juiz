<?php
//include 'db.php';
include 'p-judge-lib.php';
$dataPOST = trim(file_get_contents('php://input'));
$xmlData = simplexml_load_string($dataPOST);
$handle = fopen('log.txt', "a+");

//$count = $xmlData->count();
//fwrite($handle,  $count . PHP_EOL);

if ($xmlData->count() < 1)
    return;


$records = $xmlData->children();

for ($i = 0; $i < $xmlData->count(); $i++){
    //print_r((string) $records[$i]['id']);

    $id     = (string)$records[$i]['id'];
    $answer = (string)$records[$i]['answer'];
    $elapsedtime = (string)$records[$i]['elapsedtime'];
    $score = (string)$records[$i]['score'];
    //$score = $pelapsedtime / $elapsedtime
    $info = (string)$records[$i]['info'];
    $sql = 'UPDATE submission SET  score = "' .$score .'", answer = "'. $answer .'", elapsedtime = "'. $elapsedtime .'", info = "'.$info.'" WHERE id = "'. $id .'" ';
    $result   = execQuery($sql);
    fwrite($handle,  $sql . PHP_EOL);
    
}//end-for ($i = 0; $i < $xmlData->count(); $i++){

fclose($handle)    ;

//echo ' <script type="text/javascript"> window.open("mainjudge.php", "_self"); </script>';

?>