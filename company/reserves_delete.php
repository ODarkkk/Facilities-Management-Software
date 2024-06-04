<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
  }

  $id = $_GET['bookmark_id'];

  $stmt = $conn->prepare("DELETE FROM bookmark WHERE `bookmark`.`bookmark_id` = ?");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    echo 'success';
  } else {
    echo 'error';
    sleep(30);
    echo '<script>',
       'goback();',
       '</script>';
  }