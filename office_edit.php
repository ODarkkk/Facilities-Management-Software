<?php
include_once 'config.php';
if (!isset($_SESSION['user_id']) && $_SESSION['admin'] != 1) {
    header("location: logout.php");
    exit(); // Ensure script stops after redirect
}
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $building_id = $POST['building_id'];
    $room_id = $_POST['room_id'];

    $sql = "UPDATE office SET office_name=?, description=?, office_image=? WHERE office_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssbi", $name, $description, $image, $id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Record updated successfully</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating record: ' . $conn->error . '</div>';
    }

    // Atualizar a associação na tabela buildings_offices
    $sql = "UPDATE buildings_offices SET office_id=? WHERE building_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id,  $building_id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Office association updated successfully</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating office association: ' . $conn->error . '</div>';
    }
    // Atualizar a associação na tabela offices_room
    $sql = "UPDATE offices_room SET office_id=? WHERE room_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $room_id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Office association updated successfully</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating office association: ' . $conn->error . '</div>';
    }
}
// Busca os detalhes atuais do room
$sql = "SELECT o.office_id, o.office_name, o.description, o.office_image, r.room_id, b.building_id
 FROM offices o 
LEFT JOIN offices_room r ON r.office_id = o.office_id
LEFT JOIN building_offices b ON b.office_id = o.office_id
WHERE o.office_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$BuildingOptions = '';
$sql = "Select building_id, building_name from buildings";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($building = $result->fetch_assoc()) {
        $selected = ($building['building_id'] == $row['building_id']) ? 'selected' : '';
        $BuildingOptions .= "<option value='{$building['building_id']}' $selected>{$building['building_name']}</option>";
    }
}

// Busca todos os offices disponíveis
$RoomOptions = '';
$sql = "SELECT room_id, room_name FROM room";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($room = $result->fetch_assoc()) {
        $selected = ($room['room_id'] == $row['room_id']) ? 'selected' : '';
        $RoomOptions .= "<option value='{$room['room_id']}' $selected>{$room['room_name']}</option>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <noscript>
        <style type="text/css">
            .pagecontainer {
                display: none;
            }
        </style>
        <div class="noscriptmsg">
            You don't have javascript enabled. For this site to work, javascript is required. </div>
    </noscript>

</head>

<body>

    <p>

    <nav class="navbar navbar-light bg-light navbar-expand-lg navbar-light" style="transition: height 0.5s; margin:2%">
        <div class="container-fluid">
            <div class="col-md-1">
                <img src="images/esgc.png" class="rounded img-fluid img-small w-50" alt="company_logo">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column" id="navbarNav">
                <div class="navbar-nav ms-0 me-5  mt-auto"> <!-- Aplicando a classe me-auto para mover o session user para a margem esquerda -->
                    <a class="nav-link" href="./index.php">Home</a>
                    <a class="nav-link" href="./marks.php">Marks</a>
                    <a class="nav-link" href="./tickets.php">Recovers requests</a>
                    <a class="nav-link" href="./user_list.php">Users</a>
                    <a class="nav-link" href="./roles.php">Roles</a>
                    <a class="nav-link" href="./installations.php.php">installations</a>
                </div>

                <div class="navbar-nav mb-auto ms-auto"> <!-- Mantendo os links à direita -->
                    <div class="nav-link">
                        <?php
                        echo $_SESSION['user'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    </p>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Edit office</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['office_name']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"><?php echo $row['description']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="space" class="form-label">Image</label>
                                <input type="number" class="form-control" id="image" name="image" value="<?php echo $row['office_image']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="office" class="form-label">Building</label>
                                <select class="form-select" id="building" name="building_id">
                                    <?php echo $BuildingOptions; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="office" class="form-label">Room</label>
                                <select class="form-select" id="room" name="room_id">
                                    <?php echo $RoomOptions; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0">
        <label class="switch">
            <span class="sun"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g fill="#ffd43b">
                        <circle r="5" cy="12" cx="12"></circle>
                        <path d="m21 13h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm-17 0h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm13.66-5.66a1 1 0 0 1 -.66-.29 1 1 0 0 1 0-1.41l.71-.71a1 1 0 1 1 1.41 1.41l-.71.71a1 1 0 0 1 -.75.29zm-12.02 12.02a1 1 0 0 1 -.71-.29 1 1 0 0 1 0-1.41l.71-.66a1 1 0 0 1 1.41 1.41l-.71.71a1 1 0 0 1 -.7.24zm6.36-14.36a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm0 17a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm-5.66-14.66a1 1 0 0 1 -.7-.29l-.71-.71a1 1 0 0 1 1.41-1.41l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.29zm12.02 12.02a1 1 0 0 1 -.7-.29l-.66-.71a1 1 0 0 1 1.36-1.36l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.24z"></path>
                    </g>
                </svg></span>
            <span class="moon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path d="m223.5 32c-123.5 0-223.5 100.3-223.5 224s100 224 223.5 224c60.6 0 115.5-24.2 155.8-63.4 5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6-96.9 0-175.5-78.8-175.5-176 0-65.8 36-123.1 89.3-153.3 6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z"></path>
                </svg></span>
            <input type="checkbox" class="input" id="toggleButton" onclick="toggleMode()">
            <span class="slider"></span>
        </label>
    </div>

    <div class="position-relative">

    <div class="position-absolute top-0 end-0">
    <a class="Btn" onclick="goBack()">

      <div class="sign"><svg viewBox="0 0 512 512">
          <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
        </svg></div>

      <div class="text">Back</div>
    </a>
  </div>

    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </div>
</body>

</html>