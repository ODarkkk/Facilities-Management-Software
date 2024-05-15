<?php
include_once("config.php"); // Adjust the include file as needed

// Get the selected filter value from the AJAX request
$selectedDate = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : date('Y-m-d');

$searchbar = isset($_GET['marksearch']) ? $_GET['marksearch'] : null;
$active = isset($_GET['active']) ? $_GET['active'] : 1;

$type = isset($_GET['type']) ? $_GET['type'] : null;
$filterType = $type ? $type->type : null;
$filterValue = $type ? $type->value : null;





// switch ($selectedFilter) {
//     case 'office':
//         $office_condition = "AND offices_room.office_id = ?";
//         break;
//     case 'room':
//         $room_condition = "AND room.room_id = ?";
//         break;
//     case 'building':
//         $building_condition = "AND offices.building_id = ?";
//         break;
// }

if (is_null($filterType) && is_null($filterValue)) {

$sql = "SELECT DISTINCT
" . ($filterType === 'office' ? "
offices.office_id,
offices.office_name," : "") . "
" . ($filterType === 'building' ? "
buildings.building_id,
buildings.building_name," : "") . "
" . ($filterType === 'room' ? "
room.room_id,
room.room_name," : "") . "
people.people_id,
people.user,
bookmarks.bookmark_id,
bookmarks.selected_date, 
bookmarks.start_hour,
bookmarks.end_hour
FROM bookmark bookmarks
INNER JOIN offices_room ON offices_room.room_id = bookmarks.room_id
" . ($filterType === 'office' ? "
INNER JOIN offices ON offices_room.office_id = offices.office_id" : "") . "
" . ($filterType === 'building' ? "
INNER JOIN building_offices ON building_offices.office_id = offices.office_id
INNER JOIN building ON building.building_id = building_offices.building_id" : "") . "
" . ($filterType=== 'room' ? "
INNER JOIN room room on room.room_id = offices_room.room_id" : "") . "
INNER JOIN people on people.people_id = bookmarks.people_id  
WHERE
bookmarks.selected_date = ?
AND 
bookmarks.active = " . $active . "
" . (isset($_GET['search']) ? "
people.user LIKE ?
" . ($filterType === 'office' ? "
OR offices.office_id = " . $filterValue . "
OR offices.office_name LIKE ?" : "") . "
" . ($filterType === 'building' ? "
OR building.building_id " . $filterValue . "
OR building.building_name LIKE ?" : "") . "
" . ($filterType === 'room' ? "
OR room.room_name " . $filterValue . "
OR room.room_id LIKE ?" : "") . "
." : "") . "
ORDER BY 
bookmarks.bookmark_id;
";
}
else{
  $sql = "SELECT DISTINCT
offices.*,
buildings.*,
room.*,
bookmarks.bookmark_id,
bookmarks.selected_date, 
bookmarks.start_hour,
bookmarks.end_hour
FROM bookmark bookmarks,buildings, room, offices
WHERE
bookmarks.selected_date = ?
AND 
bookmarks.active = " . $active;
if (isset($_GET['search'])) {
  $sql .= " AND (
                  people.user LIKE :user
                  OR building.building_name LIKE :building_name
                  OR offices.office_name LIKE :office_name
                  OR room.room_name LIKE :room_name
              )";
}
$sql .="ORDER BY 
bookmarks.bookmark_id;
";
}

// echo $sql;
$stmt = $conn->prepare($sql);

if (isset($_GET['search'])) {
  $searchbar_like = '%' . $searchbar . '%';
  $stmt->bind_param("sss", $selectedDate, $searchbar_like, $searchbar_like);
} else {
  $stmt->bind_param("s", $selectedDate);
}
// switch ($selectedFilter) {
//   case 'office':
//     if (isset($_GET['search'])) {
//       $searchbar_like = '%' . $searchbar . '%';
//       $stmt->bind_param("sssi", $selectedDate, $searchbar_like, $searchbar_like, $office_id);
//     } else {
//       $stmt->bind_param("si", $selectedDate, $office_id);
//     }
//     break;
//   case 'room':
//     if (isset($_GET['search'])) {
//       $searchbar_like = '%' . $searchbar . '%';
//       $stmt->bind_param("sssi", $selectedDate, $searchbar_like, $searchbar_like, $office_id);
//     } else {
//       $stmt->bind_param("si", $selectedDate, $office_id);
//     }
//     break;
//   case 'building':
//     $building_id = isset($_GET["buildingSelect"]) ? intval($_GET["buildingSelect"]) : 1;
//     $searchbar_like = '%' . $searchbar . '%';
//     $stmt->bind_param("ssssssss", $selectedDate, $searchbar_like, $searchbar_like, $searchbar_like, $searchbar_like, $building_id, $searchbar_like, $searchbar_like);
//     break;
//   default:
//     $searchbar_like = '%' . $searchbar . '%';
//     $stmt->bind_param("sssssss", $selectedDate, $searchbar_like, $searchbar_like, $searchbar_like, $searchbar_like, $searchbar_like, $searchbar_like);
//     break;
// }



