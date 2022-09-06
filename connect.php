<?php
// $user = 'LeonardoCosano';
// $password = 'valve_Admin123';
// $db = 'dvwa';
// $host = 'localhost';
// $port = 8889;

// $link = mysqli_init();
// $success = mysqli_real_connect(
//    $link,
//    $host,
//    $user,
//    $password,
//    $db,
//    $port
// );
?>

<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'LeonardoCosano');
define('DB_PASSWORD', 'valve_Admin123');
define('DB_NAME', 'dvwa');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
