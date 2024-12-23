<?php
session_start();
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer();
$conn=mysqli_connect('localhost','root','','syt_users');
$email=$_REQUEST['email'];
$pass=$_REQUEST['password'];
$semail=mysqli_real_escape_string($conn,$email);//password_hash($password, PASSWORD_BCRYPT);
$spass=password_hash(mysqli_real_escape_string($conn,$pass),PASSWORD_BCRYPT);
$query=mysqli_query($conn,"select * from users where email='$semail'");
if(mysqli_num_rows($query)>0)
{
    die("this email is already registered in our db");
}
//|-------------------------------------------------------------| for filtering wrong inputs
if(!$conn)                  
{
    die("connection establisment fail");
}
if(empty($semail) && empty($spass))
{
    die('YOU ENTER EMPTY EMAIL OR PASSWORD');
}
if (!filter_var($semail, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address.');
}
//|--------------------------------------------------------------|
$token=bin2hex(random_bytes(16));
$expires_at=date('Y-m-d H:i:s', strtotime('+1 hour'));
$query=mysqli_query($conn,"insert into email_verification(email,token,password,expires_at) values('$email','$token','$spass','')");
if (!$query) {
    die("Database insertion failed: " . mysqli_error($conn));
}
try
{
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Change this to your SMTP host (e.g., for Gmail, use 'smtp.gmail.com')
    $mail->SMTPAuth = true;
    $mail->Username = '';  // Replace with your SMTP username
    $mail->Password = '';  // Replace with your SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; // Port 587 is used for TLS

    // Set email details
    $mail->setFrom('gagankakar74@gmail.com', 'Syt_verification');  // Your email and name
    $mail->addAddress("$semail", "$semail");  // Recipient email and name
    $mail->Subject = 'Syt Web App verfication';
    $mail->Body= "verify ur link if u resgistered for syt http://localhost/img/Social/verify.php?email=$semail&token=$token Do Not Share This Link With Anyone ";
    $mail->AltBody = '';
    $mail->send();
    echo "Check your gmail account for verification";
}catch(Exception $s)
{
    echo $s;
}
   mysqli_close($conn);
?>
