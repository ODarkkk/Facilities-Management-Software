<?php 
include_once ("config.php");
$id = $_GET['id'];

// Delete the row from the database
$sql = "DELETE FROM roles_department WHERE roles_department_id = $id";
$conn->query($sql);

// Redirect back to the original page
// echo '<script>',
//     'goback();',
//     '</script>';
header("location roles.php");
exit;