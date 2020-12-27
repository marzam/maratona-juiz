<?php
//include 'db.php';
include 'p-judge-lib.php';
$strCSV = $_POST['idCSV'];
//echo '[' . $strCSV . '] <hr>';

$field = explode(';', $strCSV);
$i = 0;
$error = 0;
while (($field[$i] != '') && ($error == 0)){
    $id              = trim($field[$i]);
    $answer          = trim($field[$i+1]);
    $elapsedtime    = '000'+trim($field[$i+2]);
    $recInfo         = trim($field[$i+3]);
    $pElapsedtime     = '000'+trim($field[$i+4]);
    //echo '>>>>>' . $pElapsedtime  . '<hr>';
    //echo '>>>>>' . $elapsedtime   . '<hr>';
    if ($pElapsedtime > 0)
        $score           =  $elapsedtime / $pElapsedtime;
    else{
        $score = '1';
        $pElapsedtime = $elapsedtime;
    }
        
    $i+=5;
    $sql = 'UPDATE submission SET  score = "' .$score .'", answer = "'. $answer .'", elapsedtime = "'. $pElapsedtime .'", info = "'.$info.'" WHERE id = "'. $id .'" ';
//    echo $sql .'<hr>';
    $result   = execQuery($sql);
    if ($result != 0)
        $error = 0;
    else $error = 1;

}
echo '<script>';

if ($error != 0){
    echo 'alert("Error na atualização!");';
}
echo 'window.open("mainjudge.php","_self")';
echo '</script>';

/*
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
*/
//echo ' <script type="text/javascript"> window.open("mainjudge.php", "_self"); </script>';

?>