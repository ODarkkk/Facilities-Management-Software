<?php
include_once("config.php");
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
  header("location: logout.php");
  exit(); // Ensure script stops after redirect
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Check if an image was uploaded
  if (isset($_FILES['office_image']) && !empty($_FILES['office_image']['tmp_name'])) {
    $imageData = file_get_contents($_FILES['office_image']['tmp_name']);
    $imageType = $_FILES['office_image']['type'];

    $stmt = $conn->prepare("INSERT INTO offices (office_name, description, office_image) VALUES (?,?,?)");
    $stmt->bind_param("ssb", $office_name, $description, $imageData);
    $stmt->execute();

    $officeid = $conn->insert_id;
    foreach ($_POST['rooms'] as $roomid) {
      $stmt = $conn->prepare("INSERT INTO office_rooms (office_id, room_id) VALUES (?,?)");
      $stmt->bind_param("ii", $officeId, $roomId);
      $stmt->execute();
    }
  } else {
    $stmt = $db->prepare("INSERT INTO offices (office_name, description) VALUES (?,?)");
    $stmt->bind_param("ss", $officeName, $description);
    $stmt->execute();

    $officeid = $conn->insert_id;

    foreach ($rooms as $roomid) {
      $stmt = $conn->prepare("INSERT INTO office_rooms (office_id, room_id) VALUES (?,?)");
      $stmt->bind_param("ii", $officeId, $roomId);
      $stmt->execute();
    }
  }
  // Redirect the user to the office list page

}
// echo '<script>',
// 'goback();',
// '</script>';
header("location user.php");
?>