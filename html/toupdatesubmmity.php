<?php
include 'db.php';

$dataPOST = trim(file_get_contents('php://input'));
$xmlData = simplexml_load_string($dataPOST);
if ($xmlData->count() < 1)
    return;

//$handle = fopen('log.txt', "a+");
$records = $xmlData->children();

for ($i = 0; $i < $xmlData->count(); $i++){
    //print_r((string) $records[$i]['id']);

    $id     = (string)$records[$i]['id'];
    $answer = (string)$records[$i]['answer'];
    $elapsedtime = (string)$records[$i]['elapsedtime'];
    $sql = 'UPDATE submission SET  answer = "'. $answer .'", elapsedtime = "'. $elapsedtime .'" WHERE id = "'. $id .'" ';
    $result   = execQuery($sql);
//    fwrite($handle,  $sql . PHP_EOL);
    
}//end-for ($i = 0; $i < $xmlData->count(); $i++){

//fclose($handle)    ;

?>