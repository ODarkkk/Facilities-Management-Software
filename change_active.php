<?php
// Connect to the database
require_once('config.php');

// Get the user ID and new active status from the AJAX request
$id = $_POST['id'];
$active = $_POST['active'];

// Prepare an SQL statement to update the active status of the user
$stmt = $conn->prepare("UPDATE people SET active = ? WHERE people_id = ?");
$stmt->bind_param('ii', $active, $id);

// Execute the SQL statement
if ($stmt->execute()) {
  echo 'success';
} else {
  echo 'error';
  sleep(30);
  echo '<script>',
     'goback();',
     '</script>'
;
}


