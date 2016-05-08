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

$query = "SELECT DISTINCT device FROM Meter_View WHERE type='$type' AND appName='$app' AND version='$version' ORDER BY device ASC";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


$array = array();

while ($row = mysql_fetch_assoc($result)) {
    array_push($array, $row['device']);
}
$query = "SELECT device FROM MeterAgg_View WHERE type='$type' AND appName='$app' AND version='$version'";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

while ($row = mysql_fetch_assoc($result)) {
    array_push($array, $row['device']);
}

sort($array);
$output[$number] = array_unique($array);
echo(json_encode($output));


?>