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

$query = "SELECT name,median, numberOfMeasurements FROM GaugeAgg_View WHERE appName='$app' AND type='$type'";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    if($row['name']){
        $medArray = array();
        $numberOfMeasurements = $row['numberOfMeasurements'];
        $median = $row['median'];
        for($i=0; $i<$numberOfMeasurements; $i++){
            array_push($medArray, $median);
        }
        if(!$arrayToGetMedianFrom[$row['name']]){
            $arrayToGetMedianFrom[$row['name']] = $medArray;
        }else {
            $tempArray = $arrayToGetMedianFrom[$row['name']];
            $tempArray = array_merge($tempArray, $medArray);
            sort($tempArray);

            $arrayToGetMedianFrom[$row['name']] = $tempArray;
        }


    }
}


foreach ($arrayToGetMedianFrom as $key => $value) {
    $tempArray = $value;
    $index = round(sizeof($tempArray)/2, 0, PHP_ROUND_HALF_DOWN);


    $object['name'] = $key;
    $object['median'] = $tempArray[$index];
    array_push($array, $object);

    $object =[];
}

echo(json_encode($array));
//echo(json_encode($arrayToGetMedianFrom));

?>