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

$query = "SELECT DISTINCT version FROM Timer_View WHERE type='$type' AND appName='$app' ";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


$array = array();

while ($row = mysql_fetch_assoc($result)) {
    array_push($array, $row['version']);
}

$query = "SELECT DISTINCT version FROM TimerAgg_View WHERE type='$type' AND appName='$app' ";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


while ($row = mysql_fetch_assoc($result)) {
    array_push($array, $row['version']);
}
$arr = array();
foreach(array_unique($array) as $value){
    array_push($arr, $value);
}


echo(json_encode($arr));


?>