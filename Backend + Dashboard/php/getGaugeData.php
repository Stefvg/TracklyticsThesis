<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/10/15
 * Time: 16:27
 */

include_once 'Database.php';
$conn = getDatabase();

$app = $_GET['app'];
$number = $_GET['number'];
$type = $_GET['type'];


$query = "SELECT name, mean,  device, numberOfMeasurements FROM GaugeAgg_View WHERE type='$type' AND appName='$app' GROUP BY name, device ORDER BY name ASC";
$result = mysql_query($query);
$aggArray = array();
while ($row = mysql_fetch_assoc($result)) {
    if ($row['name']) {
        $object['name'] = $row['name'];
        $object['mean'] = doubleval($row['mean']);
        $object['numberOfMeasurements'] = intval($row['numberOfMeasurements']);
        $object['device'] = $row['device'];
        $aggArray[$row['name']][$row['device']] = $object;
    }
}






$query = "SELECT name, AVG(value) AS mean, device, COUNT(*) AS count FROM Gauge_View WHERE type='$type' AND appName='$app' GROUP BY name, device ORDER BY name ASC";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


$array = array();

while ($row = mysql_fetch_assoc($result)) {
    if ($row['name']) {
        $aggregate = $aggArray[$row['name']][$row['device']];

        $count = $row['count'];
        $mean = doubleval($row['mean']);

        if ($aggregate) {
            $object['mean'] = ($mean * $count + $aggregate['mean'] * $aggregate['numberOfMeasurements']) / ($count + $aggregate['numberOfMeasurements']);

        } else {
            $object['mean'] = $mean;
        }


        $object['name'] = $row['name'];
        $object['device'] = $row['device'];
        unset($aggArray[$row['name']][$row['device']]);
        array_push($array, $object);
    }
}

foreach($aggArray as $aggregate) {
    foreach ($aggregate as $row) {

        $object['name'] = $row['name'];
        $object['mean'] = doubleval($row['mean']);
        $object['device'] = $row['device'];
        array_push($array, $object);
    }
}


//$output['number'] = $number;
$output[$number] = $array;

echo(json_encode($output));


?>