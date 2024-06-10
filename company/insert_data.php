<?php
include_once ("config.php");
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
  header("location: logout.php");
  exit(); // Ensure script stops after redirect
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_POST['action'] == 'create_department' && !empty($_POST['department'])) {
        $sql_department = "INSERT INTO department (department_name) VALUES (?)";
        $stmt_department = $conn->prepare($sql_department);
        $stmt_department->bind_param("s", $department);
        if ($stmt_department === false) {
            die("Error in preparing the consultation for the department: " . $conn->error);
        }
        $stmt_department->bind_param("s", $_POST['department']);
    }  
    if ($stmt_department->execute()) {
        echo "Department data entered successfully!<br>";
    } else {
        echo "Error entering department data: " . $stmt_department->error . "<br>";
    }

    
} elseif ($_POST['action'] == 'create_role' && !empty($_POST['role'])) {
    $sql_role = "INSERT INTO role (role_name) VALUES (?)";
    $stmt_role = $conn->prepare($sql_role);

    if ($stmt_role === false) {
        die("Error in preparing the consultation for the role: " . $conn->error);
    }
    $stmt_role->bind_param("s", $role);
    if ($stmt_role->execute()) {
        echo "Role data entered successfully!<br>";
    }
    else {
        echo "Error when entering role data: " . $stmt_role->error . "<br>";
    }

}
// echo '<script>',
//     'goback();',
//     '</script>';
header("location user.php");

?>