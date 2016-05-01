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
$type = $_GET['type'];
$device = $_GET['device'];
$query = "SELECT * FROM Timer_View WHERE type='$type' AND appName='$app'";
$result = mysql_query($query);
$count = mysql_num_rows($result);
$query = "SELECT name, AVG(durationTime) AS durationTime, SUM(numberOfMeasurements) AS numberOfMeasurements  FROM TimerAgg_View WHERE type='$type' AND device='$device'";
$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
    $object['name'] = $row['name'];
    $object['durationTime'] = doubleval($row['durationTime']);
    $object['numberOfMeasurements'] = intval($row['numberOfMeasurements']);

    $aggArray[$row['name']] = $object;
}

$query = "SELECT name,AVG(durationTime) AS durationTime FROM Timer_View WHERE type='$type' AND device='$device'";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


$array = array();

while ($row = mysql_fetch_assoc($result)) {
    if($row['name']) {
        $aggregate = $aggArray[$row['name']];
        $object['name'] = $row['name'];
        if ($aggregate) {
            $object['durationTime'] = (doubleval($row['durationTime']) * $count + $aggregate['durationTime'] * $aggregate['numberOfMeasurements']) / ($count + $aggregate['numberOfMeasurements']);
        } else {
            $object['durationTime'] = doubleval($row['durationTime']);
        }
        unset($aggArray[$row['name']]);
        array_push($array, $object);
    }
}

foreach($aggArray as $row) {


    $object['name'] = $row['name'];
    $object['durationTime'] = doubleval($row['durationTime']);
    array_push($array, $object);

}

//$output['number'] = $number;
$output[$number] = $array;

echo(json_encode($output));


?>