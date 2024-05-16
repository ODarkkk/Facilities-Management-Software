<?php
include_once('config.php');
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
  header("location: logout.php");
  exit(); // Ensure script stops after redirect
}


$error_message = "";
$edit = false;


// Check if edit mode


// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $photo = $_POST['photo'];
    $phone = $_POST['phone'];
    $new_password = password_hash($_POST['new-password'],  
          PASSWORD_DEFAULT); 
    if (isset($_GET['edit'])) {
        $edit = true;
        $id = $_POST['peopleid'];
        $nationality = $_POST['nationality'];
    }  
    else{
        $date = $_POST['date'];
    }
      $logon = $_POST['logon'];
    $admin = $_POST['admin'];

    // Validate user input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address';
        error($error_message);
    } 
     else {
        // Insert or update user data
        if ($edit) {
            $sql = "UPDATE people SET username =?, name =?, role_department_id =?, email =?, photo =?, phone =?, password =?, logon =?, admin =? WHERE people_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisbssiii", $username, $name, $department, $email, $photo, $phone, $new_password, $logon, $admin, $id);
        } else {
            $sql = "INSERT INTO people (username, name, role_department_id, email, photo, phone, password, logon, admin) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssisbisii", $username, $name, $date, $nationality, $department, $email, $photo, $phone, $new_password, $logon, $admin);
        }
        
        // Redirect to a success page or display a success message
    }
}

// Retrieve department options

