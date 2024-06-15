<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="registration3.css">
</head>
<body>
    <div class="main-container">
        <div class="reg">
            <h1>Registration Form</h1>
        </div>

        <form action="submit_registration.php" method="post">
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

                    <input type="radio" id="accept" name="acknowledgment" value="accept">
                    <label for="accept">I hereby acknowledge that I have read, and <span class="accept">do accept</span> the Data Privacy Policy contained in this form.</label><br>
        
                    <input type="radio" id="decline" name="acknowledgment" value="decline">
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
