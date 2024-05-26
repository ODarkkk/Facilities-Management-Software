<?php

include_once 'config.php';

$sql = "";
$search = isset($_GET['installsearch']) ? $_GET['installsearch'] : "";
if (strlen(trim($search)) == 0){
  $_GET['installsearch'] = null;
}

switch ($_GET['value']){
    case "room":
        $sql = "SELECT * FROM `buildings` ". (isset($_GET['installsearch']) ? "WHERE building_name LIKE '%?%'" : "") ." order by building_name ASC";
        $stmt = $conn->prepare($sql);
        $stmt = $conn->prepare($sql);
        if(isset($_GET['installsearch'])){
            $stmt->bind_param("sss", $search, $search, $search);
            $stmt->execute();
            $result = $stmt ->get_result();
        }
        else{
            $result = mysqli_query($conn, $sql);
        }
        break;
    case "office":
        $sql = "SELECT * FROM `offices` ". (isset($_GET['installsearch']) ? "
       where office_name LIKE '%?%'" : "") ." order by office_name ASC";
       $stmt = $conn->prepare($sql);
       $stmt = $conn->prepare($sql);
       if(isset($_GET['installsearch'])){
           $stmt->bind_param("sss", $search, $search, $search);
           $stmt->execute();
           $result = $stmt ->get_result(); 
       }
       else{
           $result = mysqli_query($conn, $sql);
       }
        break;
    case "building":
        $sql = "SELECT * FROM `room` ". (isset($_GET['installsearch']) ? "
        WHERE room_name LIKE '%?%'" : "") ."order BY room_name ASC";
        $stmt = $conn->prepare($sql);
        if(isset($_GET['installsearch'])){
            $stmt->bind_param("sss", $search, $search, $search);
            $stmt->execute();
            $result = $stmt ->get_result(); 
        }
        else{
            $result = mysqli_query($conn, $sql);
        }
        break;

    default:
    $sql = "SELECT * from buildings, offices, room
    " . (isset($_GET['installsearch']) ? "
    where buildings.building_name LIKE %?% OR offices.office_name LIKE %?' OR room.room_name LIKE '?'" : "") . "
    ORDER BY buildings.building_name, offices.office_name, room.room_name ASC";
    $stmt = $conn->prepare($sql);
if(isset($_GET['installsearch'])){
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt ->get_result(); 
}
else{
    $result = mysqli_query($conn, $sql);
}
break;

}
while($row = $result->fetch_assoc()){
    $cardClass = 'primary';
    $cardTitle = $row['building_name'] ?? $row['office_name'] ?? $row['room_name'];
    $cardText = "";

    if (isset($row['building_name'])) {
        $cardText .= "Building: {$row['building_name']}<br>";
    }

    if (isset($row['office_name'])) {
        $cardText .= "Office: {$row['office_name']}<br>";
    }

    if (isset($row['room_name'])) {
        $cardText .= "Room: {$row['room_name']}<br>";
    }
    $entityId = isset($row['building_id']) ? $row['building_id'] : (isset($row['office_id']));

    echo "
        <div class=\"col-md-4\">
            <div class=\"card mb-4 card-{$cardClass}\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">{$cardTitle}</h5>
                    <p class=\"card-text\">{$cardText}</p>
                    <!-- Add your button or other elements here -->
                    " . ($_SESSION['admin'] == 1 ? "
                    <button type=\"button\" class=\"btn btn-secondary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#editRoomModal\" data-room-id=\"{$row['room_id']}\">Edit</button>
                    <button type=\"button\" class=\"btn btn-danger\" data-room-id=\"{$row['room_id']}\">Delete</button>" : "") . "
                </div>
            </div>
        </div>
    ";


}