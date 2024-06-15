<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation Form</title>
    <link rel="stylesheet" href="reservation_form5.css">
    
</head>
<body>
<div class="container">
    <div class="maincard">
        <div class="card">
            <img src="img/celestial.png" alt="">
        </div>

        <form id="reservationForm" action="reserve_backend.php" method="post">
            <div class="card">
                <div class="heading">
                    <h1>Hotel Reservation Form</h1>
                </div>

                <div class="box1">
                    <h2>Personal Information</h2>
                    <div class="form_maincard">
                        <div class="card_form">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" required>
                        </div>

                        <div class="card_form">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" required>
                        </div>

                        <div class="card_form">
                            <label for="middlename">Middle Name</label>
                            <input type="text" id="middlename" name="middlename" required>
                        </div> 
                    </div>

                    <div class="card_form2">
                        <label for="extentsionname">Extension Name</label>
                        <input type="text" id="extensionname" name="extensionname">
                    </div>
                </div>

                <div class="box2">
                    <h2>Contact Information</h2>
                    <p>Address</p>

                    <div class="form_maincard">
                        <div class="card_form">
                            <label for="street_num">Street Number</label>
                            <input type="text" id="street_num" name="street_num" required>
                        </div>

                        <div class="card_form">
                            <label for="street_name">Street Name</label>
                            <input type="text" id="street_name" name="street_name" required>
                        </div>

                        <div class="card_form">
                            <label for="district">District</label>
                            <input type="text" id="district" name="district" required>
                        </div> 
                    </div>

                    <div class="form_maincard1">
                        <div class="card_form">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" required>
                        </div>

                        <div class="card_form">
                            <label for="barangay">Barangay</label>
                            <input type="text" id="barangay" name="barangay" required>
                        </div>

                        <div class="card_form">
                            <label for="zip_code">Zip Code</label>
                            <input type="text" id="zip_code" name="zip_code" required>
                        </div> 
                    </div>

                    <div class="form_maincard2">
                        <div class="card_form">
                            <label for="contact_num">Contact Number</label>
                            <input type="text" id="contact_num" name="contact_num" required>
                        </div>

                        <div class="card_form">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="room_type" name="room_type" value="<?php echo isset($_GET['room_type']) ? $_GET['room_type'] : ''; ?>"> <!-- Hidden input para sa room type para pumasok sa database -->
                <input type="hidden" id="total_payment_input" name="total_payment" value="0"> <!-- Hidden input para sa total payment para pumasok sa database -->
                <div class="box3">
                    <h2>Reservation Details</h2>
                    <h3>Room Type: <?php echo isset($_GET['room_type']) ? $_GET['room_type'] : 'N/A'; ?></h3>
                   
                    <div class="form_maincard">
                        <div class="card_form">
                            <label for="arrival_date">Arrival Date</label>
                            <input type="date" id="arrival_date" name="arrival_date" required>
                        </div>

                        <div class="card_form">
                            <label for="days_stay">Days of Stay</label>
                            <input type="text" id="days_stay" name="days_stay" required onchange="calculateTotal()">
                        </div>

                        <div class="card_form">
                            <label for="num_rooms">Number of Rooms</label>
                            <input type="text" id="num_rooms" name="num_rooms" required onchange="calculateTotal()">
                        </div> 
                    </div>

                    <div class="form_maincard2">
                        <div class="card_form">
                            <label for="num_adults">Number of Adults</label>
                            <input type="text" id="num_adults" name="num_adults" required>
                        </div>

                        <div class="card_form">
                            <label for="num_childs">Number of Children /*if applicable</label>
                            <input type="text" id="num_childs" name="num_childs">
                        </div>
                    </div>

                    <div class="payment" id="total_payment">
                        <p>Total Payment: ₱ 0</p>
                    </div>
                    
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="popup" class="popup">
    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="25" fill="none" stroke="#4CAF50" stroke-width="2"/>
        <path fill="none" stroke="#4CAF50" stroke-width="2" d="M14 27l6 6 16-16"/>
    </svg>
    <h2>Reservation Complete!</h2>
    <p>Thank you for choosing Hotel Celestial for your stay! Please arrive at the hotel on your check-in date and 
        settle your payment at the front desk. Don't forget to bring a valid ID for verification upon arrival.
         We look forward to welcoming you!</p>
    <button onclick="closePopup()">Close</button>
</div>


<script>
    function calculateTotal() {
        var daysStay = parseInt(document.getElementById('days_stay').value);
        var numRooms = parseInt(document.getElementById('num_rooms').value);
        var roomType = "<?php echo isset($_GET['room_type']) ? $_GET['room_type'] : ''; ?>";
        var pricePerRoom;

        switch (roomType) {
            case 'Standard Room':
                pricePerRoom = 6000;
                break;
            case 'Double Room':
                pricePerRoom = 12000;
                break;
            case 'Suite Room':
                pricePerRoom = 18000;
                break;
            case 'Deluxe Room':
                pricePerRoom = 24000;
                break;
            default:
                pricePerRoom = 0;
        }

        var totalPayment = daysStay * numRooms * pricePerRoom;
        document.getElementById('total_payment').innerText = "Total Payment: ₱ " + totalPayment;
        document.getElementById('total_payment_input').value = totalPayment;
    }

    function showPopup() {
        document.getElementById('popup').style.display = 'block';
        document.querySelector('.container').classList.add('blur-bg');
    }

    function closePopup() {
        window.location.href = 'header.php'; 
    }

    document.getElementById('reservationForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        var formData = new FormData(this);

        fetch('reserve_backend.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes('Reservation submitted successfully!')) {
                showPopup();
            } else {
                alert(data);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
</body>
</html>
