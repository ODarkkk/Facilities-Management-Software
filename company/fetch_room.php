<?php
// Include the database configuration file
include_once('config.php');

// Get the selected building ID
$selectedofficeid = isset($_GET['OfficeId'])? : null;
$sql = null;

if (isset($_GET['OfficeId'])) {
    $sql = "SELECT * FROM offices_room AS o
                           INNER JOIN room AS r ON r.room_id = o.room_id
                           WHERE o.office_id = ?";
     
} else {
    $sql = "SELECT * FROM offices_room AS o
                           INNER JOIN room AS r ON r.room_id = o.room_id
                           WHERE o.office_id = (SELECT MIN(office_id) FROM offices_room)";
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// If a building ID was selected, bind it to the statement
if ($selectedofficeid !== null) {
    $stmt->bind_param("i", $selectedofficeid);
}

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
// Check if there are results
if ($result->num_rows > 0) {
    // Start the select element
    echo "<select class='form-select' id='roomSelect' name='selectedRoomId'>";

    // Loop through results and print combobox options
    while($row = $result->fetch_assoc()) {
        echo "<option value='". $row["room_id"]. "'>". $row["room_name"]. "</option>";
    }
 
    // End the select element
    echo "</select>";
    
} else {
    echo "<option value=''>No rooms found</option>";
}
