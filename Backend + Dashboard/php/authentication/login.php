<?php
session_start();

if(isset($_SESSION['user']) && $_SESSION['user']!=''){
    //header("Location:home.php");
    echo "Correct";
}

$dbh=new PDO('mysql:dbname=thesis;host=localhost', 'root', 'Rscanderlecht1993');/*Change The Credentials to connect to database.*/

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$email = $request->email;
$password = $request->password;

if($email!='' && $password!=''){
    $sql=$dbh->prepare("SELECT id,password,psalt FROM Users WHERE email=?");
    $sql->execute(array($email));
    while($r=$sql->fetch()){
        $p=$r['password'];
        $p_salt=$r['psalt'];
        $id=$r['id'];
    }
    $site_salt="subinsblogsalt";/*Common Salt used for password storing on site. You can't change it. If you want to change it, change it when you register a user.*/
    $salted_hash = hash('sha256',$password.$site_salt.$p_salt);
    if($p==$salted_hash){
        $_SESSION['user']=$id;
       // header("Location:overview.html");
        echo "Correct";
    }else{
        echo "Username/Password is Incorrect.";
    }
}
?>