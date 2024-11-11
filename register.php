<?php
session_start();
include("dbconnect.php"); // Include database connection

if (isset($_POST['submit'])) {
    // Form validation
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters long!";
    } else {
        // Check if email already exists
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $message = "Email already registered!";
        } else {
            // Insert new user data into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (full_name, email, password, phone_number, address) VALUES (:name, :email, :password, :phone, :address)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Registration successful!";
                echo "<script>
                        alert('Registration successful!');
                        document.getElementById('registerForm').reset();
                      </script>";
            } else {
                $message = "Error: Unable to register.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <header class="w3-center w3-padding-32 w3-teal">
        <h1>Arif Event Solutions Sdn Bhd</h1>
        <h3>Your Two Step Ahead Event Manager</h3>
    </header>

    <div class="w3-container" style="max-width: 400px; margin:auto; padding-top: 20px;">
        <h2>Register</h2>
        
        <!-- Display session message if it exists -->
        <?php
        if (isset($message)) {
            echo "<p class='w3-text-red'>$message</p>";
        } elseif (isset($_SESSION['message'])) {
            echo "<p class='w3-text-green'>{$_SESSION['message']}</p>";
            unset($_SESSION['message']); // Clear message after displaying
        }
        ?>

        <form id="registerForm" class="w3-container" method="post" action="register.php">
            <p><label>Full Name</label>
            <input class="w3-input w3-border" type="text" name="name" required></p>
            
            <p><label>Email</label>
            <input class="w3-input w3-border" type="email" name="email" required></p>
            
            <p><label>Password</label>
            <input class="w3-input w3-border" type="password" name="password" required minlength="8"></p>
            
            <p><label>Phone Number</label>
            <input class="w3-input w3-border" type="tel" name="phone" required></p>
            
            <p><label>Address</label>
            <textarea class="w3-input w3-border" name="address" required></textarea></p>
            
            <button class="w3-button w3-teal w3-margin-top" type="submit" name="submit">Register</button>
        </form>
    </div>

    <div class="w3-center w3-container" style="margin-top:20px">
        <a href="index.php">Already have an account? Login here</a>
    </div>

    <footer class="w3-container w3-grey w3-padding-16">
        <p class="w3-center">&copy; 2024 Arif Event Solutions Sdn Bhd</p>
    </footer>
</body>
</html>
