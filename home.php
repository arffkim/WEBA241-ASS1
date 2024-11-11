<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['useremail'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        /* Ensure the footer stays at the bottom */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        
        .content {
            flex: 1;
        }
        
        .footer {
            text-align: center;
            padding: 16px;
            background-color: #grey;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="w3-center w3-padding-32 w3-teal">
        <h1>Welcome to Arif Event Solutions Sdn Bhd</h1>
        <h3>Your Two Step Ahead Event Manager</h3>
    </header>

    <!-- Main Content -->
    <div class="w3-container content" style="max-width: 800px; margin: auto; padding-top: 20px;">
        <h2 class="w3-center">Hello, <?php echo htmlspecialchars($_SESSION['useremail']); ?>!</h2>
        <p class="w3-center">Welcome to your dashboard.</p>
        
        <div class="w3-row-padding" style="margin-top: 30px;">
            <div class="w3-third w3-center">
                <div class="w3-card w3-padding w3-round w3-teal">
                    <h3>Profile</h3>
                    <p>View and edit your profile details.</p>
                </div>
            </div>
            <div class="w3-third w3-center">
                <div class="w3-card w3-padding w3-round w3-teal">
                    <h3>Events</h3>
                    <p>Check out upcoming events and book your spots.</p>
                </div>
            </div>
            <div class="w3-third w3-center">
                <div class="w3-card w3-padding w3-round w3-teal">
                    <h3>Contact Us</h3>
                    <p>Reach out for support or inquiries.</p>
                </div>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="w3-center" style="margin-top: 40px;">
            <a href="logout.php" class="w3-button w3-red w3-round">Logout</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-grey footer">
        <p class="w3-center">&copy; 2024 Arif Event Solutions Sdn Bhd</p>
    </footer>
</body>
</html>
