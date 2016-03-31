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

$query = "SELECT code FROM Apps WHERE name='$app'";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}


$array = array();

$row = mysql_fetch_assoc($result);
echo($row['code']);


?>