<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/03/16
 * Time: 20:10
 */
include_once '../Database.php';
$conn = getDatabase();

session_start();
$id = $_SESSION['user'];
$app = $_GET['app'];


$query = "SELECT code FROM Apps WHERE name = '$app'";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$appID =  $row['code'];


$query = "SELECT * FROM OwnsApplication WHERE user = '$id' AND app = '$appID'";
$result = mysql_query($query);

if(mysql_num_rows($result) >0){
    echo "GRANTED";
}else {
    echo "ILLEGAL";
}

