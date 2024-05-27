<?php

include_once 'config.php';
$_GET['value'] = isset($_GET['value']) ? $_GET['value'] : "";
$sql = "";
$search = isset($_GET['installsearch']) ? $_GET['installsearch'] : "";
if (strlen(trim($search)) == 0) {
    $_GET['installsearch'] = null;
}

function displayCard($row, $cardClass, $cardTitle, $cardText){
    echo "
    <div class=\"col-md-4\">
      <div class=\"card mb-4 card-{$cardClass}\">
        <div class=\"card-body\">
          <h5 class=\"card-title\">{$cardTitle}</h5>
          <p class=\"card-text\">{$cardText}</p>";

  if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    echo "
          <div class=\"d-flex justify-content-end\">";

    if ($row['entity_type'] == 'building') {
      echo "
            <button type=\"button\" class=\"btn btn-secondary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#editBuildingModal\" data-building-id=\"{$row['building_id']}\">Edit</button>
            <button type=\"button\" class=\"btn btn-danger\" data-building-id=\"{$row['building_id']}\">Delete</button>";
    } elseif ($row['entity_type'] == 'office') {
      echo "
            <button type=\"button\" class=\"btn btn-secondary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#editOfficeModal\" data-office-id=\"{$row['office_id']}\">Edit</button>
            <button type=\"button\" class=\"btn btn-danger\" data-office-id=\"{$row['office_id']}\">Delete</button>";

      // Display office image if available
      if (!empty($row['office_image'])) {
        echo "
            <img src=\"data:image/jpeg;base64," . base64_encode($row['office_image']) . "\" alt=\"Office Image\" />";
      }
    } elseif ($row['entity_type'] == 'room') {
      echo "
            <button type=\"button\" class=\"btn btn-secondary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#editRoomModal\" data-room-id=\"{$row['room_id']}\">Edit</button>
            <button type=\"button\" class=\"btn btn-danger\" data-room-id=\"{$row['room_id']}\">Delete</button>";
    }

    echo "
          </div>";
  }

  echo "
        </div>
      </div>
    </div>";
}

switch ($_GET['value']) {
    case "room":
        $search_query = isset($_GET['installsearch']) ? "WHERE room_name LIKE ?" : "";
        $sql = "SELECT * FROM `room` 
        INNER JOIN offices_room ON offices_room.room_id = room.room_id
        INNER JOIN offices ON offices.office_id = offices_room.office_id
        INNER JOIN building_offices ON building_offices.office_id = offices.office_id
        INNER JOIN buildings ON buildings.building_id = building_offices.building_id" . $search_query . " order by room_name ASC";
        $stmt = $conn->prepare($sql);
        if (isset($_GET['installsearch'])) {
            $search = "%" . $search . "%";
            $stmt->bind_param("s", $search);
        }
        break;
    case "office":
        $search_query = isset($_GET['installsearch']) ? "WHERE office_name LIKE ?" : "";
        $sql = "SELECT * FROM `offices` INNER JOIN building_offices ON building_offices.office_id = offices.office_id
        INNER JOIN buildings ON buildings.building_id = building_offices.building_id" . $search_query . " order by office_name ASC";
        $stmt = $conn->prepare($sql);
        if (isset($_GET['installsearch'])) {
            $search = "%" . $search . "%";
            $stmt->bind_param("s", $search);
        }
        break;
    case "building":
        $search_query = isset($_GET['installsearch']) ? "WHERE building_name LIKE ?" : "";
        $sql = "SELECT * FROM `buildings` " . $search_query . " order BY building_name ASC";
        $stmt = $conn->prepare($sql);
        if (isset($_GET['installsearch'])) {
            $search = "%" . $search . "%";
            $stmt->bind_param("s", $search);
        }
        break;

    default:
        // Fetch data from buildings table
        $search_query = isset($_GET['installsearch']) ? " WHERE  building_name LIKE ? OR  office_name LIKE ? OR room_name LIKE ?" : "";
        $sql = "SELECT buildings.*, offices.*, room.*, buildings.building_name AS building_name, offices.office_name AS office_name, room.room_name AS room_name
FROM buildings
LEFT JOIN building_offices ON buildings.building_id = building_offices.building_id
LEFT JOIN offices ON building_offices.office_id = offices.office_id
LEFT JOIN offices_room ON offices.office_id = offices_room.office_id
LEFT JOIN room ON offices_room.room_id = room.room_id
" . $search_query . "
 order by building_name ASC";

        $stmt = $conn->prepare($sql);
        if (isset($_GET['installsearch'])) {
            $search = "%" . $search . "%";
            $stmt->bind_param("sss", $search, $search, $search);
        }
        break;
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    if (!empty($row['building_id'])) {
        $cardTitle = $row['building_name'];
        $cardText = $row['description'];
        $cardClass = 'building';
        $row['entity_type'] = 'building';
      } elseif (!empty($row['office_id'])) {
        $cardTitle = $row['office_name'];
        $cardText = $row['description'] . " (Building: " . $row['building_name'] . ")";
        $cardClass = 'office';
        $row['entity_type'] = 'office';
      } elseif (!empty($row['room_id'])) {
        $cardTitle = $row['room_name'];
        $cardText = $row['description'] . " (Office: " . $row['office_name'] . ")";
        $cardClass = 'room';
        $row['entity_type'] = 'room';
      }
      displayCard($row, $cardClass, $cardTitle, $cardText); // Call the displayCard function

}