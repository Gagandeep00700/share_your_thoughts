<?php
$conn=mysqli_connect("localhost","root","","syt_users");
session_start();
$user_id=$_SESSION['userId'];
$thought_id=$_GET['post_id'];
is_liked($conn,$user_id,$thought_id);
    function is_liked($conn,$user_id,$thought_id)
    {
        $query=mysqli_query($conn,"select * from likes where user_id=$user_id and thought_id=$thought_id");
        if(!$query)
        {
            echo mysqli_errno($conn);
        }
        if(mysqli_num_rows($query)>0)
        {
            $query1=mysqli_query($conn,"delete from likes where user_id=$user_id and thought_id=$thought_id");
            if($query1)
            {
                header('location: index.php');
            }else{
                echo mysqli_error($conn);   
            }
        }
        else{
            $query2=mysqli_query($conn,"insert into likes(id,user_id,thought_id,created_at) values(NULL,$user_id,$thought_id,CURRENT_TIMESTAMP)");
            if($query2)
            {
                header('location: index.php');
            }
            else{
                echo mysqli_error($conn);
            }
        }
    }
?>