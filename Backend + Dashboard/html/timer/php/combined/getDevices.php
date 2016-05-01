<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/10/15
 * Time: 16:27
 */

include_once '../../../../php/Database.php';
$conn = getDatabase();

$app = $_GET['app'];
$type = $_GET['type'];
$version = $_GET['version'];
$number = $_GET['number'];


$query = "SELECT DISTINCT device FROM Timer_View WHERE type='$type' AND version='$version' AND appName='$app' ";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


$array = array();

while ($row = mysql_fetch_assoc($result)) {
    if($row['device'])
    array_push($array, $row['device']);
}

$query = "SELECT DISTINCT device FROM TimerAgg_View WHERE type='$type' AND version='$version' AND appName='$app' ";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}



while ($row = mysql_fetch_assoc($result)) {
    if($row['device'])
    array_push($array, $row['device']);
}
$arr = array();
foreach(array_unique($array) as $value){
    array_push($arr, $value);
}

$output[$number] = $arr;
echo(json_encode($output));


?>