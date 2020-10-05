<?php
include 'db.php';

//$dataPOST = trim(file_get_contents('php://input'));
$xmlData =  simplexml_load_file('2020_10_04-18_30_07.xml');
if ($xmlData->count() < 1)
    return;
/*
$fileName = date("Y_m_d-H_i_s", time()) . ".xml";
$handle = fopen($fileName, "w+");
fwrite($handle,  $xmlData->asXML());
fclose($handle);
  */  
//$handle = fopen('log.txt', "a+");
$records = $xmlData->children();

for ($i = 0; $i < $xmlData->count(); $i++){
    //print_r((string) $records[$i]['id']);

    $id     = (string)$records[$i]['id'];
    $answer = (string)$records[$i]['answer'];
    $elapsedtime = (string)$records[$i]['elapsedtime'];
    $sql = 'UPDATE submission SET  answer = "'. $answer .'", elapsedtime = "'. $elapsedtime .'" WHERE id = "'. $id .'" ' . $i . ' <<<< ';
    echo $sql . PHP_EOL;




}//end-for ($i = 0; $i < $xmlData->count(); $i++){
  //  fclose($handle);
echo PHP_EOL;
?>