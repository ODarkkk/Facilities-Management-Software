

<?php
include_once("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['room_id'])) {
    // Get the form data
    $roomId = $_GET['room_id'];
    $userId = $_SESSION['user_id'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    //  echo $_POST['date'];
    $selectedDate = $_POST['date'];

    // debug_to_console($startTime);
    // debug_to_console($endTime);*
    // echo "<p>starttime: " . $startTime;
    // echo "<p>endtime: ". $endTime;
    // echo "<p>";

    // echo $endTime<$startTime;
    // echo "<br>";
    // // Validate the form data
    // if (empty($roomId) || empty($date) || empty($startTime) || empty($endTime)) {
    //     http_response_code(400);
    //     echo 'Please fill in all the required fields.';
    //     exit;
    // }

    // Check if the end time is before the start time
    if (strtotime($endTime) < strtotime($startTime) || $selectedDate < date('Y-m-d')) {
        http_response_code(400);
        echo 'The end time must be after the start time.';
        header('Refresh: 30; URL=index.php');
        exit;
    }

    // Check if the room is available at the selected time
    $stmt = $conn->prepare('SELECT * FROM bookmark WHERE room_id =? AND selected_date =? AND start_hour <=? AND end_hour >=?');
    $stmt->bind_param('isss', $roomId, $selectedDate, $startTime, $endTime);
    $stmt->execute();
    $overlap = $stmt->get_result()->fetch_assoc();

    if ($overlap) {
        http_response_code(409);
        echo 'Room is already booked at the selected time.';
        exit;
    }

    // Insert the form data into the database
    $stmt = $conn->prepare('INSERT INTO bookmark (room_id, people_id, start_hour, end_hour, selected_date) VALUES (?,?,?,?,?)');
    $stmt->bind_param('issss', $roomId, $userId, $startTime, $endTime, $selectedDate);
    $stmt->execute();

    // Redirect to the success page
    header('Location: index.php');
    exit;
}
