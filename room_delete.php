<?php
include_once 'config.php';
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
}

$id = $_GET['id'];

$sql = "DELETE FROM room WHERE room_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
sleep(30);
echo '<script>',
    'goback();',
    '</script>';