<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelcelestial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT room_type, num_available FROM rooms";
$result = $conn->query($sql);

$rooms = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rooms[$row["room_type"]] = $row["num_available"];
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Page</title>
    <link rel="stylesheet" href="header5.css">
    <link href="https://api.fontshare.com/v2/css?f[]=lora@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="navbar">
    <img src="img/celestial.png" alt="">
    <ul class="navbar-links">
        <li><a href="landing.php#home">Home</a></li>
        <li><a href="landing.php#about">About</a></li>
        <li><a href="landing.php#services">Services</a></li>
        <li><a href="landing.php#contacts">Contacts</a></li>
        <li><a href="cancel.php">Cancel</a></li>
        <li><a href="index.php" class="logout">Logout</a></li>
    </ul>
</div>

<div class="top-container">
    <div class="text-container">
        <h1>Arrange <br> Your Stay <br> With Us</h1>
    </div>
    <div class="paragraph">
        <p>Find the perfect <br> accommodation for your trip. <br> Choose from our range of <br>comfortable rooms and 
            suites <br> to suit your needs.</p>
    </div>
    <div class="main-container">
        <img src="img/main_reservation.jpg" alt="">
    </div>
</div>

<img src="img/standard.jpg" alt="" class="img-standard">
<img src="img/double.jpg" alt="" class="img-double">
<div class="second-container">
    <div class="card1">
        <h1 class="standard-h1">Standard Room</h1>
        <h2 class="h2-available"><?php echo isset($rooms['Standard Room']) ? $rooms['Standard Room'] : 'N/A'; ?> Rooms Available</h2>
        <h2 class="price-h2">₱6,000.00 / 24 HRS.</h2>
        <p class="p-standard">Our standard room offers a cozy and inviting space designed for your comfort and convenience. 
            Whether you're traveling solo, with a partner, or as a small family, our standard room is <br> the perfect 
            choice for a relaxing stay.</p>
        <hr class="styled-hr">
        <div class="room-features">
            <h2 class="h2-room-features">Room Features</h2>
            <div class="main-room">
                <div class="card-room">
                    <p>✔ 1 Bedroom</p>
                    <p>✔ TV</p>
                    <p>✔ Workstation</p>
                </div>
                <div class="card-room">
                    <p>✔ Mini - Refrigerator</p>
                    <p>✔ Free Wifi</p>
                    <p>✔ Aircondition</p>
                </div>
            </div>
        </div>
        <button class="btn" type="button" onclick="redirectToReservation('Standard Room', <?php echo isset($rooms['Standard Room']) ? $rooms['Standard Room'] : 0; ?>);">Book Now</button>
    </div>
    <div class="card1">
        <h1 class="standard-h1">Double Room</h1>
        <h2 class="h2-available"><?php echo isset($rooms['Double Room']) ? $rooms['Double Room'] : 'N/A'; ?> Rooms Available</h2>
        <h2 class="price-h2-one">₱12,000.00 / 24 HRS.</h2>
        <p class="p-standard-one">Our double room offers a stylish and relaxing retreat for couples or travelers 
            seeking extra space and comfort. Whether you're visiting for business or leisure, our 
            well-appointed double room is designed to make your stay memorable.</p>
        <hr class="styled-hr-one">
        <div class="room-features">
            <h2 class="h2-room-features">Room Features</h2>
            <div class="main-room">
                <div class="card-room">
                    <p>✔ 2 Bedroom</p>
                    <p>✔ TV</p>
                    <p>✔ Workstation</p>
                </div>
                <div class="card-room">
                    <p>✔ Mini - Refrigerator</p>
                    <p>✔ Free Wifi</p>
                    <p>✔ Aircondition</p>
                </div>
            </div>
        </div>
        <button class="btn" type="button" onclick="redirectToReservation('Double Room', <?php echo isset($rooms['Double Room']) ? $rooms['Double Room'] : 0; ?>);">Book Now</button>
    </div> 
</div>

