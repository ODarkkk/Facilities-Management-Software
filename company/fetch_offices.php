<?php
// Include the database configuration file
include_once('config.php');

// Get the selected building ID
$selectedBuildingId = null;
$sql = null;

if (isset($_GET['buildingId'])) {
    $selectedBuildingId = $_GET['buildingId'];
    $sql = "SELECT * FROM building_offices AS b
                           INNER JOIN offices AS o ON o.office_id = b.office_id
                           WHERE b.building_Id = ?";
} else {
    $sql = "SELECT o.* FROM building_offices AS b
                           INNER JOIN offices AS o ON o.office_id = b.office_id
                           WHERE b.building_Id = (SELECT MIN(building_id) FROM building_offices)";
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// If a building ID was selected, bind it to the statement
if ($selectedBuildingId !== null) {
    $stmt->bind_param("i", $selectedBuildingId);
}

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
// Check if there are results
if ($result->num_rows > 0) {
    // Start the select element
    echo "<select class='form-select' id='officeSelect' name='selectedOfficeId'>";

    // Loop through results and print combobox options
    while($row = $result->fetch_assoc()) {
        echo "<option value='". $row["office_id"]. "'>". $row["office_name"]. "</option>";
    }
 
    // End the select element
    echo "</select>";
    
} else {
    echo "<option value=''>No offices found</option>";
}
