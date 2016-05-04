<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 30/03/16
 * Time: 14:47
 */

include_once 'Database.php';

$conn = getDatabase();

$appCode = $_GET['app'];
$enabled = $_GET['value'];
$query = "UPDATE Apps SET shouldSaveOnDisk='$enabled' WHERE name='$appCode'";
$result = mysql_query($query);


