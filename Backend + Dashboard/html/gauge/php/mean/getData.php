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


$query = "SELECT name,mean,numberOfMeasurements FROM GaugeAgg_View WHERE appName='$app' AND type='$type' AND version='$version'";
$result = mysql_query($query);
$aggArray = array();
while ($row = mysql_fetch_assoc($result)) {
    if ($row['name']) {
        $temp = $aggArray[$row['name']];

        if($temp){
            $object['mean'] = (doubleval($row['mean']) * intval($row['numberOfMeasurements']) + $temp['mean'] * $temp['numberOfMeasurements']) / (intval($row['numberOfMeasurements']) + $temp['numberOfMeasurements']);
            $object['numberOfMeasurements'] = intval($row['numberOfMeasurements']) + $temp['numberOfMeasurements'];
        }else {
            $object['mean'] = doubleval($row['mean']);
            $object['numberOfMeasurements'] = intval($row['numberOfMeasurements']);
        }

        $object['name'] = $row['name'];


        $aggArray[$row['name']] = $object;
    }
}



$query = "SELECT name,AVG(value) as mean, COUNT(*) as count FROM Gauge_View WHERE appName='$app' AND type='$type' AND version='$version' GROUP BY name";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$array = array();

while ($row = mysql_fetch_assoc($result)) {
    if ($row['name']) {
        $aggregate = $aggArray[$row['name']];

        $count = $row['count'];
        $mean = doubleval($row['mean']);

        if ($aggregate) {
            $object['mean'] = ($mean * $count + $aggregate['mean'] * $aggregate['numberOfMeasurements']) / ($count + $aggregate['numberOfMeasurements']);

        } else {
            $object['mean'] = $mean;
        }


        $object['name'] = $row['name'];
        unset($aggArray[$row['name']]);
        array_push($array, $object);
    }
}

foreach($aggArray as $row) {

        $object['name'] = $row['name'];
        $object['mean'] = doubleval($row['mean']);
        array_push($array, $object);
}

//$output['number'] = $number;
//$array = array_unique($array);
$output[$number] = $array;

echo(json_encode($output));


?>