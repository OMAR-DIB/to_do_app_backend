<?php
require '../connection.php';

// Create User
function createUser($username, $email, $password) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    return mysqli_query($conn, $query);
}

// Read Users
function getUsers() {
    global $conn;
    $query = "SELECT id, username, email, created_at FROM users";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Update User
function updateUser($id, $username, $email, $password = null) {
    global $conn;
    if ($password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = '$username', email = '$email', password = '$hashedPassword' WHERE id = $id";
    } else {
        $query = "UPDATE users SET username = '$username', email = '$email' WHERE id = $id";
    }
    return mysqli_query($conn, $query);
}

// Delete User
function deleteUser($id) {
    global $conn;
    $query = "DELETE FROM users WHERE id = $id";
    return mysqli_query($conn, $query);
}
?>
