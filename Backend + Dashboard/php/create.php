<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/03/16
 * Time: 21:11
 */

include_once 'Database.php';
$conn = getDatabase();

session_start();
$id = $_SESSION['user'];
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$name = $request->name;

$query = "SELECT * FROM Apps WHERE name='$name'";
$result = mysql_query($query);
if(mysql_num_rows($result) > 0){
    echo json_encode(array("ILLEGAL"));
}else {
    $query = "INSERT INTO Apps(name) VALUES('$name')";
    $result = mysql_query($query);
    $insertedID = mysql_insert_id();

    $query = "INSERT INTO OwnsApplication(user,app) VALUES('$id', '$insertedID')";
    $result = mysql_query($query);
    echo json_encode(array("SUCCESS", $insertedID));
}