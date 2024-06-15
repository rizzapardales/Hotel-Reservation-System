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
    $arrival_date = $_POST['arrival_date'];
    $days_stay = $_POST['days_stay'];
    $num_rooms = $_POST['num_rooms'];
    $num_adults = $_POST['num_adults'];
    $num_childs = $_POST['num_childs'];
    $room_type = $_POST['room_type'];
    $total_payment = $_POST['total_payment'];

    // ichecheck ilang room ang available 
    $room_query = "SELECT num_available FROM rooms WHERE room_type = '$room_type'";
    $room_result = $conn->query($room_query);

    if ($room_result->num_rows > 0) {
        $room_row = $room_result->fetch_assoc();
        $num_available = $room_row['num_available'];

        if ($num_available >= $num_rooms) {
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

                $reservation_query = "INSERT INTO reservation_details (reg_id, arrival_date, days_stay, num_rooms, num_adults, num_childs, room_type, total_payment) VALUES ('$reg_id', '$arrival_date', '$days_stay', '$num_rooms', '$num_adults', '$num_childs', '$room_type', '$total_payment')";
                if ($conn->query($reservation_query) !== TRUE) {
                    die("Error inserting reservation details: " . $conn->error);
                }

                // Uupdate yung room available depende sa ilan nalang matitira
                $new_num_available = $num_available - $num_rooms;
                $update_rooms_query = "UPDATE rooms SET num_available = '$new_num_available' WHERE room_type = '$room_type'";
                if ($conn->query($update_rooms_query) !== TRUE) {
                    die("Error updating room availability: " . $conn->error);
                }

                echo "Reservation submitted successfully!";
            } else {
                echo "Email not found in the database. Please register first.";
            }
        } else {
            echo "Not enough rooms available. Please adjust the number of rooms.";
        }
    } else {
        echo "Room type not found.";
    }
}

$conn->close();
?>
