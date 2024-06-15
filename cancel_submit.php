<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelcelestial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contact_num = $_POST['contact_num'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("SELECT reg_id FROM user_registration WHERE email = ? AND contact_num = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $contact_num);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $reg_id = $row['reg_id'];

        $stmt = $conn->prepare("INSERT INTO cancel_request (reg_id, reason) VALUES (?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("is", $reg_id, $reason);
        if ($stmt->execute()) {
            echo "Cancel request submitted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "No user found with the provided email and contact number.";
    }

    $stmt->close();
}

$conn->close();
?>
