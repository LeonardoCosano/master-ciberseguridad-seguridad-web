<?php
if(isset($_REQUEST["error"])){
	$maintenance_err = "We are in maintenance, cant change your password right not. Try again later.";
}
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
        body{ font: 14px sans-serif; background-image: url("background2.jpg");background-attachment: fixed;background-position: center;background-color: #cccccc;}
        #container{margin: 10px;}
        .wrapper{ margin: auto; width: 600px; border: 1px solid black; padding: 20px; transform: translateY(+10%); background-color: white;}
        .stats{position:absolute;top:10px;right: 10px;}
        .btn-primary{color:#fff;background-color:#6495ED;border-color:#6495ED}
        .form-submit{  text-align: center;}
</style>
</head>
<body>

    <div class="wrapper">
        <h2><strong>Change your password here:</strong></h2>
	<br>
        <form id="changePassword" action="updatePassword.php" method="post">
            <div class="form-group">
                <label>Your new password:</label>
                <input type="text" name="password" class="form-control <?php echo (empty($maintenance_err)) ? '' : 'is-invalid'; ?>" required>
		<span class="invalid-feedback"><?php echo $maintenance_err; ?></span>
            </div>    
		<input type=hidden name="maintenance" value="true">
            <div class="form-submit">
                <input type="submit" class="btn btn-primary" value="I want to change my password">
            </div>	
        </form>
    </div>
	<br><br><br>

    <div class="stats">
	<a href="welcome.php" style = color:red><img src="back.jpg" width="30" height="30" /><b>Go back</b></a>
    </div>

</body>
</html>	
