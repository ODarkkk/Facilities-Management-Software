<?php
include_once("config.php");

$sql = "SELECT * from offices 
JOIN building_offices on building_offices.office_id = offices.office_id
where building_offices.office_id != offices.office_id";
$result = $conn->query($sql);

$options = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = array("office_id" => $row["office_id"], "name" => $row["office_name"]);
    }
}


echo json_encode($options);