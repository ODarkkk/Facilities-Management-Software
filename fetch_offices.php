<?php
// Include the database configuration file
include_once('config.php');

$selectedBuildingId = isset($_GET['selectedBuildingId'])?$_GET['selectedBuildingId']:null;

// echo  $selectedBuildingId;

if (isset($_GET['selectedBuildingId'])) {
    $sql = "SELECT * FROM offices AS o
                           INNER JOIN building_offices AS b ON b.office_id = o.office_id
                           WHERE b.building_id = ?";
} else {
    $sql = "SELECT * FROM offices AS o
                           INNER JOIN building_offices AS b ON b.office_id = o.office_id
                           WHERE b.building_id = (SELECT MIN(building_id) FROM building_offices)";
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// If a building ID was selected, bind it to the statement
if ($selectedBuildingId != null) {
    $stmt->bind_param("i", $selectedBuildingId);
}

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
// Check if there are results
if ($result->num_rows > 0) {
    $imageData = $row["office_image"];
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
    // Start the select element
    echo "<select class='form-select' id='roomSelect' name='selectedOfficeId'>";

    // Loop through results and print combobox options
    while($row = $result->fetch_assoc()) {
        echo "<option value='". $row["office_id"]. "'>". $row["office_name"]. "</option>";
        // "<p><img src='data:". $mimeType ."; base64,".base64_encode($imageData)."' alt='" . $row['office_name'] . "image' class='img-fluid'/></p>;
        
    }
 
    // End the select element
    echo "</select>";
   
    
} else {
    echo "<option value=''>No rooms found</option>";
}
