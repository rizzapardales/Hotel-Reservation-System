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

            $sql = "SELECT 
                        rd.reserve_id, ur.lastname, ur.firstname, ur.middlename, ur.contact_num, ur.email,
                        ui.street_num, ui.street_name, ui.district, ui.city, ui.barangay, ui.zip_code,
                        rd.room_type, rd.arrival_date, rd.days_stay, rd.num_rooms, rd.num_adults, rd.num_childs,
                        cr.reason 
                    FROM reservation_details rd
                    LEFT JOIN user_registration ur ON rd.reg_id = ur.reg_id
                    LEFT JOIN user_info ui ON rd.reg_id = ui.reg_id
                    LEFT JOIN cancel_request cr ON rd.reg_id = cr.reg_id
                    ORDER BY rd.reserve_id DESC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["reserve_id"] . "</td>
                            <td>" . $row["lastname"] . "</td>
                            <td>" . $row["firstname"] . "</td>
                            <td>" . $row["middlename"] . "</td>
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
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='19'>No data found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
