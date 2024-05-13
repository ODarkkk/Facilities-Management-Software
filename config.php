<?php
session_start([
    'cookie_lifetime' => 86400,
]);
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

$servername = "localhost";
$username = "DAnastacio";
$password = "123";
$dbname = "company";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// $login = false;

// if ($login == false){
//     $secret_key = "";
// }
// else{
//     $secret_key = $secret_key;
// }
// Setting the secret key for encryption
// $secret_key = $secret_key;
// echo "Connected successfully";
?>