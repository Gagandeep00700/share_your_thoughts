<?php
$conn=mysqli_connect("localhost","root","","syt_users");
$follower_id=$_GET['follower_id'] ? $_GET['follower_id'] :null ;
$followee_id=$_GET['followee_id'] ? $_GET['followee_id'] :
null;
if($follower_id===$followee_id)
{
    header('location: index.php');
}
function is_following($conn,$follower_id,$followee_id){
$query=mysqli_query($conn,"select * from followers where follower_id=$follower_id and followee_id=$followee_id");
if(mysqli_num_rows($query)>0)
{
    return 1;
}
}
$following=is_following($conn,$follower_id,$followee_id);
if($following)
{
    $query=mysqli_query($conn,"delete from followers where follower_id=$follower_id and followee_id=$followee_id");
    if($query)
    {
        header('location: index.php');
    }
    else{
        echo mysqli_error($conn);
    }
}
else{
    $query=mysqli_query($conn,"insert into followers(id,follower_id,followee_id,created_at) values(NULL,$follower_id,$followee_id,CURRENT_TIMESTAMP)");
    if($query)
    {
        header('location: index.php');
    }
    else{
        echo mysqli_error($conn);
    }
}
?>