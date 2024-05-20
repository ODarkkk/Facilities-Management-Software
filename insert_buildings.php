<?php
include_once("config.php");
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO buildings (building_name, description) VALUES (?,?)");
$stmt->bind_param("ss", $office_name, $description);
$stmt->execute();

$buildingid = $conn->insert_id;
foreach ($_POST['offices'] as $officeid){
    $stmt = $conn->prepare("INSERT INTO building_offices (building_id, office_id) VALUES (?,?)");
    $stmt->bind_param("ii", $$buildingid, $officeid);
    $stmt->execute();
    
    }
  }
