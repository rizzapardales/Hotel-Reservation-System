<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Request Form</title>
    <link rel="stylesheet" href="cancel3.css">
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

    <div class="container">
        <div class="main-container">
            <div class="maincard">
                <div class="card">
                    <img src="img/celestial.png" alt="">
                </div>

                <form id="cancelForm" action="cancel_submit.php" method="post">
                    <div class="card">
                        <div class="heading">
                            <h1>Cancel Request Form</h1>
                        </div>

                        <div class="box1">
                            <div class="form_maincard">
                                <div class="card_form1">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" required>
                                </div>

                                <div class="card_form">
                                    <label for="contact_num">Contact Number</label>
                                    <input type="text" id="contact_num" name="contact_num" required>
                                </div>
                            </div>

                            <div class="card_form2">
                                <label for="reason">Reason</label>
                                <textarea id="reason" name="reason"></textarea>
                            </div>

                            <div class="but">
                                <button type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="popup" class="popup">
    <div class="popup-content">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle cx="26" cy="26" r="25" fill="none" stroke="#4CAF50" stroke-width="2"/>
            <path fill="none" stroke="#4CAF50" stroke-width="2" d="M14 27l6 6 16-16"/>
        </svg>
        <h2>Cancellation Complete</h2>
        <p> With just a few clicks or a quick call to our dedicated reservation team, your reservation is promptly 
            adjusted, ensuring flexibility and peace of mind. Whether your change of plans is due to unforeseen 
            circumstances or a shift in your itinerary, our commitment to exceptional service extends to every 
            aspect of your stay, including cancellations. Rest assured, your comfort and convenience remain our 
            top priority at Hotel Celestial.</p>
        <button onclick="closePopup()">Close</button>
    </div>
</div>

    <script>
        document.getElementById('cancelForm').addEventListener('submit', function(event) {
            event.preventDefault(); 

            var formData = new FormData(this);

            fetch('cancel_submit.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Cancel request submitted successfully.')) {
                    showPopup();
                } else {
                    alert(data); 
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        function showPopup() {
            document.getElementById('popup').style.display = 'block';
        }

        function closePopup() {
            window.location.href = 'landing.php'; 
        }
    </script>
</body>
</html>
