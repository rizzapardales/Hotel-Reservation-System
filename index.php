<?php
session_start();

$host = 'localhost';
$username = 'root';
$db_password = '';
$database = 'hotelcelestial';


$conn = mysqli_connect($host, $username, $db_password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_registration WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        header("Location: landing.php"); 
        exit();
    } else {
        $error = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="main-container">
        <img src="img/celestial.png" alt="">
        <div class="contain">
            <div class="contents">
                <h1>Hello, Guest!</h1>
                <p>Welcome to Celestial Hotel, please log in to continue</p>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required placeholder="juandelacruz@gmail.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="Enter your password">
                    </div>
                </div>
                <button type="submit" class="btn-login">LOGIN</button>
            </form>
        </div>
        <div class="sign">
            <p>Don't have an account? <a href="registration.php">Sign Up</a></p>
        </div>
    </div>

    <!-- Pop up para sa invalid credentials -->
    <div class="popup-container" id="popup">
        <div class="popup-content">
            <svg class="error-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle cx="26" cy="26" r="25" fill="none" stroke="#FF0000" stroke-width="2"/>
                <path fill="none" stroke="#FF0000" stroke-width="2" d="M16 16 36 36 M36 16 16 36"/>
            </svg>
            <h2>Error</h2>
            <p>Invalid email or password. Please try again.</p>
            <button onclick="closePopup()">Close</button>
        </div>
    </div>

     <!-- js para sa pop up -->
    <script>
        function showPopup() {
            document.getElementById('popup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        <?php if (isset($error)) { ?>
            showPopup();
        <?php } ?>
    </script>
</body>
</html>