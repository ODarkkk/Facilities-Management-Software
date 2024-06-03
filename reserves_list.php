<?php
include_once("config.php"); // Adjust the include file as needed

// Get the selected filter value from the AJAX request
$selectedDate = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : date('Y-m-d');

$search = isset($_GET['marksearch']) ? $_GET['marksearch'] : "";
$active = isset($_GET['active']) ? $_GET['active'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$filterType = $type ? $type->type : null;
$filterValue = $type ? $type->value : null;

if (strlen(trim($search)) == 0){
  $_GET['marksearch'] = null;
}



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

if (!is_null($filterType) && !is_null($filterValue)) {

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
" . (isset($_GET['marksearch']) ? "
people.user = ?
" . ($filterType === 'office' ? "
OR offices.office_id = " . $filterValue . "
OR offices.office_name like %?%" : "") . "
" . ($filterType === 'building' ? "
OR building.building_id " . $filterValue . "
OR building.building_name like %?%" : "") . "
" . ($filterType === 'room' ? "
OR room.room_id =" . $filterValue . "
OR room.room_name like %?%" : "") . "
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
bookmark.bookmark_id,
bookmark.selected_date,
bookmark.start_hour,
bookmark.end_hour
FROM bookmark, buildings, room, offices
WHERE
bookmark.selected_date = ?
AND 
bookmark.active = " . $active;
if (isset($_GET['marksearch'])) {
  $sql .= " AND (
                  people.user like ?
                  OR building.building_name = ?
                  OR offices.office_name = ?
                  OR room.room_name = ?
              )";
}
$sql .=" ORDER BY
bookmark.bookmark_id;";
}

// echo $sql;
$stmt = $conn->prepare($sql);

if (isset($_GET['marksearch'])) {
  $search = "%".$search."%";
  $stmt->bind_param("sssss", $selectedDate, $search, $search, $search, $search);
} else {
  $stmt->bind_param("s", $selectedDate);
}


// Execute the query and fetch the results

$stmt->execute();
$result = $stmt->get_result();



if ($result->num_rows > 0) {
  $markarray = array();

  while ($row = $result->fetch_assoc()) {

    $buttons = '';
    if($_SESSION['admin'] == 1)
    {
      
      $buttons = '<button type="button" class="btn btn-secundary" onclick="location.href=\'reserves_edit.php?bookmarkid=' . $row["bookmark_id"] . '\';">Edit</button> '.
       '<button type="button" class="btn btn-danger" onclick="location.href=\'reserves_delete.php?bookmarkid=' . $row["bookmark_id"] . '\';">Delete</button> ';
    }
    $markarray[] = '<div class="col-md-4">' .
      '<div class="card mb-4"  >' .
      '<div class="card-body">' .
      '<h5 class="card-title">' . htmlspecialchars($row[$name."_name"]) . '</h5>' .
      '<p class="card-text">' . htmlspecialchars($row["description"]) . '</p>' .
      '<button type="button" class="btn btn-primary" onclick="location.href=\'reserves_view.php?bookmarkid=' . $row["bookmark_id"] . '&selecteddate_js=' . $selectedDate . '\';">Reserve</button> ' .
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
