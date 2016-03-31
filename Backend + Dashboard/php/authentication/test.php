<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/03/16
 * Time: 18:59
 */

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$email = $request->email;
$pass = $request->password;

echo $email;