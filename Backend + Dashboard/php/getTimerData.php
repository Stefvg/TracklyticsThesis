<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/10/15
 * Time: 16:27
 */

include_once 'Database.php';
$conn = getDatabase();

$number = $_GET['number'];
$type = $_GET['type'];
$app = $_GET['app'];

$query = "SELECT name, AVG(durationTime) AS durationTime, SUM(numberOfMeasurements) AS numberOfMeasurements, device FROM TimerAgg_View WHERE type='$type' AND appName='$app' GROUP BY name, device ORDER BY name ASC";
$result = mysql_query($query);
$aggArray = array();
while ($row = mysql_fetch_assoc($result)) {
    $object['name'] = $row['name'];
    $object['durationTime'] = doubleval($row['durationTime']);
    $object['numberOfMeasurements'] = intval($row['numberOfMeasurements']);
    $object['device'] = $row['device'];
    $aggArray[$row['name']][$row['device']] = $object;
}

$query = "SELECT * FROM Timer_View WHERE type='$type' AND appName='$app'";
$result = mysql_query($query);
$count = mysql_num_rows($result);

$query = "SELECT name, AVG(durationTime) AS durationTime, device FROM Timer_View WHERE type='$type' AND appName='$app' GROUP BY name, device ORDER BY name ASC";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


$array = array();




while ($row = mysql_fetch_assoc($result)) {
    $aggregate = $aggArray[$row['name']][$row['device']];



    $object['name'] = $row['name'];
    if($aggregate){
        $object['durationTime'] = (doubleval($row['durationTime']) * $count + $aggregate['durationTime'] * $aggregate['numberOfMeasurements'])/ ($count + $aggregate['numberOfMeasurements']);
    }else {
        $object['durationTime'] = doubleval($row['durationTime']);
    }
    $object['device'] = $row['device'];

    unset($aggArray[$row['name']][$row['device']]);
    array_push($array, $object);
}

foreach($aggArray as $aggregate) {
    foreach ($aggregate as $row) {

        $object['name'] = $row['name'];
        $object['durationTime'] = doubleval($row['durationTime']);
        $object['device'] = $row['device'];
        array_push($array, $object);
    }
}


//$output['number'] = $number;
$output[$number] = $array;

echo(json_encode($output));


?>