<img src="img/suite.jpg" alt="" class="img-suite">
<img src="img/deluxe.jpg" alt="" class="img-deluxe">
<div class="third-container">
    <div class="card2">
        <h1 class="standard-h1">Suite Room</h1>
        <h2 class="h2-available"><?php echo isset($rooms['Suite Room']) ? $rooms['Suite Room'] : 'N/A'; ?> Rooms Available</h2>
        <h2 class="price-h2-one">₱18,000.00 / 24 HRS.</h2>
        <p class="p-standard">Experience the epitome of luxury and comfort in our suite room, designed to 
            exceed your expectations. Whether you're celebrating a special occasion or simply seeking a 
            lavish retreat, our suite promises an unforgettable stay.</p>
        <hr class="styled-hr">
        <div class="room-features">
            <h2 class="h2-room-features">Room Features</h2>
            <div class="main-room">
                <div class="card-room">
                    <p>✔ 1 King Size Bed</p>
                    <p>✔ TV</p>
                    <p>✔ Workstation</p>
                    <p>✔ Dining Space</p>
                </div>
                <div class="card-room">
                    <p>✔ Living Area</p>
                    <p>✔ Kitchenette</p>
                    <p>✔ Free Wifi</p>
                    <p>✔ Aircondition</p>
                </div>
            </div>
        </div>
        <button class="btn" type="button" onclick="redirectToReservation('Suite Room', <?php echo isset($rooms['Suite Room']) ? $rooms['Suite Room'] : 0; ?>);">Book Now</button>
    </div>
    <div class="card2">
        <h1 class="standard-h1">Deluxe Room</h1>
        <h2 class="h2-available"><?php echo isset($rooms['Deluxe Room']) ? $rooms['Deluxe Room'] : 'N/A'; ?> Rooms Available</h2>
        <h2 class="price-h2-one">₱24,000.00 / 24 HRS.</h2>
        <p class="p-standard">Our deluxe room style meets comfort in a sophisticated setting. 
            Ideal for both business and leisure travelers, our deluxe room offers a serene oasis in 
            the heart of [location], promising a memorable stay.</p>
        <hr class="styled-hr">
        <div class="room-features">
            <h2 class="h2-room-features">Room Features</h2>
            <div class="main-room1">
                <div class="card-room1">
                    <p>✔ 2 King Size Bed</p>
                    <p>✔ TV</p>
                    <p>✔ Workstation</p>
                    <p>✔ Balcony</p>
                    <p>✔ Dining Space</p>
                </div>
                <div class="card-room1">
                    <p>✔ Living Area</p>
                    <p>✔ Kitchenette</p>
                    <p>✔ Free Wifi</p>
                    <p>✔ Aircondition</p>
                    <p>✔ Modern Decor</p>
                </div>
            </div>
        </div>
        <button class="btn1" type="button" onclick="redirectToReservation('Deluxe Room', <?php echo isset($rooms['Deluxe Room']) ? $rooms['Deluxe Room'] : 0; ?>);">Book Now</button>
    </div>
</div>

<div class="footer">
    <h1>Where Luxury Meets the Stars</h1>
    <p>Experience the epitome of luxury and refinement at Hotel Celestial, where every detail has been 
        meticulously crafted to provide an unforgettable five-star experience.</p>
    <div class="footer-content">
        <div class="contact-info">
            <h2 class="contact-heading">Contact Information</h2>
            <div class="card-contact">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="card-contact">
                <i class="fas fa-phone"></i>
            </div>
            <div class="card-contact">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="card-contact1">
                <p>123 Serenity Boulevard <br> Tranquilville, Oasis Region</p>
                <p class="tel">+1 (555) 123-4567 (sales) 
                   <br>+1 (555) 987-6543 (service)</p>
                <p class="email">celestialhotel@gmail.com</p>
            </div>
        </div>
        <div class="vertical-line"></div>
        <div class="social-media">
            <h2 class="contact-heading">Social Media</h2>
            <div class="icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <svg class="error-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle cx="26" cy="26" r="25" fill="none" stroke="#FF0000" stroke-width="2"/>
            <path fill="none" stroke="#FF0000" stroke-width="2" d="M16 16 36 36 M36 16 16 36"/>
        </svg>
        <p>No rooms available for this room type.</p>
        <button class="close-btn">Close</button>
    </div>
</div>

<script src="header2.js"></script>
<script>
    function redirectToReservation(roomType, numAvailable) {
        if (numAvailable > 0) {
            window.location.href = 'reservation_form.php?room_type=' + encodeURIComponent(roomType);
        } else {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
        }
    }

    var closeBtn = document.getElementsByClassName("close-btn")[0];
    closeBtn.onclick = function() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
