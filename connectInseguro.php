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
 
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

