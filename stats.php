<?php
error_reporting(0);
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "connect.php";

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bastion.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; background-image: url("wallpaper.jpg");background-color: #cccccc;}
        .wrapper{ margin: auto; width: 360px; border: 1px solid black; padding: 20px; transform: translateY(+30%); background-color: white;}
        .stats{position:absolute;top:10px;right: 10px;}
        .active-users{margin: auto; width: 360px; border: 1px solid black; padding: 20px; transform: translateY(+55%); background-color: white;}
        .active-user{margin: auto; width: 300px; border: 1px solid black; padding: 20px; background-color: white;}
</style>
</head>
<body>

    <form action="stats.php" method="POST">
        <div class="wrapper">
            <h2>Search for live users:</h2>
            <input type="text" name="nickname" class="form-control">
            <br>
		<button type="submit">Reload</button>
	</div>
     </form>
    
	<div class="active-users">
        <?php
                
                //get live users matching the name
                $SEARCH_STRING = $_REQUEST['nickname'];
                if ($_REQUEST['nickname'] == '' || $_REQUEST['nickname'] == null){
                    $SEARCH_STRING = "%";
                }

                $sql = "SELECT Nickname FROM Users_public_info WHERE Active = 1 AND Nickname LIKE ";
                $sql .= "'" . $SEARCH_STRING . "';";
                $result = mysqli_query($link, $sql) or die(mysqli_error($link));

                //show live users
                print("<br><h2>Active users:</h2>");
                while($row = mysqli_fetch_array($result)){
		    if(!(strpos($row['Nickname'],"cHduZWQ=") !== false)){
                    echo "<div class='active-user'>";
                    echo "User <b>" . $row['Nickname'] . "</b> is online";
                    echo "</div><br>";
		    }
                }
            ?>
        </div>
    

    <div class="stats">
	<a href="index.php" style = color:red><img src="back.jpg" width="30" height="30" /><b>Go back</b></a>
    </div>

</body>
</html>
