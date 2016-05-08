<?php

include_once '../php/Database.php';
include 'MetadataManager.php';

$conn = getDatabase();

$type = $_POST['type'];
$name = $_POST['name'];
$mean = $_POST['mean'];
$numberOfMeasurements = $_POST['numberOfMeasurements'];
$date = $_POST['date'];
$UUID = $_POST['UUID'];

$databaseID = $_POST['databaseID'];

$metadataID = getMetadataID();

if($databaseID=="") {
    $query = "INSERT INTO MeterAggregate(type, mean, numberOfMeasurements, date, UUID, metadataID) VALUES('$type','$mean', '$numberOfMeasurements', '$date', '$UUID', '$metadataID')";
    $result = mysql_query($query);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
    $id = mysql_insert_id();
    echo($id . "#SUCCESS");
}else{
    $query = "UPDATE MeterAggregate SET mean='$mean', numberOfMeasurements = '$numberOfMeasurements', metadataID='$metadataID' WHERE id='$databaseID'";
    $result = mysql_query($query);

    echo($databaseID . "#SUCCESS");
}

?>