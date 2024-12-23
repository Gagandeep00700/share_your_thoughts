<?php
         session_start();
         $conn=mysqli_connect("localhost","root",'',"syt_users");
         $title=$_REQUEST['title'];
         $description=$_REQUEST['description'];
         $user_id=$_SESSION['userId'];
         $query="insert into thoughts(thought_id,user_id,Thought_txt,created_at) values(NULL,$user_id,'$description',CURRENT_TIMESTAMP)";
         $result=mysqli_query($conn,$query);
         if($result)
         {
           header('location: index.php');
         }
?>