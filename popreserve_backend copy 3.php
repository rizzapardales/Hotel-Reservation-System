<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
</head>
<body>
    <h1>Reservation Form</h1>
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

        // Check room availability
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

                    // Check if contact information already exists
                    $contact_check_query = "SELECT * FROM user_info WHERE reg_id='$reg_id'";
                    $contact_check_result = $conn->query($contact_check_query);

                    if ($contact_check_result->num_rows > 0) {
                        $contact_query = "UPDATE user_info SET street_num='$street_num', street_name='$street_name', district='$district', city='$city', barangay='$barangay', zip_code='$zip_code' WHERE reg_id='$reg_id'";
                    } else {
                        $contact_query = "INSERT INTO user_info (reg_id, street_num, street_name, district, city, barangay, zip_code) VALUES ('$reg_id', '$street_num', '$street_name', '$district', '$city', '$barangay', '$zip_code')";
                    }

                    if ($conn->query($contact_query) !== TRUE) {
                        die("Error inserting/updating contact information: " . $conn->error);
                    }

                    // Check if the reservation already exists
                    $reservation_check_query = "SELECT * FROM reservation_details WHERE reg_id='$reg_id' AND arrival_date='$arrival_date' AND room_type='$room_type'";
                    $reservation_check_result = $conn->query($reservation_check_query);

                    if ($reservation_check_result->num_rows > 0) {
                        echo "Reservation already exists.";
                    } else {
                        // Insert reservation details
                        $reservation_query = "INSERT INTO reservation_details (reg_id, arrival_date, days_stay, num_rooms, num_adults, num_childs, room_type, total_payment, room_status) VALUES ('$reg_id', '$arrival_date', '$days_stay', '$num_rooms', '$num_adults', '$num_childs', '$room_type', '$total_payment', 'Pending')";
                        if ($conn->query($reservation_query) !== TRUE) {
                            die("Error inserting reservation details: " . $conn->error);
                        }

                        // Update room availability
                        $new_num_available = $num_available - $num_rooms;
                        $update_rooms_query = "UPDATE rooms SET num_available = '$new_num_available' WHERE room_type = '$room_type'";
                        if ($conn->query($update_rooms_query) !== TRUE) {
                            die("Error updating room availability: " . $conn->error);
                        }

                        echo "Reservation submitted successfully!";
                    }
                } else {
                    // Insert new user
                    $user_insert_query = "INSERT INTO user_registration (lastname, firstname, middlename, extensionname, contact_num, email) VALUES ('$lastname', '$firstname', '$middlename', '$extensionname', '$contact_num', '$email')";
                    if ($conn->query($user_insert_query) !== TRUE) {
                        die("Error inserting user information: " . $conn->error);
                    }

                    $reg_id = $conn->insert_id;

                    $contact_query = "INSERT INTO user_info (reg_id, street_num, street_name, district, city, barangay, zip_code) VALUES ('$reg_id', '$street_num', '$street_name', '$district', '$city', '$barangay', '$zip_code')";
                    if ($conn->query($contact_query) !== TRUE) {
                        die("Error inserting contact information: " . $conn->error);
                    }

                    // Insert reservation details
                    $reservation_query = "INSERT INTO reservation_details (reg_id, arrival_date, days_stay, num_rooms, num_adults, num_childs, room_type, total_payment, room_status) VALUES ('$reg_id', '$arrival_date', '$days_stay', '$num_rooms', '$num_adults', '$num_childs', '$room_type', '$total_payment', 'Pending')";
                    if ($conn->query($reservation_query) !== TRUE) {
                        die("Error inserting reservation details: " . $conn->error);
                    }

                    // Update room availability
                    $new_num_available = $num_available - $num_rooms;
                    $update_rooms_query = "UPDATE rooms SET num_available = '$new_num_available' WHERE room_type = '$room_type'";
                    if ($conn->query($update_rooms_query) !== TRUE) {
                        die("Error updating room availability: " . $conn->error);
                    }

                    echo "Reservation submitted successfully!";
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
</body>
</html>
