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
        }
    </style>
</head>
<body>
    <h1>Combined Data Display</h1>
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
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

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['update'])) {
                    $reserve_id = $_POST['reserve_id'];
                    $room_status = $_POST['room_status'];
                    $sql_update = "UPDATE admin_status SET room_status='$room_status' WHERE reserve_id='$reserve_id'";
                    if ($conn->query($sql_update) === TRUE) {
                        echo "<p>Record updated successfully</p>";
                    } else {
                        echo "<p>Error updating record: " . $conn->error . "</p>";
                    }
                } elseif (isset($_POST['delete'])) {
                    $reserve_id = $_POST['reserve_id'];
                    $sql_delete = "DELETE FROM reservation_details WHERE reserve_id='$reserve_id'";
                    if ($conn->query($sql_delete) === TRUE) {
                        echo "<p>Record deleted successfully</p>";
                    } else {
                        echo "<p>Error deleting record: " . $conn->error . "</p>";
                    }
                }
            }

            $sql = "SELECT 
                        rd.reserve_id, ur.lastname, ur.firstname, ur.middlename, ur.extensionname, ur.contact_num, ur.email,
                        ui.street_num, ui.street_name, ui.district, ui.city, ui.barangay, ui.zip_code,
                        rd.room_type, rd.arrival_date, rd.days_stay, rd.num_rooms, rd.num_adults, rd.num_childs,
                        cr.reason, rd.total_payment, ast.room_status
                    FROM reservation_details rd
                    LEFT JOIN user_registration ur ON rd.reg_id = ur.reg_id
                    LEFT JOIN user_info ui ON rd.reg_id = ui.reg_id
                    LEFT JOIN cancel_request cr ON rd.reg_id = cr.reg_id
                    LEFT JOIN admin_status ast ON rd.reserve_id = ast.reserve_id
                    ORDER BY rd.reserve_id DESC";

            $result = $conn->query($sql);

            if ($result === false) {
                die("Error executing the query: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["reserve_id"] . "</td>
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
                                <form method='post' action=''>
                                    <input type='hidden' name='reserve_id' value='" . $row["reserve_id"] . "'>
                                    <select name='room_status'>
                                        <option value='Pending' " . ($row["room_status"] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                        <option value='Check In' " . ($row["room_status"] == 'Check In' ? 'selected' : '') . ">Check In</option>
                                        <option value='Check Out' " . ($row["room_status"] == 'Check Out' ? 'selected' : '') . ">Check Out</option>
                                        <option value='Failed' " . ($row["room_status"] == 'Failed' ? 'selected' : '') . ">Failed</option>
                                    </select>
                            </td>
                            <td>
                                    <button type='submit' name='update'>Update</button>
                                    <button type='submit' name='delete'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='23'>No data found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
