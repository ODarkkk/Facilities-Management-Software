<?php
include_once 'config.php';
// Get the ID of the role to update
$id = $_POST['id'];

// Get the updated department and role IDs
$department_id = $_POST['department_id'];
$role_id = $_POST['role_id'];

// Update the role
$sql = "UPDATE roles_department SET department_id = '$department_id', role_id = '$role_id' WHERE roles_department_id = '$id'";
if ($conn->query($sql) === TRUE) {
    echo "Role updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Redirect back to the list of roles
header('Location: roles_list.php');
exit;
?>