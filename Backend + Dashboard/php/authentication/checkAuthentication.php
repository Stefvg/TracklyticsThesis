<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/03/16
 * Time: 19:18
 */

session_start();
if($_SESSION['user']==''){
    echo "ILLEGAL";
}else{
    echo "AUTHENTICATED";
}
