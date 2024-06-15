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

    if ($password !== $confirm_pass) {
        echo "Passwords do not match.";
        exit;
    }

   
    if ($acknowledgment !== 'accept') {
        echo "You must accept the Data Privacy Policy.";
        exit;
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $host = 'localhost';
    $username = 'root';
    $db_password = '';  
    $database = 'hotelcelestial';

    $conn = new mysqli($host, $username, $db_password, $database);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "INSERT INTO user_registration (lastname, middlename, contact_num, firstname, extensionname, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $lastname, $middlename, $contact_num, $firstname, $extensionname, $email, $hashed_password);

    if ($stmt->execute()) {
       
        echo "<script type='text/javascript'>
                alert('Registration successful!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
