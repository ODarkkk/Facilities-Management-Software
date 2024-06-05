<?php
include_once("config.php");
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
    $role_department = isset($_POST['role'])?  $_POST['role']: null;
    $email = $_POST['email'];
    $photo = $_POST['photo'];
    $phone = $_POST['phone'];
    $new_password = password_hash($_POST['new-password'], 
          PASSWORD_DEFAULT); 
    if (!isset($_GET['edit'])) {
        $edit = true;
        $id = $_POST['peopleid'];
    }  
    else{
        $date = $_POST['date'];
        $nationality = $_POST['nationality'];
    }
      $logon = isset($_POST['logon'])? $_POST['logon'] : 0;
    $admin = $_POST['admin'];

    // Validate user input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address';
        error($error_message);
    } 
     else {
        // Insert or update user data
        $sql = "SELECT * from people WHERE user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result -> num_rows > 0) {
            $error_message = 'Username already exists';
            error($error_message);
            sleep(30);
            echo "<script>window.location = new_user.php;</script>";
        }
        if ($edit == true) {
            $sql = "UPDATE people SET user =?, name =?, role_department_id =?, email =?, photo =?, phone =?, password =?, password_status =?, admin =? WHERE people_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisbssiii", $username, $name, $role_department, $email, $photo, $phone, $new_password, $logon, $admin, $id);
        } else {
            $sql = "INSERT INTO people (user, name, date_of_birth, role_department_id, nationality, email, photo, phone, password, password_status, admin) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
           $stmt->bind_param("ssssisbssii", $username, $name, $date,  $role_department,$nationality, $email, $photo, $phone, $new_password, $logon, $admin);

        }
        $stmt->execute();
    }
}
echo '<script>',
'goback();',
'</script>'
;// Retrieve department options
?>
