
<?php
include_once("config.php"); // Adjust the include file as needed

if (!isset($_SESSION['user_id'])) {
  header("location: logout.php");
  exit(); // Ensure script stops after redirect
}

// Get the selected date from the AJAX request
$selectedDate = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : date('Y-m-d');
$search = isset($_GET['search']) ? $_GET['search'] : "";
if (strlen(trim($search)) == 0){
  $_GET['search'] = null;
}
// $selectedOfficeId = isset($_GET["officeSelect"]) ? intval($_GET["officeSelect"]) : 1;
if (isset($_GET["officeSelect"])) {
  $selectedOfficeId = $_GET["officeSelect"];
  $sql = "SELECT 
  offices_room.office_id,
  room.room_name,
  room.room_id,
  room.description,
  bookmarks.bookmark_id,
  bookmarks.selected_date, 
  bookmarks.start_hour,
  bookmarks.end_hour,
  CASE 
    WHEN bookmarks.bookmark_id IS NOT NULL AND CURRENT_TIME() > bookmarks.end_hour AND bookmarks.selected_date = ? THEN 'available'
    WHEN bookmarks.bookmark_id IS NOT NULL AND bookmarks.selected_date = ? OR CURRENT_TIME() > bookmarks.start_hour THEN 'partially-available'
    WHEN bookmarks.bookmark_id IS NOT NULL AND CURRENT_TIME() < bookmarks.end_hour AND CURRENT_TIME() > bookmarks.start_hour AND bookmarks.selected_date = ? THEN 'Occupied'
  END AS availability_status
  FROM 
  offices_room
  INNER JOIN room room ON room.room_id = offices_room.room_id
  LEFT JOIN bookmark bookmarks ON room.room_id = bookmarks.room_id 
    AND bookmarks.selected_date = ?
    AND bookmarks.active = 1
  WHERE 
  offices_room.office_id = ?
  AND offices_room.room_id IS NOT NULL
  " . (isset($_GET['search']) ? "
  AND room.room_id like ?
  OR
  room.room_name like ?
  OR room.description like ?" : "") . "
 
  ORDER BY 
  room.room_name;";
// echo $sql;
  $stmt = $conn->prepare($sql);
  if (isset($_GET['search'])) {
$search = "%".$search."%";
    $stmt->bind_param("ssssisss", $selectedDate, $selectedDate, $selectedDate, $selectedDate, $selectedOfficeId, $search, $search, $search);
  } else {

    $stmt->bind_param("ssssi", $selectedDate, $selectedDate, $selectedDate, $selectedDate, $selectedOfficeId);
  }
} else {
  $sql = "SELECT 
  offices_room.office_id,
  room.room_id,
  room.room_name,
  room.description,
  room.space,
  bookmarks.bookmark_id,
  bookmarks.selected_date, 
  bookmarks.start_hour,
  bookmarks.end_hour,
  CASE 
    WHEN bookmarks.bookmark_id IS NOT NULL AND CURRENT_TIME() > bookmarks.end_hour AND bookmarks.selected_date = ? THEN 'available'
    WHEN bookmarks.bookmark_id IS NOT NULL AND bookmarks.selected_date = ? OR CURRENT_TIME() > bookmarks.start_hour THEN 'partially-available'
    WHEN bookmarks.bookmark_id IS NOT NULL AND CURRENT_TIME() < bookmarks.end_hour AND CURRENT_TIME() > bookmarks.start_hour AND bookmarks.selected_date = ? THEN 'Occupied'
  END AS availability_status
  FROM 
  offices_room
  INNER JOIN room room on room.room_id = offices_room.room_id
  LEFT JOIN bookmark bookmarks ON room.room_id = bookmarks.room_id 
    AND bookmarks.selected_date = ?
    AND bookmarks.active = 1
  WHERE 
  offices_room.office_id = (SELECT MIN(offices_room.office_id) FROM offices_room)
  AND offices_room.room_id IS NOT NULL
  " . (isset($_GET['search']) ? "
   AND room.room_id like ? OR
room.room_name like ?
OR room.description like ?" : "") . "
  
  ORDER BY 
  room.room_name;";
  $stmt = $conn->prepare($sql);
  if (isset($_GET['search'])) {
    $search = "%".$search."%";
    $stmt->bind_param("sssssss", $selectedDate, $selectedDate, $selectedDate, $selectedDate, $search, $search, $search);
  } else {
    $stmt->bind_param("ssss", $selectedDate, $selectedDate, $selectedDate, $selectedDate);
  }
}


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
$roomarray = array();

$stats = "";
while ($row = $result->fetch_assoc()) {

  $roomarray[] = '<div class="col-md-4">' .
    '<div class="card mb-4 ' . getRoomClass($row) . '">' .
    '<div class="card-body">' .
    '<h5 class="card-title">' . htmlspecialchars($row["room_name"]) . '</h5>' .
    '<p class="card-text">' . htmlspecialchars($row["description"]) . '</p>' .
    '<p class="card-text"> Space:' . htmlspecialchars($row["space"]) . '</p>' .
    '<p class="room-status ' . getRoomStatusClass($row) . '">' . getRoomStatusLabel($row) . '</p>' .
    '<button type="button" class="btn btn-primary" onclick="location.href=\'room_reserve.php?room_id=' . $row["room_id"] . '&selecteddate_js=' . $selectedDate . '\';">Reserve</button> ' .
    '</div>' .
    '</div>' .
    '</div>';
  

  $selectedOfficeId = $row['office_id'];

  // Output the room list
}
$sql = "SELECT b.building_name, o.office_name from buildings as b 
INNER JOIN building_offices bo on bo.building_id = b.building_id
INNER JOIN offices o on o.office_id = bo.office_id
WHERE bo.office_id = $selectedOfficeId";
try {
  $result = $conn->query($sql);

  echo "<div class='container mt-5'>
<h2 class='mb-3'>";
  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      $stats = "<p>Building: " . $row['building_name'] . "</p>" .
        " </p>Office: " . $row['office_name'] . "</p>";
    }
  }
  echo $stats;

  echo "</h2>";
  echo "<br>";
  echo '<div class="container">';
  echo '<div class="row">';
  
  foreach ($roomarray as $room) {
    echo $room;
  }
//  unset($roomarray);
  echo "</div>";
  echo "</div>";
  echo "</div>";
} catch (Exception $e) {
  echo '<p>Message: No office associated with the selected building';
  echo '<p>System error: ' .  $e->getMessage();
}
// Get the CSS class for the room based on its availability
function getRoomClass($row)
{
  return $row["availability_status"];
}

function getRoomStatusClass($row)
{
  switch ($row["availability_status"]) {
    case 'occupied':
      return 'text-danger';
    case 'partially-available':
      return 'text-warning';
    default:
      return 'text-success';
  }
}

function getRoomStatusLabel($row)
{
  switch ($row["availability_status"]) {
    case 'occupied':
      return 'Occupied';
    case 'partially-available':
      return 'Partially Available';
    default:
      return 'Available';
  }
}
?>
