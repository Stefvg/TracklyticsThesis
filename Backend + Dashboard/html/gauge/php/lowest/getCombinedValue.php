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

$query = "SELECT name,lowest FROM GaugeAgg_View WHERE appName='$app' AND type='$type'";
$result = mysql_query($query);

$aggArray = array();
while ($row = mysql_fetch_assoc($result)) {
    if ($row['name']) {
        $temp = $aggArray[$row['name']];


        if($temp){
            if($temp['lowest'] < $row['lowest']){
                $object['lowest'] = $temp['lowest'];
            }
        }else {
            $object['lowest'] = $row['lowest'];
        }

        $object['name'] = $row['name'];


        $aggArray[$row['name']] = $object;
    }
}

$query = "SELECT name,value FROM Gauge_View WHERE appName='$app' AND type='$type' GROUP BY name ORDER BY value";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$array = array();

$arrayToGetMedianFrom = array();
while ($row = mysql_fetch_assoc($result)) {

    if(!$arrayToGetMedianFrom[$row['name']]){
        $arrayToGetMedianFrom[$row['name']] = array($row['value']);
    }else {
        $tempArray = $arrayToGetMedianFrom[$row['name']];
        array_push($tempArray, $row['value']);
        $arrayToGetMedianFrom[$row['name']] = $tempArray;
    }
}

foreach ($arrayToGetMedianFrom as $key => $value) {
    $tempArray = $value;

    $aggregate = $aggArray[$key];

    if($aggregate && $aggregate['lowest'] < $tempArray[0]){
        $object['lowest'] = $aggregate['lowest'];
    }else {
        $object['lowest'] = $tempArray[0];
    }

    $object['name'] = $key;
    unset($aggArray[$key]);
    array_push($array, $object);

    $object =[];
}

foreach($aggArray as $row) {

    $object['name'] = $row['name'];
    $object['lowest'] = $row['lowest'];
    array_push($array, $object);
}

$output[$number] = $array;

echo(json_encode($array));


?>