<?php

include_once '../php/Database.php';
include 'MetadataManager.php';

$conn = getDatabase();

$type = $_POST['type'];
$name = $_POST['name'];
$value = $_POST['value'];
$date = $_POST['date'];
$UUID = $_POST['UUID'];

$numberOfMeasurements = $_POST['numberOfMeasurements'];
$mean = $_POST['mean'];
$median = $_POST['median'];
$lowest = $_POST['lowest'];
$highest = $_POST['highest'];

$databaseID = $_POST['databaseID'];
$metadataID = getMetadataID();

if($databaseID=="") {
    $query = "INSERT INTO GaugeAggregate(type, name, UUID, date, metadataID, numberOfMeasurements, mean, median, lowest, highest) VALUES('$type','$name', '$UUID', '$date', '$metadataID', '$numberOfMeasurements', '$mean', '$median', '$lowest', '$highest')";
    $result = mysql_query($query);
    $id = mysql_insert_id();
    echo($id . "#SUCCESS");
}else {
    $query = "UPDATE GaugeAggregate SET numberOfMeasurements='$numberOfMeasurements', mean='$mean', median = '$median', lowest = '$lowest', highest = '$highest', metadataID='$metadataID' WHERE id='$databaseID'";
    $result = mysql_query($query);

    echo($databaseID . "#SUCCESS");
}


?>