<?php
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $contact_num = $_POST['contact_num'];
    $firstname = $_POST['firstname'];
    $extensionname = $_POST['extensionname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];
    $acknowledgment = $_POST['acknowledgment'];

    if ($password !== $confirm_pass) {
        $response["message"] = "Passwords do not match.";
        echo json_encode($response);
        exit;
    }

    if ($acknowledgment !== 'accept') {
        $response["message"] = "You must accept the Data Privacy Policy.";
        echo json_encode($response);
        exit;
    }

    $host = 'localhost';
    $username = 'root';
    $db_password = '';  
    $database = 'hotelcelestial';

    $conn = new mysqli($host, $username, $db_password, $database);

    if ($conn->connect_error) {
        $response["message"] = "Connection failed: " . $conn->connect_error;
        echo json_encode($response);
        exit;
    }

    $sql = "INSERT INTO user_registration (lastname, middlename, contact_num, firstname, extensionname, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $response["message"] = "Error preparing the SQL statement: " . $conn->error;
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("sssssss", $lastname, $middlename, $contact_num, $firstname, $extensionname, $email, $password);

    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "Registration successful!";
    } else {
        $response["message"] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
?>
