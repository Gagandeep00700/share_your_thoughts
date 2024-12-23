<?php
session_start();
$conn=mysqli_connect("localhost","root","","syt_users");
$email=$_REQUEST['email'];
$pass=$_REQUEST['password'];
if(!$conn){  die("connection not successfull"); }
$query="select password from email_verification where email='$email'";
$result=mysqli_query($conn,$query);
var_dump($result);
if(mysqli_num_rows($result)>0)
{
    $passassoc=mysqli_fetch_assoc($result);
    $hashpass=$passassoc['password'];
    if(password_verify($pass,$hashpass))
    {
        $query1="select userId from users where email='$email'";
        $result1=mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1)>0)
        {
            $array=mysqli_fetch_assoc($result1);
            $id=$array['userId'];
            $_SESSION['userId']=$id;
               header('location: index.php');
               exit();
        }else{
            echo "Gmail in our database notfound please goto sign in";
        }
    }
}
else{
    echo "wrong email or pass";
}
?>