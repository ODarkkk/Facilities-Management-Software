<?php
include_once("config.php");

$selectedBuildingId = isset($_GET['selectedBuildingId']) ? $_GET['selectedBuildingId'] : null;


if ($selectedBuildingId !== null) {
    $sql = "SELECT * FROM buildings
    WHERE building_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $selectedBuildingId);
    $stmt->execute();
    $result = $stmt->get_result();

} 

else{
    $sql = "SELECT MIN(building_id), buildings.* FROM buildings";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
}
// echo $sql;  //For sql debugging
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
   
    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
} else {
    echo "No details available.";
}

?>
