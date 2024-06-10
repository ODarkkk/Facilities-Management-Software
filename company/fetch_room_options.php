<?php
include_once ("config.php");

$sql = "SELECT * from room 
JOIN offices_room on offices_room.room_id = room.room_id
where offices_room.room_id != room.room_id";
$result = $conn->query($sql);

$options = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = array("room_id" => $row["room_id"], "name" => $row["room_name"]);
    }
}


echo json_encode($options);
?>