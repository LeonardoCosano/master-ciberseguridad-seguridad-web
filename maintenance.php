<?php
// Initialize the session
session_start();
 
// Check if the user isnt logged in, then redirect him to login page
if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

if(isset($_SESSION["flagChange"])){
    $_SESSION["flagValue"]=$_SESSION["flagChange"];
}

// Include config file
require_once "connect.php";

$username = $improvement = "";
$username_err = $improvement_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    extract($_POST);

    // Check if nickname is empty
    if(empty(trim($_POST["nickname"]))){
        $username_err = "Please enter a nickname.";
    } else{
        $username = strip_tags(trim($_POST["nickname"]));
    }

    // Check if comment is empty
    if(empty(trim($_POST["improvement"]))){
        $improvement_err = "Opinion is required.";
    } else{
        $improvement = strip_tags(trim($_POST["improvement"]));
    }

    // Check if optional img is sent
    if(empty($_FILES["fileupload"]["name"])){
        $img = "null";
    } else{
        $img = "uploadsMaintenance/" . strip_tags(trim($_FILES["fileupload"]["name"]));
	$url = $_FILES['fileupload']['tmp_name'];
 	//file_put_contents($img, $url);


	$moved = move_uploaded_file($url, $img);
    if( $moved ) {
    echo "Successfully uploaded";         
    } else {
    echo "Not uploaded because of error #".$_FILES["file"]["error"];
    }
        /* CHECK THAT SHOULD BE DONE ON SERVER
        $size = getimagesize($_FILES["fileupload"]["tmp_name"]);
        if($check !== false) {
            $img_check = "File is an image - " . $check["mime"] . ".";
        } else {
            $img_check = "File is not an image.";
        }*/
    }

	if(empty($username_err) && empty($improvement_err)){
		$sql = "INSERT INTO Maintenance VALUES(?, ?, ?, ?);";
		if ($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters 
			mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_improvement, $param_img, $param_date);

			// Set parameters
			$param_username = $username;
			$param_improvement = $improvement;
			$param_img = $img;
            		$param_date = date("Y-n-d");
			mysqli_stmt_execute($stmt);

			// Attempt to execute the prepared statement
			if(mysqli_stmt_affected_rows($stmt)==1){
		    		header("location: maintenance.php");
			} else{
			    echo "Oops! Something went wrong. Please try inserts later.";
			}

		} else {
			echo "Oops! Something went wrong. Please try stmt prepare later.";
		}

		// Close statement
		mysqli_stmt_close($stmt);
	}
	    
    // Close connection
    mysqli_close($link);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bastion.com</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; background-image: url("background2.jpg");background-attachment: fixed;background-position: center;background-color: #cccccc;}
        .wrapper{ margin: auto; width: 600px; border: 1px solid black; padding: 20px; transform: translateY(+7%); background-color: white;}
        .stats{position:absolute;top:10px;right: 10px;}
        #container{margin: 10px;}
        .comment {  border: 1px solid gray;  background-color: CornflowerBlue;  color: white;  margin-bottom: 10px;  padding: 10px;  border-radius: 5px;  box-shadow: 1px 1px 5px 0px rgba(0,0,0,0.35);}
        .comment p {  font-size: 1.25em;}
        .btn-primary{color:#fff;background-color:#6495ED;border-color:#6495ED}
        .form-submit {  text-align: center;}
</style>
</head>
<body>
    <script type="text/javascript">
	var flag='<?php echo $_SESSION["flagValue"]?>';
	if(flag.length != 0){
		Swal.fire('Congrats!',flag,'success');
	}
    </script>

    <script type="text/javascript">
		function checkImages(){
			var field = document.getElementById("fileupload").value;
			if (field.length === 0){return true;}
  			if(!(field.slice(-3)==="jpg") && !(field.slice(-3)==="png") && !(field.slice(-4)==="jpeg"))
  			{
				alert("Sorry, we only accept jpg, png and jpeg");
    				return false;
  			}
				alert("<?php echo $flag;?>");
  				return true;
			}
    </script>

    <div class="wrapper">
        <h2><strong>Maintenance notes</strong></h2>
	<br>

    <?php
        $sql = "SELECT * from Maintenance WHERE img NOT LIKE '%.php'";
        $result = mysqli_query($link, $sql) or die(mysqli_error($link));
        while($row = mysqli_fetch_array($result)){
            $img_field="";
            if($row['img'] != "null"){
                $img_field="<img src='" . $row['img'] . "' width='500' height='250'><br>";
            } 
            echo "<div class='comment'>";
            echo "<p><strong>" . htmlentities($row['nickname'], ENT_QUOTES) . "</strong></p><p>" . htmlentities($row['improvement'], ENT_QUOTES) . "</p>" . $img_field . "<br>Date: " . $row['date'];
            echo "</div>";
        }
    ?>
	
	<br>
	<h3><strong>Post your improvements ideas here:</strong></h3>
	<br>
    
        <form id="addOpinions" method="post" enctype="multipart/form-data" onSubmit="return checkImages();">
            <div class="form-group">
                <label>Your visible nickname:</label>
                <input type="text" id="nickname" name="nickname" class="form-control" required>
                <span class="invalid-feedback">
            </div>    
            <div class="form-group">
                <label>Improvement chance:</label>
                <textarea type="text" id="improvement" name="improvement" class="form-control" required></textarea>
                <span class="invalid-feedback">
            </div>
            <div class="form-group">
                <label>Want to include an image?</label><br>
                <input id="fileupload" name="fileupload" type="file"/>
            </div>
            <div class="form-submit">
                <input type="submit" class="btn btn-primary" value="Post opinion">
            </div>	
        </form>

    </div>
	<br><br><br>

    <div class="stats">
	<a href="welcome.php" style = color:red><img src="back.jpg" width="30" height="30" /><b>Go back</b></a>
    </div>

</body>
</html>	
