<?php
include_once("config.php"); // Adjust the include file as needed

// Get the selected filter value from the AJAX request
$selectedDate = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : date('Y-m-d');

$search = isset($_GET['marksearch']) ? $_GET['marksearch'] : "";
$active = isset($_GET['active']) ? $_GET['active'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$filterType = isset($type['type']) ? $type['type'] : null;
$filterValue = isset($type['value']) ? $type['value'] : null;
if (strlen(trim($search)) == 0){
  $_GET['marksearch'] = null;
}





if (!is_null($filterType) && !is_null($filterValue)) {

$sql = "
(SELECT 'office' AS type,
offices.office_id AS id,
offices.office_name AS name,
NULL AS space,
offices.office_image AS office_image,
offices.description AS description,
people.people_id,
people.user,
bookmarks.bookmark_id,
bookmarks.selected_date,
bookmarks.start_hour,
bookmarks.end_hour
FROM bookmarks
INNER JOIN offices_room ON offices_room.room_id = bookmarks.room_id
INNER JOIN offices ON offices_room.office_id = offices.office_id
INNER JOIN people ON people.people_id = bookmarks.people_id
WHERE bookmarks.selected_date = ?
AND bookmarks.active = " . $active . "
" . (isset($_GET['marksearch']) ? "AND (
    people.user LIKE ?
    OR offices.office_id = " . $filterValue . "
    OR offices.office_name LIKE ?" : "") . "
)
UNION ALL
(SELECT 'building' AS type,
buildings.building_id AS id,
buildings.building_name AS name,
NULL AS space,
NULL AS office_image,
buildings.description AS description,
people.people_id,
people.user,
bookmarks.bookmark_id,
bookmarks.selected_date,
bookmarks.start_hour,
bookmarks.end_hour
FROM bookmarks
INNER JOIN offices_room ON offices_room.room_id = bookmarks.room_id
INNER JOIN offices ON offices_room.office_id = offices.office_id
INNER JOIN building_offices ON building_offices.office_id = offices.office_id
INNER JOIN buildings ON buildings.building_id = building_offices.building_id
INNER JOIN people ON people.people_id = bookmarks.people_id
WHERE bookmarks.selected_date = ?
AND bookmarks.active = " . $active . "
" . (isset($_GET['marksearch']) ? "AND (
    people.user LIKE ?
    OR buildings.building_id = " . $filterValue . "
    OR buildings.building_name LIKE ?" : "") . "
)
UNION ALL
(SELECT 'room' AS type,
room.room_id AS id,
room.room_name AS name,
room.space AS space,
NULL AS office_image,
room.description AS description,
people.people_id,
people.user,
bookmarks.bookmark_id,
bookmarks.selected_date,
bookmarks.start_hour,
bookmarks.end_hour
FROM bookmarks
INNER JOIN offices_room ON offices_room.room_id = bookmarks.room_id
INNER JOIN room ON room.room_id = offices_room.room_id
INNER JOIN people ON people.people_id = bookmarks.people_id
WHERE bookmarks.selected_date = ?
AND bookmarks.active = " . $active . "
" . (isset($_GET['marksearch']) ? "AND (
    people.user LIKE ?
    OR room.room_id = " . $filterValue . "
    OR room.room_name LIKE ?" : "") . "
)
ORDER BY id;
";
} else {
  $sql = "
  (SELECT 'office' AS type,
  offices.office_id AS id,
  offices.office_name AS name,
  NULL AS space,
  offices.office_image AS office_image,
  offices.description AS description,
  people.people_id,
  people.user,
  bookmarks.bookmark_id,
  bookmarks.selected_date,
  bookmarks.start_hour,
  bookmarks.end_hour
  FROM bookmark as bookmarks
  INNER JOIN offices_room ON offices_room.room_id = bookmarks.room_id
  INNER JOIN offices ON offices_room.office_id = offices.office_id
  INNER JOIN people ON people.people_id = bookmarks.people_id
  WHERE bookmarks.selected_date = ?
  AND bookmarks.active = " . $active . ")
UNION ALL
(SELECT 'building' AS type,
buildings.building_id AS id,
buildings.building_name AS name,
NULL AS space,
NULL AS office_image,
buildings.description AS description,
people.people_id,
people.user,
bookmarks.bookmark_id,
bookmarks.selected_date,
bookmarks.start_hour,
bookmarks.end_hour
FROM bookmark as bookmarks
INNER JOIN offices_room ON offices_room.room_id = bookmarks.room_id
INNER JOIN offices ON offices_room.office_id = offices.office_id
INNER JOIN building_offices ON building_offices.office_id = offices.office_id
INNER JOIN buildings ON buildings.building_id = building_offices.building_id
INNER JOIN people ON people.people_id = bookmarks.people_id
WHERE bookmarks.selected_date = ?
AND bookmarks.active = " . $active . ")
UNION ALL
(SELECT 'room' AS type,
room.room_id AS id,
room.room_name AS name,
room.space AS space,
NULL AS office_image,
room.description AS description,
people.people_id,
people.user,
bookmarks.bookmark_id,
bookmarks.selected_date,
bookmarks.start_hour,
bookmarks.end_hour
FROM bookmark as bookmarks
INNER JOIN offices_room ON offices_room.room_id = bookmarks.room_id
INNER JOIN room ON room.room_id = offices_room.room_id
INNER JOIN people ON people.people_id = bookmarks.people_id
WHERE bookmarks.selected_date = ?
AND bookmarks.active = " . $active . ")
ORDER BY id;
";
}

$stmt = $conn->prepare($sql);

if (isset($_GET['marksearch'])) {
  $search = '%' . $_GET['marksearch'] . '%';
  $stmt->bind_param("ssssss", $selectedDate, $search, $search, $search, $search, $search);
} else {
  $stmt->bind_param("sss", $selectedDate, $selectedDate, $selectedDate);
}

// Execute the query and fetch the results

$stmt->execute();
$result = $stmt->get_result();



if ($result->num_rows > 0) {
  $markarray = array();

  while ($row = $result->fetch_assoc()) {

    if($_SESSION['admin'] == 1)
    {
      
      $buttons = '<button type="button" class="btn btn-secundary" onclick="location.href=\'reserves_edit.php?bookmarkid=' . $row["bookmark_id"] . '\';">Edit</button> '.
       '<button type="button" class="btn btn-danger" onclick="location.href=\'reserves_delete.php?bookmarkid=' . $row["bookmark_id"] . '\';">Delete</button> ';
    }
    $markarray[] = '<div class="col-md-4">' .
      '<div class="card mb-4">' .
      '<div class="card-body">' .
      '<h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>' .
      '<p class="card-text"> Reserve ID: '. $row['bookmark_id'] . '</p>'.
      '<br> User: '.htmlspecialchars($row['user']) .
    '<p>' . htmlspecialchars($row["description"]) . '</p>' .
      '<button type="button" class="btn btn-primary" onclick="location.href=\'reserves_view.php?bookmarkid=' . $row["bookmark_id"] . '&selecteddate_js=' . $selectedDate . '\';">View</button> ' .
      $buttons .
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
  echo "<p>Message: No marks associated with the selected filters or there aren't. ";
}
// Get the CSS class for the room based on its availability
