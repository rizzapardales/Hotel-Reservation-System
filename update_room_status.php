<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelcelestial";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data sent from the AJAX request
$reserveId = $_POST['reserve_id'];
$roomStatus = $_POST['room_status'];

// Prepare and execute the SQL query to update the room status
$sql = "UPDATE admin_status AS a
        INNER JOIN reservation_details AS rd ON a.reserve_id = rd.reserve_id
        SET a.room_status = ?
        WHERE rd.reserve_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("si", $roomStatus, $reserveId);

if ($stmt->execute()) {
    echo "Room status updated successfully";
} else {
    echo "Error updating room status: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
