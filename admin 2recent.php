<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Data Display</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            position: relative;
        }
        .room-number-container {
            display: flex;
            align-items: center;
            position: relative;
        }
        .room-number-container select {
            margin-left: 5px;
        }
        .room-numbers {
            position: relative;
            padding-top: 25px; /* Add padding to avoid overlap with + button */
        }
        .add-button {
            position: absolute;
            top: 0;
            right: 0;
            margin-top: 5px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h1>Combined Data Display</h1>
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotelcelestial";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $reserve_id = $_POST['reserve_id'];
            $room_status = $_POST['room_status'];
            $room_numbers = isset($_POST['room_number']) ? (array)$_POST['room_number'] : [];  // Ensure this is an array
            $room_numbers_str = implode(",", $room_numbers);
            $sql_update = "UPDATE reservation_details SET room_status='$room_status', room_number='$room_numbers_str' WHERE reserve_id='$reserve_id'";
            if ($conn->query($sql_update) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } elseif (isset($_POST['delete'])) {
            $reserve_id = $_POST['reserve_id'];
            $sql_delete = "DELETE FROM reservation_details WHERE reserve_id='$reserve_id'";
            if ($conn->query($sql_delete) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    }

    $sql = "SELECT 
                rd.reserve_id, ur.lastname, ur.firstname, ur.middlename, ur.extensionname, ur.contact_num, ur.email,
                ui.street_num, ui.street_name, ui.district, ui.city, ui.barangay, ui.zip_code,
                rd.room_type, rd.arrival_date, rd.days_stay, rd.num_rooms, rd.num_adults, rd.num_childs,
                rd.room_status, cr.reason, rd.total_payment, rd.room_number 
            FROM reservation_details rd
            LEFT JOIN user_registration ur ON rd.reg_id = ur.reg_id
            LEFT JOIN user_info ui ON rd.reg_id = ui.reg_id
            LEFT JOIN cancel_request cr ON rd.reg_id = cr.reg_id
            ORDER BY rd.reserve_id DESC";

    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing the query: " . $conn->error);
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Reserve ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Extension Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Street Number</th>
                <th>Street Name</th>
                <th>District</th>
                <th>City</th>
                <th>Barangay</th>
                <th>Zip Code</th>
                <th>Room Type</th>
                <th>Arrival Date</th>
                <th>Days of Stay</th>
                <th>Number of Rooms</th>
                <th>Number of Adults</th>
                <th>Number of Children</th>
                <th>Cancellation Reason</th>
                <th>Total Payment</th>
                <th>Room Status</th>
                <th>Room Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $room_numbers = explode(",", $row["room_number"]);
                    echo "<tr class='reserve-row'>
                            <form method='post' action=''>
                                <td>" . $row["reserve_id"] . "<input type='hidden' name='reserve_id' value='" . $row["reserve_id"] . "'></td>
                                <td>" . $row["lastname"] . "</td>
                                <td>" . $row["firstname"] . "</td>
                                <td>" . $row["middlename"] . "</td>
                                <td>" . $row["extensionname"] . "</td>
                                <td>" . $row["contact_num"] . "</td>
                                <td>" . $row["email"] . "</td>
                                <td>" . $row["street_num"] . "</td>
                                <td>" . $row["street_name"] . "</td>
                                <td>" . $row["district"] . "</td>
                                <td>" . $row["city"] . "</td>
                                <td>" . $row["barangay"] . "</td>
                                <td>" . $row["zip_code"] . "</td>
                                <td>" . $row["room_type"] . "</td>
                                <td>" . $row["arrival_date"] . "</td>
                                <td>" . $row["days_stay"] . "</td>
                                <td>" . $row["num_rooms"] . "</td>
                                <td>" . $row["num_adults"] . "</td>
                                <td>" . $row["num_childs"] . "</td>
                                <td>" . $row["reason"] . "</td>
                                <td>" . $row["total_payment"] . "</td>
                                <td>
                                    <select name='room_status'>
                                        <option value='Pending'" . ($row["room_status"] == "Pending" ? " selected" : "") . ">Pending</option>
                                        <option value='Check In'" . ($row["room_status"] == "Check In" ? " selected" : "") . ">Check In</option>
                                        <option value='Check Out'" . ($row["room_status"] == "Check Out" ? " selected" : "") . ">Check Out</option>
                                        <option value='Failed'" . ($row["room_status"] == "Failed" ? " selected" : "") . ">Failed</option>
                                    </select>
                                </td>
                                <td class='room-numbers'>";
                                    foreach ($room_numbers as $room_number) {
                                        echo "<div class='room-number-container'>
                                                <button type='button' onclick='removeRoomNumber(this)'>-</button>
                                                <select name='room_number[]'>
                                                    <option value='None'" . ($room_number == "None" ? " selected" : "") . ">None</option>
                                                    <option value='Room 1'" . ($room_number == "Room 1" ? " selected" : "") . ">Room 1</option>
                                                    <option value='Room 2'" . ($room_number == "Room 2" ? " selected" : "") . ">Room 2</option>
                                                    <option value='Room 3'" . ($room_number == "Room 3" ? " selected" : "") . ">Room 3</option>
                                                    <option value='Room 4'" . ($room_number == "Room 4" ? " selected" : "") . ">Room 4</option>
                                                    <option value='Room 5'" . ($room_number == "Room 5" ? " selected" : "") . ">Room 5</option>
                                                </select>
                                              </div>";
                                    }
                    echo "      <button type='button' class='add-button' onclick='addRoomNumber(this)'>+</button>
                                </td>
                                <td>
                                    <button type='submit' name='update'>Update</button>
                                    <button type='submit' name='delete' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</button>
                                </td>
                            </form>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='24'>No data found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <script>
        function addRoomNumber(button) {
            const cell = button.parentElement;
            const newDiv = document.createElement('div');
            newDiv.classList.add('room-number-container');
            newDiv.innerHTML = `
                <button type='button' onclick='removeRoomNumber(this)'>-</button>
                <select name='room_number[]'>
                    <option value='None'>None</option>
                    <option value='Room 1'>Room 1</option>
                    <option value='Room 2'>Room 2</option>
                    <option value='Room 3'>Room 3</option>
                    <option value='Room 4'>Room 4</option>
                    <option value='Room 5'>Room 5</option>
                </select>`;
            cell.insertBefore(newDiv, button);
        }

        function removeRoomNumber(button) {
            const div = button.parentElement;
            div.parentElement.removeChild(div);
        }
    </script>
</body>
</html>
