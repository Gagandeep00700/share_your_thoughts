<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="card">
    <?php
                $conn=mysqli_connect("localhost","root","","syt_users");
                session_start();
            if(isset($_GET['post_id']) && isset($_GET['action']))
            {
                if($_GET['action']=='delete')
                {
                    $query=mysqli_query($conn,"delete from thoughts where thought_id='$_GET[post_id]'");
                }
            }

            $query = mysqli_query($conn, "select * from thoughts where user_id=$_SESSION[userId]");
            if (mysqli_num_rows($query) > 0) {
                while ($result = mysqli_fetch_assoc($query)) {
                    $id = "$result[user_id]";
                    $username = mysqli_fetch_assoc(mysqli_query($conn, "select email from users where userId=$id"));
                    $thought_id=$result['thought_id'];
                    $like_count=$result['like_count'];
                    $is_liked = isset($_SESSION['likes'][$thought_id]);
                    $user_id=$result['user_id'];
                    echo "<div class='inner-div'>
                            <img src='logo.webp' alt='Technical issue'>
                                        <h7>$username[email]</h7>
                                        <p>$result[Thought_txt]</p>";
                                        echo "<form method='get' action=''><input type='hidden' name='post_id' value='$thought_id'><input type='hidden' name='action' value='delete'><button id='delete_post'>delete post?</button></form>";    
                                        echo "</div>";
                }
            }
            ?>
    </div>
</body>
</html>
