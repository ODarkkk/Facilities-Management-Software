<?php
// Include the database configuration file
include_once('config.php');

// Query to fetch buildings
$sql = "SELECT building_id, building_name, description FROM buildings";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Start the select element
    // echo "<select class='form-select' id='buildingSelect' name='selectedBuildingId'>";

    // Loop through results and print combobox options
    while($row = $result->fetch_assoc()) {
        echo "<option value='". $row["building_id"]. "' data-description='". $row["description"]. "'>". $row["building_name"]. "</option>";
    }
 
    // End the select element
    // echo "</select>";
    
} else {
    echo "<option value=''>No buildings found</option>";
}
?>