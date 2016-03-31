<?php
/**
 * Created by PhpStorm.
 * User: stefvangils
 * Date: 31/03/16
 * Time: 16:50
 */

//if(isset($_POST['submit'])){
    $musername = "root";
    $mpassword = "Rscanderlecht1993";
    $hostname = "localhost";
    $db = "thesis";
    $port = 3306;
    $dbh=new PDO('mysql:dbname='.$db.';host='.$hostname.";port=".$port,$musername, $mpassword);/*Change The Credentials to connect to database.*/
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $email = $request->email;
    $password = $request->password;
    if(email!='' && $password!=''){

        $sql=$dbh->prepare("SELECT COUNT(*) FROM `users` WHERE `username`=?");
        $sql->execute(array($email));
        if($sql->fetchColumn()!=0){
            echo "EXISTS";
        }else{
            function rand_string($length) {
                $str="";
                $chars = "subinsblogabcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $size = strlen($chars);
                for($i = 0;$i < $length;$i++) {
                    $str .= $chars[rand(0,$size-1)];
                }
                return $str; /* http://subinsb.com/php-generate-random-string */
            }
            $p_salt = rand_string(20); /* http://subinsb.com/php-generate-random-string */
            $site_salt="subinsblogsalt"; /*Common Salt used for password storing on site.*/
            $salted_hash = hash('sha256', $password.$site_salt.$p_salt);
            $sql=$dbh->prepare("INSERT INTO `Users` (`id`, `email`, `password`, `psalt`) VALUES (NULL, ?, ?, ?);");
            $sql->execute(array($email, $salted_hash, $p_salt));
            echo "SUCCESS";
        }
    }else {
        echo "ERROR";
    }
//}