// echo "Selected office ID: " . $selectedOfficeId; // Adicione esta linha para depuração

// if ($selectedDate == null){
//$selectedDate = date('Y-m-d');
// }
// Query to retrieve the list of rooms
// $sql = "SELECT o.office_id, o.office_name, r.room_name, r.room_id, b.bookmark_id, b.date as bookmark_date, b.start_hour, b.end_hour
//         FROM offices o
//         INNER JOIN room r ON o.room_id = r.room_id
//         INNER JOIN bookmark b ON o.office_id = b.room_id AND
//         '$selectedDate' = DATE_FORMAT(b.date, '%Y-%m-%d') AND
//         STR_TO_DATE(NOW(), '%h:%i %p') BETWEEN STR_TO_DATE(b.start_hour, '%h:%i %p') AND STR_TO_DATE(b.end_hour, '%h:%i %p')
//         WHERE o.room_id IS NOT NULL
//         ORDER BY o.office_name";

// $sql = "SELECT o.office_id, o.office_name, r.room_name, r.room_id, b.bookmark_id, b.date as bookmark_date, b.start_hour, b.end_hour,
//                 IF(b.bookmark_id IS NOT NULL AND STR_TO_DATE(NOW(), '%h:%i %p') > STR_TO_DATE(b.end_hour, '%h:%i %p'), 'available',
//                    IF(b.bookmark_id IS NOT NULL, 'partially-available', 'available')) as availability_status
//         FROM offices o
//         INNER JOIN room r ON o.room_id = r.room_id
//         LEFT JOIN bookmark b ON o.office_id = b.room_id AND '$selectedDate' = DATE_FORMAT(b.date, '%%Y-%%m-%%d') AND active = 1
//         WHERE o.room_id IS NOT NULL
//         ORDER BY o.office_name";

// Execute the query and fetch the results

$stmt->execute();
$result = $stmt->get_result();


// output data of each row
// $stats = "<p>Filter: " . $selectedFilter . " </p>";
// echo "<div class='container mt-5'>";
// echo $stats;
// echo "</div>";
// echo "<br>";

// echo "<script>
// import {Input, Ripple, initMDB} from 'mdb-ui-kit';

// initMDB({Input, Ripple});
// </script>";
// echo "<div class='input-group'>
// <div class='form-outline' data-mdb-input-init>
//   <input type='search' id='searchbar' class='form-control' />
//   <label class='form-label' for='searchbar'>Search</label>
// </div>
// <button type='button' class='btn btn-primary' data-mdb-ripple-init>
//   <i class='fas fa-search'></i>

// </button>
// </div>";
// echo $sql;

// echo "<br>";
if ($result->num_rows > 0) {
  $markarray = array();

  while ($row = $result->fetch_assoc()) {

    // Generate the HTML for each room
    // $roomList .= '<div class="col-md-4">'  .
    //     '<div class="card mb-4 ' . getRoomClass($row) . '">' .
    //     '<div class="card-body">' .
    //     '<h5 class="card-title">' . htmlspecialchars($row["room_name"]) . '</h5>' .
    //     '<p class="card-text">' . htmlspecialchars($row["description"]) . '</p>' .

    //     // $row["room_id"];
    //     // $row["office_id"];~
    //     '<button type="button" class="btn btn-primary" onclick="location.href=\'room_reserve.php?room_id=' . $row["room_id"] . '&selecteddate_js=' . $selectedDate . '\';">Reserve</button>' .
    //     '</div>' .
    //     '</div>' .
    //     '</div>';
    $markarray[] = '<div class="col-md-4">' .
      '<div class="card mb-4"  >' .
      '<div class="card-body">' .
      '<h5 class="card-title">' . htmlspecialchars($row[$name."_name"]) . '</h5>' .
      '<p class="card-text">' . htmlspecialchars($row["description"]) . '</p>' .
      '<button type="button" class="btn btn-primary" onclick="location.href=\'room_reserve.php?room_id=' . $row["room_id"] . '&selecteddate_js=' . $selectedDate . '\';">Reserve</button>' .
      '</div>' .
      '</div>' .
      '</div>';


    // Output the room list
  }
  echo '<div class="container">';
  echo '<div class="row">';
  
  foreach ($markarray as $mark) {
    echo $mark;
  }
  echo "</div>";
  echo "</div>";
} else {
  echo '<p>Message: No marks associated with the selected filters';
}
// Get the CSS class for the room based on its availability
