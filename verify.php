<?php
session_start();
$conn=mysqli_connect('localhost','root','','syt_users');
if(!$conn)
{
    echo mysqli_connect_error();
}
$mail=$_REQUEST['email'];
$token=$_REQUEST['token'];
$time=date('Y-m-d H:i:s');
$query = "SELECT * FROM email_verification WHERE token = '$token' AND email = '$mail'";
$result=mysqli_query($conn,$query);
$array=mysqli_fetch_assoc($result);
if(mysqli_num_rows($result)>0)
{   
    $pass=$array['password'];
    $query1="insert into users(userId,email,password,created_at) values('','$mail','$pass',CURRENT_TIMESTAMP)";
    $result1=mysqli_query($conn,$query1);
    if($result1)
    {
      $query=mysqli_query($conn,"select userId from users where email='$mail'");
      $arr=mysqli_fetch_assoc($query);
      $user_id=$arr['userId'];
      $_SESSION['userId']=$user_id;
    }
    if(!$result1){
      echo mysqli_error($conn);
    }
    exit();
}
?>