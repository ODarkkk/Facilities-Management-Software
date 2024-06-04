<?php
include_once 'config.php';

$roomId = isset($_GET['roomId']) ? $_GET['roomID'] : null;
$officeId = isset($_GET['officeId']) ? $_GET['officeId'] : null;

if($roomId !== null){
    $sql = "SELECT * FROM room AS r INNER JOIN 	offices_room AS o ON o.room_id = r.room_id
    WHERE r.room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();
}
else if ($officeId){
$sql = "SELECT * FROM room as r INNER JOIN offices_room AS o
WHERE o.office_id = ? AND r.room_id = (SELECT MIN(room_id) FROM offices_room WHERE o.office_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $officeId, $officeId);
$stmt->execute();
$result = $stmt->get_result();
}
else{
    $sql = "SELECT MIN(r.room_id), r.* FROM room AS r
    INNER JOIN offices_room AS o ON o.room_id = r.room_id
    WHERE o.office_id = (SELECT MIN(office_id) FROM offices_room)";
     $stmt = $conn->prepare($sql);
     $stmt->execute();
     $result = $stmt->get_result();
}
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<p> Space:" . htmlspecialchars($row['space']) . "</p>";
    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
}