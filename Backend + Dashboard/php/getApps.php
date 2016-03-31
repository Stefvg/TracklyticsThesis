<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/10/15
 * Time: 16:27
 */

include_once 'Database.php';
$conn = getDatabase();

session_start();
$id = $_SESSION['user'];

$query = "SELECT A.name FROM Apps AS A WHERE EXISTS(SELECT * FROM OwnsApplication WHERE A.code = app AND user = '$id') ORDER BY A.name ASC";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


$array = array();

while ($row = mysql_fetch_assoc($result)) {
    array_push($array, $row['name']);
}

echo(json_encode($array));


?>