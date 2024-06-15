<?php
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

    // Check if the passwords match
    if ($password !== $confirm_pass) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if the Data Privacy Notice is accepted
    if ($acknowledgment !== 'accept') {
        echo "You must accept the Data Privacy Policy.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    $host = 'localhost';
    $username = 'root';
    $db_password = '';  // Change variable name to avoid conflict with $password
    $database = 'hotelcelestial';

    $conn = new mysqli($host, $username, $db_password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Updated table name
    $sql = "INSERT INTO user_registration (lastname, middlename, contact_num, firstname, extensionname, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if prepare() failed
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $lastname, $middlename, $contact_num, $firstname, $extensionname, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
