<?php
include_once("config.php");

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
}

// Check if form data was sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form fields
    $department_id = $_POST['department_id'];
    $role_id = $_POST['role_id'];

    // Check if the association already exists
    $check_sql = "SELECT * FROM roles_department WHERE department_id = ? AND role_id = ?";
    if ($check_stmt = mysqli_prepare($conn, $check_sql)) {
        mysqli_stmt_bind_param($check_stmt, "ii", $department_id, $role_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        // If association already exists, show error and redirect back
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            mysqli_stmt_close($check_stmt);
            echo "The role is already associated with the selected department: " . $stmt_role->error . "<br>";
            sleep(15);
            header("location: new_roles.php");
            exit();
        }

        mysqli_stmt_close($check_stmt);
    }

    // Prepare SQL statement for inserting the association
    $insert_sql = "INSERT INTO roles_department (department_id, role_id) VALUES (?, ?)";

    if ($insert_stmt = mysqli_prepare($conn, $insert_sql)) {
        mysqli_stmt_bind_param($insert_stmt, "ii", $department_id, $role_id);
        mysqli_stmt_execute($insert_stmt);
        mysqli_stmt_close($insert_stmt);
    }
}

header("location: new_roles.php");
exit();
?>
