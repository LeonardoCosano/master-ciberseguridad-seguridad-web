<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "connectInseguro.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["hashedPass"]))){
        $password_err = "Please enter your password.";
    } else{
        $hashed_password = trim($_POST["hashedPass"]);
    }

    // check if username exists
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT Loginname FROM Users_private_info WHERE Loginname = '";
        $sql .= $username . "' AND (Password = '" . $hashed_password . "')";

	    $conexion = new mysqli("localhost", "LeonardoCosano", "valve_Admin123", "dvwa");
        if ($conexion->connect_error) {
                die('Error de Conexión (' . $conexion->connect_errno . ') '
                    . $conexion->connect_error);
	    }

        $consulta = $conexion->query($sql);

        $rows = mysqli_num_rows($consulta);

	    // There is 1 user matching this name and password
        if ($rows == 1){
          session_start();
          //Store data in session variables
          $_SESSION["loggedin"] = true;
          $_SESSION["id"] = 1;
          $_SESSION["username"] = $username;
          // Redirect user to welcome page
          header("location: welcome.php");
        } else{
            //There is no match
            $login_err = "Invalid username or password.";
        }
	// Close connection
	$conexion->close();
	}
}
?>

 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bastion.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body{ font: 14px sans-serif; background-image: url("wallpaper.jpg");background-color: #cccccc;}
        .wrapper{ margin: auto; width: 360px; border: 1px solid black; padding: 20px; transform: translateY(+30%); background-color: white;}
        .stats{position:absolute;top:10px;right: 10px;}
</style>
</head>
<body>

    <script>
		function changePassword(){
			document.getElementById('hashedPass').value=btoa(document.getElementById('password').value);
  			$('#login').submit();
		};
	</script>

    <div class="wrapper">
        <h2>Login to <br>Summer Hack!</h2>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form id="login" method="post" onSubmit=changePassword()>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
  	    <input type="hidden" name="hashedPass" id="hashedPass" >
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login" >
            </div>
        </form>

    </div>

    <div class="stats">
	    <a href="stats.php" style = color:red><img src="active-users.jpg" width="50" height="50" /><b>0 Live users</b></a>
    </div>

</body>
</html>	
