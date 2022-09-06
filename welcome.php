<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bastion.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
</head>
<body>

    <script>
	Swal.fire('Congrats!','${u.g0t.m3}','success');
    </script>

    <h1 class="my-5">Hey! Good job, you powned the only account in the server, keep exploring the "Bastion" for more flags.</h1>
    <p>
        <!-- redirect to another functionality in the page --> 
        <a href="pandora.php" class="btn btn-danger m1-3">Visit our pandora box</a>
        <a href="hall.php" class="btn btn-danger m1-3">Visit our hall of fame</a>
	<a href="maintenance.php" class="btn btn-danger m1-3">Visit maintenance news</a><br><br>
        <a href="logout.php" class="btn btn-warning">Sign out</a>
	<a href="resetPassword.php" class="btn btn-warning">Reset your password</a>
    </p>
</body>
</html>
