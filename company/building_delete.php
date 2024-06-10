<?php
include_once ("config.php");
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
}

$sql = "DELETE FROM buildings WHERE building_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
// echo '<script>',
// 'goback();',
// '</script>'
// ;
header("location user.php");

?>