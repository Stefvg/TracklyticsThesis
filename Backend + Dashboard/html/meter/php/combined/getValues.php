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
$number = $_GET['number'];
$number2 = $_GET['number2'];
$number3 = $_GET['number3'];

$type = $_GET['type'];
$date = $_GET['date'];
$device = $_GET['device'];
$version = $_GET['version'];

if(strlen($date) <= 10){
    $query = "SELECT value FROM Meter_View WHERE type='$type' AND date='$date' AND device='$device' AND version='$version' AND appName='$app'";
}else {
    $nextDate = strtotime($date) + 3*3600;
    $nextDate = date("Y-m-d H:i:s", $nextDate);
    $query = "SELECT value FROM Meter_View WHERE type='$type' AND date >= '$date' AND date <= '$nextDate' AND device='$device' AND version='$version' AND appName='$app'";
}

$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$tempAverage = 0;
$count = 0;
while ($row = mysql_fetch_assoc($result)) {
    $mean = $row['value'];
    $tempAverage = ($count*$tempAverage + $mean) / ($count + 1);
    $count = $count + 1;
}

if(strlen($date) <= 10){
    $query = "SELECT mean, numberOfMeasurements FROM MeterAgg_View WHERE type='$type' AND date='$date' AND device='$device' AND version='$version' AND appName='$app'";
}else {
    $nextDate = strtotime($date) + 3*3600;
    $nextDate = date("Y-m-d H:i:s", $nextDate);
    $query = "SELECT mean, numberOfMeasurements FROM MeterAgg_View WHERE type='$type' AND date >= '$date' AND date <= '$nextDate' AND device='$device' AND version='$version' AND appName='$app'";
}


$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    $mean = $row['mean'];
    $numberOfMeasurements = doubleval($row['numberOfMeasurements']);
    if($numberOfMeasurements && $numberOfMeasurements>0){
        $tempAverage = ($count*$tempAverage + $mean*$numberOfMeasurements) / ($count + $numberOfMeasurements);
        $count = $count + $numberOfMeasurements;
    }
}

$object['avg'] = $tempAverage;

$object['number2'] = $number2;
$object['number3'] = $number3;
$output[$number] =  $object;

echo(json_encode($output));


?>