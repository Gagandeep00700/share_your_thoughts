<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
 <div>
    <img src="logo.webp" alt="">
    <div class='inner-div'>
        username:<?php
        $conn=mysqli_connect("localhost","root","","syt_users");
         session_start(); 
         $query=mysqli_query($conn,"select * from users where userId=$_GET[user_id]");
         if(mysqli_num_rows($query)>0)
         {
            $arr=mysqli_fetch_assoc($query);
            echo $arr['email'];
         }
        ?><br>
        followers:<?php $query=mysqli_query($conn,"select * from followers where followee_id=$_GET[user_id]");
        if($query){echo mysqli_num_rows($query);}
         ?><br>
        following:<?php $query=mysqli_query($conn,"select * from followers where follower_id=$_GET[user_id]");
        if($query){echo mysqli_num_rows($query);}
         ?><br>
        posts:<?php $query=mysqli_query($conn,"select * from thoughts where user_id=$_GET[user_id]");
        if($query){echo mysqli_num_rows($query);}
         ?><br>
         <?php if($_SESSION['userId']===$_GET['user_id'])
         {
            echo "<button>Edit Profile</button>";
         }?>
        <button id="logout">Logout</button>
    </div>
</div>
</body>
</html>