<?php
include_once('config.php');

$officeId = isset($_GET['officeId']) ? ($_GET['officeId']) : null;
$selectedBuildingId = isset($_GET['selectedBuildingId']) ? $_GET['selectedBuildingId'] : null;


if ($officeId !== null) {

    $sql = "SELECT * FROM offices AS o INNER JOIN building_offices AS b ON b.office_id = o.office_id
    WHERE o.office_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $officeId);
    $stmt->execute();
    $result = $stmt->get_result();

} elseif ($selectedBuildingId !== null) {
    $sql = "SELECT * FROM offices AS o INNER JOIN building_offices AS b ON b.office_id = o.office_id
    WHERE b.building_id = ? AND o.office_id = (SELECT MIN(office_id) FROM building_offices AS b ON b.office_id = o.office_id where building_id = ?)";
    $stmt = $conn->prepare($sql);
    echo $sql;

    $stmt->bind_param("ii", $selectedBuildingId, $selectedBuildingId);
    $stmt->execute();
    $result = $stmt->get_result();
}
else{
    $sql = "SELECT MIN(o.office_id), o.* FROM offices AS o
    INNER JOIN building_offices AS b ON b.office_id = o.office_id
    WHERE b.building_id = (SELECT MIN(building_id) FROM building_offices)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
}
// echo $sql;  //For sql debugging
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row["photo"])) {

        $imageData = null;
        $imageData = $row["image"];
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
    }
    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
    echo !empty($row["photo"]) ? "<img src='data:$mimeType;base64," . base64_encode($imageData) . "' alt='" . htmlspecialchars($row['office_name']) . " image' class='img-fluid'/>" : "";
} else {
    echo "No details available.";
}