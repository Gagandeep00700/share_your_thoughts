<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "syt_users");
if (!isset($_SESSION['userId'])) {
    header('location: signin.html');
}
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();

    // Redirect or display a message
    header("Location: login.html");
    exit;
}
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;
if($post_id)
{
    if($action==='like')
    {
        $liking=mysqli_query($conn,"update thoughts set like_count=like_count+1 where thought_id=$post_id");
        $_SESSION['likes'][$post_id] = true;
        header("Location: index.php");
        exit();
        
    }elseif($action === 'dislike')
    {
        $disliking=mysqli_query($conn,"update thoughts set like_count=like_count-1 where thought_id=$post_id");
        unset($_SESSION['likes'][$post_id]);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Your Thoughts</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <header>
        <div class="nav_div">
            <nav class="nav_bar">
                <img src="logo.webp" class="h-[30px] rounded-xl">
                <ul class="unordered_list">
                    <li>Home</li>
                    <li><a href="create_post.html">create_post</a></li>
                    <li>
                        <form action="profile.php" method="get"><input type='hidden' name='user_id' value=<?php echo "$_SESSION[userId]";?>><button type="submit">profile</button></form>
                    </li>
                    <li><a href="yourposts.php">yourposts</a></li>
                    <li><form id='logout' action="" method='post'><button name="logout" type="submit">Logout</button></form></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="card">
            <?php
            if (!isset($_SESSION['likes'])) {
                $_SESSION['likes'] = [];
            }
            $is_following=mysqli_query($conn,"select * from followers where follower_id=$_SESSION[userId]");
            $is_followingArr=mysqli_fetch_all($is_following);
            if(!$is_following)
            {
                mysqli_error($conn);
            }
            $query = mysqli_query($conn, "select * from thoughts");
            if (mysqli_num_rows($query) > 0) {
                $key=0;
                while ($result = mysqli_fetch_assoc($query)) {
                    $id = "$result[user_id]";
                    $username = mysqli_fetch_assoc(mysqli_query($conn, "select email from users where userId=$id"));
                    $thought_id=$result['thought_id'];
                    $like_count=mysqli_num_rows(mysqli_query($conn,"select * from likes where thought_id=$thought_id"));
                    $user_id=$result['user_id'];
                    $key++;
                    echo "<div class='inner-div'>
                    <form action='profile.php' method='get'><button type='submit'><img src='logo.webp' alt='Technical issue'></button><input type='hidden' name='user_id' value='$user_id'></form>
                                        <h7>$username[email]</h7>
                                        <p id=\"thought-$key\" onclick=\"copy(thought-$key)\">$result[Thought_txt];</p>
                                        <form action='likes.php' method='get'> <input type='hidden' name='post_id' value='$thought_id'>";
                                        echo  "<button id='like_btn' name='action' value='like'>&#10084;$like_count</button></form>";
                                        echo "<form action='follower.php' method='get'><input type='hidden' name=follower_id value=$_SESSION[userId]><input type='hidden' name=followee_id value=$user_id>";
                                        $searchKey = $user_id;
                                        $filteredData = array_filter($is_followingArr, function($row) use ($searchKey) {
                                                            return $row['2'] === $searchKey; 
                                                         });
                                        if($filteredData)
                                        {
                                            echo  "<button type='submit' id='follow'>following</button></form>";
                                        }else
                                        {
                                            echo "<button type='submit' id='follow'>follow</button></form>";
                                        }        
                                         echo "<button id='copy'>copy</button>";
                                        echo "</div>";       
                }
            }
            ?>
<script type="text/javascript">
            function copy(key) {
            var textElement = document.getElementById(key);
            var tempInput = document.createElement('input');
            tempInput.value = textElement.innerText.trim(); // Use innerText instead of textContent
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Copied: ' + tempInput.value);
        }

</script>
</div>
        
    </main>
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Share Your Thoughts. All rights reserved.</p>
            <p>
                Designed and developed by <a href="#">Gagandeep</a>.
            </p>
            <ul class="footer-links">
                <li><a href="#about">About Us</a></li>
                <li><a href="#privacy">Privacy Policy</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </footer>
</body>

</html>