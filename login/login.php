<?php
require "../connection.php"; // Connect to the database

session_start(); // Start the session

// for pop pop
// After successful login
// $_SESSION['username'] = $username; // Set the logged-in username
// $_SESSION['welcome_message'] = true; // Set a flag for showing the welcome message
// header("Location: ../index.php"); // Redirect to the main page
// exit();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if the user exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id']; // Save user ID in session
            $_SESSION['username'] = $user['username']; // Save username in session  
            $_SESSION['welcome_message'] = true;
            header("Location: ../index.php"); // Redirect to the main page
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <title>Login</title>
    <style>

    </style>
</head>
<body>
<div class="login-container">
    <h1>Login</h1>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <div class="nav-link">
    <p>Don't have an account? <a href="../register/register.php">Register here</a></p>
</div>
</div>
</body>
</html>
