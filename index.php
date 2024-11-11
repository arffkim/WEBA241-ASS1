<?php
session_start();
include("dbconnect.php"); // Include database connection

if (isset($_POST['submit'])) {
    $email = $_POST['useremail'];
    $passwordraw = $_POST['password'];
    
    // Prepare SQL with placeholders to check the users table
    $sqllogin = "SELECT `email`, `password` FROM `users` WHERE `email` = :email";
    
    try {
        $stmt = $conn->prepare($sqllogin);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify if user exists and password matches
        if ($user && password_verify($passwordraw, $user['password'])) {
            $_SESSION['sessionid'] = session_id();
            $_SESSION['useremail'] = $email;

            // Check if "Remember Me" is selected
            if (isset($_POST['rememberme'])) {
                setcookie("useremail", $email, time() + (86400 * 30), "/"); // 30-day expiration
            } else {
                // Clear any existing cookie if "Remember Me" is unchecked
                if (isset($_COOKIE['useremail'])) {
                    setcookie("useremail", "", time() - 3600, "/"); // Expire the cookie
                }
            }

            echo "<script>alert('Login successful!')</script>";
            echo "<script>window.location.replace('home.php')</script>";
        } else {
            echo "<script>alert('Invalid email or password')</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error occurred: " . $e->getMessage() . "')</script>";
    }
}

// Check if the user has a "Remember Me" cookie set
if (isset($_COOKIE['useremail']) && !isset($_SESSION['useremail'])) {
    $_SESSION['useremail'] = $_COOKIE['useremail'];
    echo "<script>window.location.replace('home.php')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
    <header class="w3-center w3-padding-32 w3-teal">
        <h1>Arif Event Solutions Sdn Bhd</h1>
        <h3>Your Two Step Ahead Event Manager</h3>
    </header>
    
    <div class="w3-hide-small" style="height:100px"></div>
    
    <div class="w3-container" style="max-width: 400px; margin:auto">
        <h2 class="w3-center">Login</h2>
        <form action="index.php" method="post">
            <input class="w3-input w3-round w3-border" type="email" id="useremailid" name="useremail" placeholder="Enter Email" required 
                   value="<?php echo isset($_COOKIE['useremail']) ? $_COOKIE['useremail'] : ''; ?>"><br>
            <input class="w3-input w3-round w3-border" type="password" id="passwordid" name="password" placeholder="Enter Password" required><br>
            <p>Remember Me
                <input type="checkbox" name="rememberme" id="checkboxid" <?php echo isset($_COOKIE['useremail']) ? 'checked' : ''; ?>>
            </p>
            <input class="w3-button w3-teal w3-round w3-block" type="submit" name="submit" value="Login">
        </form>
    </div>

    <div class="w3-center w3-container" style="margin-top:20px">
        <a href="register.php">Register</a>
    </div>
    
    <div class="w3-hide-small" style="height:200px"></div>
    
    <footer class="w3-container w3-grey">
        <p class="w3-center">&copy; 2024 Arif Event Solutions Sdn Bhd</p>
    </footer>
</body>
</html>
