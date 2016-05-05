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
$number = $_GET['number'];
$device = $_GET['device'];
$version = $_GET['version'];
$versionNumber = $_GET['versionNumber'];

$min = $_GET['min'];
$max = $_GET['max'];

if($min && $max) {
    $query = "SELECT value FROM Histogram_View WHERE version = '$version' AND device = '$device' AND type='$type' AND appName='$app' AND value>='$min' AND value<='$max' ORDER BY value ASC";
}else {
    $query = "SELECT value FROM Histogram_View WHERE version = '$version' AND device = '$device' AND type='$type' AND appName='$app'  ORDER BY value ASC";
}


$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$outputArray = array();
$array = array();

while ($row = mysql_fetch_assoc($result)) {

    array_push($array, $row['value']);

}


//MEDIAN
$index = round(sizeof($array)/2, 0, PHP_ROUND_HALF_DOWN);
$object['name'] = "Median";
$object['value'] = $array[$index];
array_push($outputArray, $object);
$object =[];


//AVERAGE
$avg = 0;
foreach($array as $value){
    $avg+=$value;
}
$avg /= sizeof($array);

$object['name'] = "Average";
$object['value'] = $avg;
array_push($outputArray, $object);

//Value Difference (highest - lowest)
$difference = $array[sizeof($array)-1] - $array[0];
$object['name'] = "Value Difference between heighest and lowest";
$object['value'] = $difference;
array_push($outputArray, $object);


//Percentage less than average
$i=0;
$count = 0;
while($array[$i] < $avg && $i<sizeof($array)){
    $count++;
    $i++;
}
$object['name'] = "Percentage lower than average";
$object['value'] = $count/sizeof($array) * 100;
array_push($outputArray, $object);

//Percentage less than average
$i=sizeof($array) -1;
$count = 0;
while($array[$i] > $avg && $i>=0){
    $count++;
    $i--;
}
$object['name'] = "Percentage higher than average";
$object['value'] = $count/sizeof($array) * 100;
array_push($outputArray, $object);


//standaarddeviatie
$sdev = 0;
foreach($array as $value){
    $diff = $value - $avg;
    $sdev+=$diff*$diff;
}
$sdev /= sizeof($array);
$sdev = sqrt($sdev);
$object['name'] = "Standard Deviation";
$object['value'] = $sdev;
array_push($outputArray, $object);


$object['array'] = $outputArray;
$object['versionNumber'] = $versionNumber;
$output[$number] =  $object;


echo(json_encode($output));


?>