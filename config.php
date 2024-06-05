<?php
session_start([
    'cookie_lifetime' => 86400,
]);
// function debug_to_console($data) {
//     $output = $data;
//     if (is_array($output))
//         $output = implode(',', $output);

//     echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
// }
$servername = "rpx.h.filess.io";
$username = "company_exacthair";
$password = "407b8f9ebcb9893194d57c8e2e1cfaf370a62935";
$dbname = "company_exacthair";
$port = 3305;

// $servername = "localhost";
// $username = "DAnastacio";
// $password = "123";
// $dbname = "company";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function error($error_message) {
    return $error_message;
  }


function securePassword($password) {
    // Check if password has at least 12 characters
    if (strlen($password) < 12 && !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
        return false;
    }
    
    
    
    // Check if password is not sequential
    for ($i = 0; $i < strlen($password) - 1; $i++) {
        $char1 = ord($password[$i]);
        $char2 = ord($password[$i + 1]);
        
        // If characters are sequential, return false
        if ($char2 - $char1 == 1) {
            return false;
        }
    }
    
    // If passed all checks, return true
    return true;
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