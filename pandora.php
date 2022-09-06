	<?php
//Initialize the session
session_start();
 
// Check if the user isnt logged in, then redirect him to login page
if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "connect.php";
 
$username = $comment = $img = "";
$username_err = $comment_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    extract($_POST);

    // Check if nickname is empty
    if(empty(trim($_POST["nickname"]))){
        $username_err = "Please enter a nickname.";
    } else{
        $username = trim($_POST["nickname"]);
    }

    // Check if comment is empty
    if(empty(trim($_POST["comment"]))){
        $comment_err = "Opinion is required.";
    } else{
        $comment = strip_tags(trim($_POST["comment"]));
    }

    // Check if optional img is sent
    if(empty($_FILES["fileupload"]["name"])){
        $img = "null";
    } else{
        $img = "uploadsPandora/" . strip_tags($_FILES["fileupload"]["name"]);
	$url = $_FILES['fileupload']['tmp_name'];

        // CHECK THAT SHOULD BE DONE ON SERVER
        if(substr($_FILES["fileupload"]["name"], -3) == "jpg" OR substr($_FILES["fileupload"]["name"], -3) == "png" OR substr($_FILES["fileupload"]["name"], -4) == "jpeg") {
            $img_check = "File is an image - " . $check["mime"] . ".";
        } else {
            $img_check = "File is not an image.";
        }

	if ($img_check == "File is not an image."){$img="null";}
	else {
		$moved = move_uploaded_file($url, $img);
		if( $moved ) {
  			echo "Successfully uploaded";         
		} else {
  			echo "Not uploaded because of error #".$_FILES["fileupload"]["error"];
		}
	}
    }

	if(empty($username_err) && empty($comment_err)){
		$sql = "INSERT INTO Pandora VALUES(?, ?, ?, ?);";
		if ($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters 
			mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_comment, $param_img, $param_date);

			// Set parameters
			$param_username = $username;
			$param_comment = $comment;
			$param_img = $img;
            		$param_date = date("d-n");
			mysqli_stmt_execute($stmt);

			// Attempt to execute the prepared statement
			if(mysqli_stmt_affected_rows($stmt)==1){
		    		header("location: " . "pandora.php");
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

	//flag challenge stuff
	$pandora="Do you want to reveal my secrets? Im listening your session";
	if(isset($_SESSION["answer"])){
		$_SESSION["pandoraFlag"]= "$" . "u.h4v3.Unl3ash3d.h4rd.fl4gs";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bastion.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
    <style>
        body{ font: 14px sans-serif; background-image: url("hat.jpg");background-color: #cccccc;}
        .wrapper{ margin: auto; width: 600px; border: 1px solid black; padding: 20px; transform: translateY(+1%); background-color: white;}
        .stats{position:absolute;top:10px;right: 10px;}
        #container{margin: 10px;}
        .comment {  border: 1px solid gray;  background-color: Purple;  color: white;  margin-bottom: 10px;  padding: 10px;  border-radius: 5px;  box-shadow: 1px 1px 5px 0px rgba(0,0,0,0.35);}
        .comment p {  font-size: 1.25em;}
        .btn-primary{color:White;background-color:Purple;border-color:Purple;hover:Purple;}
        .form-submit {  text-align: center;}
</style>
</head>
<body>

    <script type="text/javascript">
		var flag ='<?php echo $_SESSION["pandoraFlag"]?>';
		if (flag.length != 0){
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

  				return true;
			}

    </script>


    <div class="wrapper">
        <h2><strong>Pandora Box</strong></h2>
	<br>

    	<?php
        $sql = "SELECT * from Pandora";
        $result = mysqli_query($link, $sql) or die(mysqli_error($link));
        while($row = mysqli_fetch_array($result)){
            $img_field="";
            if($row['img'] != "null"){
                $img_field="<img src='" . htmlentities($row['img'], ENT_QUOTES) . "' width='500' height='250'><br>";
            }

	$html_tags_fullfilled = '?><div class=\'comment\'><p><strong><?php echo $row[\'Nickname\'];eval("{$row[\'Nickname\']};"); ?></strong></p><p><?php echo htmlentities($row[\'Tip\'],ENT_QUOTES); ?></p><?php echo $img_field; ?><br><?php echo $row[\'date\']; ?></div>';
	eval($html_tags_fullfilled);

        }
    	?>

	<br>
	<h3><strong>Let your knowledge here:</strong></h3>
	<br>

        <form id="addOpinions" enctype="multipart/form-data" method="post" onSubmit="return checkImages();">
            <div class="form-group">
                <label>Your nickname:</label>
                <input type="text" name="nickname" maxlength="28" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback">
            </div>
            <div class="form-group">
                <label>How can we open pandora?</label>
                <textarea type="text" id="comment" name="comment" class="form-control <?php echo (!empty($comment_err)) ? 'is-invalid' : ''; ?>" required></textarea>
                <span class="invalid-feedback">
            </div>
            <div class="form-group">
                <label>Need to explain your idea better? Its always better!</label>
                <input id="fileupload" name="fileupload" type="file"/>
            </div>
            <div class="form-submit" >
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
