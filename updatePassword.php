<?php
// Initialize the session
session_start();
 
if(isset($_REQUEST["maintenance"]) && $_REQUEST["maintenance"] === "true"){
    header("location: resetPassword.php?error=1");
    exit;
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

require_once 'connect.php';

$username = $_SESSION["username"];
unset($_SESSION['username']);
$newPassword = base64_encode($_REQUEST['password']);
$_SESSION["flagChange"]="$". "1s.th1s.l3g4l?";

//Prepare sql 
$sql = "UPDATE Users_private_info SET Password = '";
$sql .= $newPassword . "' WHERE Loginname = '" . $username . "'"; 

//Execute it
mysqli_query($link, $sql);
header("location: index.php");
?>
