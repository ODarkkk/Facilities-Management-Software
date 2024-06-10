<?php
include_once ("config.php");
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$stmt = $conn->prepare("INSERT INTO `room` (`room_name`, `space`, `description`) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $_POST['room_name'], $_POST['space'], $_POST['description']);
$stmt->execute();

}
// echo '<script>',
//     'goback();',
//     '</script>';
header("location user.php");

?>