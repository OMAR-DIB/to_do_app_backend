<?php
require "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    // Get the task ID from the POST request
    $task_id = intval($_POST['task_id']);

    // Prepare the DELETE query
    $query = "DELETE FROM tasks WHERE id = $task_id";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        // Handle errors
        echo "Error deleting task: " . mysqli_error($conn);
    }
} else {
    // Handle invalid access
    echo "Invalid request.";
}

mysqli_close($conn);
?>
