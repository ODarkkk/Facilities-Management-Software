<?php
include_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
}

$search = isset($_GET['usersearch']) ? $_GET['usersearch'] : "";
if (strlen(trim($search)) == 0) {
    $_GET['usersearch'] = null;
}


// Select all users
$sql = "SELECT p.*,
        CASE WHEN p.role_department_id IS NULL THEN 'No department assigned' ELSE d.department END AS department,
        CASE WHEN p.role_department_id IS NULL THEN 'No role assigned' ELSE r.role END AS role
        FROM people p
        LEFT JOIN roles_department rd ON rd.roles_department_id = p.role_department_id
        LEFT JOIN department d ON d.department_id = rd.department_id
        LEFT JOIN roles r on r.role_id = rd.role_id ";

if ($_GET['usersearch'] != null) {
    $sql .= " WHERE p.user LIKE '%" . $conn->real_escape_string($search) . "%' 
          OR p.name LIKE '%" . $conn->real_escape_string($search) . "%'
          OR p.email LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$sql .= "Order by p.name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $list = array();
    while ($row = $result->fetch_assoc()) {
        // echo "<form action='add_user.php' method='post'>";
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
        }
        if($_SESSION['admin']== 1){

           $btt = '<button type="button" class="btn btn-primary" onclick="confirmAction(\'' . $row["user"] . $row["people_id"] . '\')">Edit</button>' .
            '<button class="btn ' . ($row["active"] == 1 ? 'btn-danger' : 'btn-secondary') . '"
              onclick="return confirm(\'Are you sure you want to change the active status of ' . $row["user"] . '?\') && changeActiveStatus(' . $row["people_id"] . ', ' . ($row["active"] == 1 ? 0 : 1) . ')">';
        }
        echo '<div class="col-md-4">' .
            '<div class="card mb-4">' .
            '<div class="card-body">' .
            '<h5 class="card-title">' . htmlspecialchars($row["user"]) . '</h5>' .
            '<p class="card-text">' . htmlspecialchars($row["name"]) . '</p>' .
            '<p class="card-text">' .
            (!empty($row["photo"]) ? '<img src="data:' . $mimeType . '; base64,' . base64_encode($imageData) . '" alt="' . $row["user"] . 'photo" class="img-fluid"/>' : 'No picture') .
            '</p>' .
            '<p class="card-text">' . htmlspecialchars($row["email"]) . '</p>' .
            '<p class="card-text">' . htmlspecialchars($row["phone"]) . '</p>' .
            '<p class="card-text">' . htmlspecialchars($row["department"]) . '</p>' .
            '<p class="card-text">' . htmlspecialchars($row["role"]) . '</p>' .
            '<p class="card-text">' . ($row["admin"] ? "Admin" : "Not Admin") . '</p>' .
            '<p class="card-text">Password status: ' . ($row["password_status"] ? "Will Changed" : "It won't change") . '</p>' .
            '<div class="d-flex justify-content-between align-items-center">' .
             $btt.
            ($row["active"] == 1 ? 'Active' : 'Don\'t Active') . ' </button>' .
            '</div>' .
            '</div>' .
            '</div>' .
            '</div>';
    }
} else {
    echo "<div class='col-md-4'><p>No users found.</p></div>";
}
