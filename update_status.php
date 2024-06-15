<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelcelestial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reserve_id = $_POST['reserve_id'];
    $room_status = $_POST['room_status'];

    $sql = "UPDATE admin_status SET room_status=? WHERE reserve_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $room_status, $reserve_id);

    if ($stmt->execute()) {
        echo "Room status updated successfully!";
    } else {
        echo "Error updating room status: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

header("Location: admin.php");
exit();
?>
