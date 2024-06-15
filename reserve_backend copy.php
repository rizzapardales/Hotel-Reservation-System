<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "hotelcelestial";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Personal Information
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $extensionname = $_POST['extensionname'];
    $email = $_POST['email']; 

    // Contact Information
    $street_num = $_POST['street_num'];
    $street_name = $_POST['street_name'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $zip_code = $_POST['zip_code'];
    $contact_num = $_POST['contact_num']; 

    // Reservation Details
    $check_in = $_POST['check_in'];
    $days_stay = $_POST['days_stay'];
    $num_rooms = $_POST['num_rooms'];
    $num_adults = $_POST['num_adults'];
    $num_childs = $_POST['num_childs'];
    $room_type = $_POST['room_type'];
    $total_payment = $_POST['total_payment']; 

   
    //sa email magbabase para sa foreign key ng other tables
    $user_query = "SELECT reg_id FROM user_registration WHERE email = '$email'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $reg_id = $user_row['reg_id'];

       
        $personal_query = "UPDATE user_registration SET lastname='$lastname', firstname='$firstname', middlename='$middlename', extensionname='$extensionname', contact_num='$contact_num' WHERE reg_id='$reg_id'";
        if ($conn->query($personal_query) !== TRUE) {
            die("Error updating personal information: " . $conn->error);
        }

        
        $contact_query = "INSERT INTO user_info (reg_id, street_num, street_name, district, city, barangay, zip_code) VALUES ('$reg_id', '$street_num', '$street_name', '$district', '$city', '$barangay', '$zip_code')";
        if ($conn->query($contact_query) !== TRUE) {
            die("Error inserting contact information: " . $conn->error);
        }

      
        $reservation_query = "INSERT INTO reservation_details (reg_id, check_in, days_stay, num_rooms, num_adults, num_childs, room_type, total_payment) VALUES ('$reg_id', '$check_in', '$days_stay', '$num_rooms', '$num_adults', '$num_childs', '$room_type', '$total_payment')";
        if ($conn->query($reservation_query) !== TRUE) {
            die("Error inserting reservation details: " . $conn->error);
        }

        echo "Reservation submitted successfully!";
    } else {
        echo "Email not found in the database. Please register first.";
    }
}


$conn->close();
?>
