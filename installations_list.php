
<?php

include_once 'config.php';
$_GET['value'] = isset($_GET['value']) ? $_GET['value']: "";
$sql = "";
$search = isset($_GET['installsearch']) ? $_GET['installsearch'] : "";
if (strlen(trim($search)) == 0){
  $_GET['installsearch'] = null;
}

switch ($_GET['value']){
    case "room":
        $sql = "SELECT 'room' as type, room.room_id AS id, room.room_name AS name, room.space AS space, room.description AS description FROM `room` ". (isset($_GET['installsearch']) ? "WHERE name LIKE ?" : "") ." order by name ASC";
        $stmt = $conn->prepare($sql);
        if(isset($_GET['installsearch'])){
            $search = "%".$search."%";
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt ->get_result();
        }
        else{
            $result = mysqli_query($conn, $sql);
        }
        break;
    case "office":
        $sql = "SELECT 'office' as type, offices.office_id AS id, offices.office_name AS name, offices.office_image AS office_image, offices.description AS description FROM `offices` ". (isset($_GET['installsearch']) ? "
       where office_name LIKE ?" : "") ." order by office_name ASC";
      
       $stmt = $conn->prepare($sql);
       if(isset($_GET['installsearch'])){
        $search = "%".$search."%";
           $stmt->bind_param("s", $search);
           $stmt->execute();
           $result = $stmt ->get_result();
       }
       else{
           $result = mysqli_query($conn, $sql);
       }
        break;
    case "building":
        $sql = "SELECT 'building' as type,  buildings.building_id AS id, buildings.building_name AS name, buildings.description AS description  FROM `buildings` ". (isset($_GET['installsearch']) ? "
        WHERE building_name LIKE ?" : "") ."order BY building_name ASC";
        $stmt = $conn->prepare($sql);
        if(isset($_GET['installsearch'])){
            $search = "%".$search."%";
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt ->get_result();
        }
        else{
            $result = mysqli_query($conn, $sql);
        }
        break;

    default:
  // Fetch data from buildings table
  $sql = "(SELECT 'room' AS type, room.room_id AS id, room.room_name AS name, room.space AS space, NULL AS office_image, room.description AS description
  FROM room " .
(isset($_GET['installsearch']) ? "WHERE room.room_name LIKE ? OR room.description LIKE ?" : "") . ")
UNION ALL
(SELECT 'office' AS type, offices.office_id AS id, offices.office_name AS name, NULL AS space, offices.office_image AS office_image, offices.description AS description
  FROM offices " .
(isset($_GET['installsearch']) ? "WHERE offices.office_name LIKE ? OR offices.description LIKE ?" : "") . ")
UNION ALL
(SELECT 'building' AS type, buildings.building_id AS id, buildings.building_name AS name, NULL AS space, NULL AS office_image, buildings.description AS description
  FROM buildings " .
(isset($_GET['installsearch']) ? "WHERE buildings.building_name LIKE ? OR buildings.description LIKE ?" : "") . ")
ORDER BY name";
$stmt = $conn->prepare($sql);

if (isset($_GET['installsearch'])) {
    $search = "%" . $_GET['installsearch'] . "%";
    $stmt->bind_param("ssssss", $search, $search, $search, $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}
break;

}
while ($row = $result->fetch_assoc()) {
  $cardClass = 'primary';
  $entityType = $row['type'];
  $entityId = $row['id'];
  $cardTitle = $row['name'];
  $cardText = $row['description'];

  if ($entityType == 'room') {
      $cardText .= "<br>Space: " . $row['space'];
  } elseif ($entityType == 'office') {
    if (!empty($row["photo"])) {
      $imageData = null;
      $imageData = $row["photo"];
      $tempFileName = tempnam(sys_get_temp_dir(), 'image');
      file_put_contents($tempFileName, $imageData);
      $imageType = exif_imagetype($tempFileName);
      $mimeType = "";
      switch ($imageType) {
        case IMAGETYPE_JPEG:
          $mimeType = "image/jpeg";
          break;
        case IMAGETYPE_PNG:
          $mimeType = "image/png";
          break;
        default:
          $mimeType = "application/octet-stream";
        }
      $cardText .= "<br><img src='data:".$mimeType.";base64," . base64_encode($imageData) . "' alt='Office Image' />";
      }
  }

    // switch ($row['entity_type']) {
    //     case 'Building':
    //       $cardText .= "Building: {$row['building_name']}<br>";
    //       $entityId = $row['building_id'];
    //       $cardTitle = $row['building_name'];
    //       break;
    //     case 'Office':
    //       $cardText .= "Office: {$row['office_name']}<br>";
    //       if ($row['building_name']) {
    //         $cardText .= "Building: {$row['building_name']}<br>";
    //       }
    //       $entityId = $row['office_id'];
    //       $cardTitle = $row['office_name'];
    //       break;
    //     case 'Room':
    //       $cardText .= "Room: {$row['room_name']}<br>";
    //       if ($row['office_name']) {
    //         $cardText .= "Office: {$row['office_name']}<br>";
    //       }
    //       if ($row['building_name']) {
    //         $cardText .= "Building: {$row['building_name']}<br>";
    //       }
    //       $entityId = $row['room_id'];
    //       $cardTitle = $row['room_name'];
    //       break;
    //   } //ignore

    echo "
    <div class=\"col-md-4\">
      <div class=\"card mb-4 card-{$cardClass}\">
        <div class=\"card-body\">
          <h5 class=\"card-title\">{$cardTitle}</h5>
          <p class=\"card-text\">{$cardText}</p>
          " . ($_SESSION['admin'] == 1 ? "
          <div class=\"d-flex justify-content-end\">
            <a href=\"{$entityType}_edit.php?id={$entityId}\" class=\"btn btn-secondary me-2\">Edit</a>
            <a href=\"{$entityType}_delete.php?id={$entityId}\" class=\"btn btn-danger\" onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</a>
          </div>
          " : "") . "
        </div>
      </div>
    </div>
  ";
    


}
