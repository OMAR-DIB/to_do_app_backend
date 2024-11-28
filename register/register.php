<?php
require "../connection.php"; // Connect to the database

// Initialize variables for form input and error handling
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $email_check_result = mysqli_query($conn, $email_check_query);

        if (mysqli_num_rows($email_check_result) > 0) {
            $error = "Email already exists.";
        } else {
            // Hash the password before storing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $query = "INSERT INTO users (username, email, password, created_at) 
                      VALUES ('$username', '$email', '$hashed_password', NOW())";
            if (mysqli_query($conn, $query)) {
                $success = "Registration successful! You can now <a href='../login/login.php'>login</a>.";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./register.css">
    <title>Register</title>
    <style>

    </style>
</head>
<body>
<div class="register-container">
    <h1>Register</h1>

    <!-- Display error message if any -->
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>

    <!-- Display success message if registration is successful -->
    <?php if ($success) echo "<div class='success'>$success</div>"; ?>

    <!-- Registration form -->
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>
    <div class="nav-link">
         <p>Already have an account? <a href="../login/login.php">Login here</a></p>
    </div>
</div>
</body>
</html>
