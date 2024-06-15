<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="registration3.css">

    <!-- js para sa pop up message sa registration -->
    <script>
        function showSuccessMessage() {
            document.querySelector('.main-container').classList.add('blur');
            document.querySelector('.backdrop').style.display = 'block';
            document.querySelector('.modal').style.display = 'block';
        }

        function showErrorMessage(message, critical = false) {
            const errorModal = document.querySelector('.error-modal');
            document.querySelector('.error-message').textContent = message;
            document.querySelector('.main-container').classList.add('blur');
            document.querySelector('.backdrop').style.display = 'block';
            errorModal.style.display = 'block';
            errorModal.dataset.critical = critical;
        }

        function closeModal(isSuccess) {
            const errorModal = document.querySelector('.error-modal');
            const isCritical = errorModal.dataset.critical === "true"; 

            document.querySelector('.main-container').classList.remove('blur');
            document.querySelector('.backdrop').style.display = 'none';
            errorModal.style.display = 'none';

            if (isSuccess) { 
                window.location.href = 'index.php';
            }
        }

        function validatePassword(password) {
            return password.length >= 8;
        }

        function submitForm(event) {
            event.preventDefault();

            const password = document.querySelector('#password').value;
            const confirmPassword = document.querySelector('#confirm_pass').value;

            if (!validatePassword(password)) {
                showErrorMessage('Password must be at least 8 characters long.', true); 
                return;
            }

            if (password !== confirmPassword) {
                showErrorMessage('Passwords do not match.');
                return;
            }

            const formData = new FormData(event.target);

            fetch('submit_registration.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessMessage();
                } else {
                    showErrorMessage(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('An error occurred. Please try again.');
            });
        }
    </script>

</head>
<body>
    <div class="backdrop"></div>

    <!-- check mark para sa pop up -->
    <div class="modal">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle cx="26" cy="26" r="25" fill="none" stroke="#4CAF50" stroke-width="2"/>
            <path fill="none" stroke="#4CAF50" stroke-width="2" d="M14 27l6 6 16-16"/>
        </svg>
        <h2>Registration Successful!</h2>
        <p>Thank you for registering! We're excited to welcome you to our hotel family. Enjoy your stay with us!</p>
        <button onclick="closeModal(true)">Close</button>
    </div>

    <!-- cross mark para sa pop up -->
    <div class="error-modal">
    <svg class="error-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
        <circle cx="26" cy="26" r="25" fill="none" stroke="#FF0000" stroke-width="2"/>
        <path fill="none" stroke="#FF0000" stroke-width="2" d="M16 16 36 36 M36 16 16 36"/>
    </svg>
    <h2>Error</h2>
    <p class="error-message"></p>
    <button onclick="closeModal()">Close</button>
</div>

    <div class="main-container">
        <div class="reg">
            <h1>Registration Form</h1>
        </div>

        <form onsubmit="submitForm(event)">
            <div class="info">
                <h2>Applicant's Information</h2>

                <div class="applicant1">
                    <div class="card">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>

                    <div class="card">
                        <label for="middlename">Middle Name</label>
                        <input type="text" id="middlename" name="middlename" required>
                    </div>

                    <div class="card">
                        <label for="contact_num">Contact Number</label>
                        <input type="text" id="contact_num" name="contact_num" required>
                    </div>
                </div>

                <div class="applicant2">
                    <div class="card">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>

                    <div class="card">
                        <label for="extensionname">Extension Name</label>
                        <input type="text" id="extensionname" name="extensionname">
                    </div>
                </div>

                <div class="account1">
                    <h2>Account Details</h2>
                    <div class="card">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="card">
                        <label for="confirm_pass">Confirm Password</label>
                        <input type="password" id="confirm_pass" name="confirm_pass" required>
                    </div>
                </div>

                <div class="account2">
                    <div class="card">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <div class="data">
                    <h1>DATA PRIVACY NOTICE</h1>
                    <p>We value and protect your personal information in compliance with the Data Privacy Act of 2012 (RA 10173). 
                        All data will be kept secure and confidential by Hotel Celestial only. The information will serve as a 
                        reference for communication. Any personal information will not be disclosed without your consent.</p>

                    <input type="radio" id="accept" name="acknowledgment" value="accept" required>
                  

                    <label for="accept">I hereby acknowledge that I have read, and <span class="accept">do accept</span> the Data Privacy Policy contained in this form.</label><br>
        
                    <input type="radio" id="decline" name="acknowledgment" value="decline" required>
                    <label for="decline">I hereby acknowledge that I have read, and <span class="decline">do not accept</span> the Data Privacy Policy contained in this form.</label><br><br>

                    <div class="button-container">
                        <button type="button" onclick="window.location.href='index.php';">Back</button>
                        <button type="submit">Register</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</body>
</html>
