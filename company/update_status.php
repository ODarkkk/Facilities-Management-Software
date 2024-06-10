<?php
include_once("config.php");


// Check if ticket ID is present in the request
if(isset($_GET['id'])) {
    $ticket_id = $_GET['id'];
    $status = $_GET['status'];


    // Update ticket status
    $sql = "UPDATE recover SET status = $status WHERE recover_id = $ticket_id";

    if ($conn->query($sql)) {
        echo "Ticket status updated successfully!";
    } else {
        echo "Error updating ticket status: " . $conn->error;
    }
}

// Redirect back to the tickets page
header("Location: tickets.php");
exit();
?>

