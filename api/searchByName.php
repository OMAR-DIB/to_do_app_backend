<?php
require "../connection.php";
session_start();

if (isset($_GET['task_title'])) {
    $user_id = $_SESSION['user_id'];
    $task_title = trim($_GET['task_title']);

    // Query to fetch matching tasks
    $query = "SELECT tasks.*, categories.name AS category_name 
              FROM tasks 
              JOIN categories ON tasks.category_id = categories.id 
              WHERE tasks.user_id = $user_id 
              AND tasks.title LIKE '$task_title%'"; 

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        // Output a styled "No tasks found" message
        echo '<li class="task-card no-tasks">';
        echo '<div class="task-details">';
        echo '<div class="task-title">No tasks found.</div>';
        echo '</div>';
        echo '</li>';
    } else {
        // Loop through tasks and output HTML
        while ($row = mysqli_fetch_array($result)) {
            $category_class = strtolower($row["category_name"]);
            echo '<li class="task-card" id="' . $category_class . '">'; // Add category as ID
            echo '<div class="mark">';
            if ($category_class === "done") {
                echo '<span class="checkmark">✔</span>'; // Green check for Done
            } elseif ($category_class === "todo") {
                echo '<span class="todo-indicator">⚡</span>'; // Orange for To Do
            }
            echo '</div>';
            echo '<div class="task-design">';
            echo '<div class="task-details">';
            echo '<div class="task-title">Title: ' . htmlspecialchars($row["title"]) . '</div>';
            echo '<div class="task-description">Description: ' . htmlspecialchars($row["description"]) . '</div>';
            if (!empty($row["due_date"])) {
                echo '<div class="task-due-date">Due Date: ' . htmlspecialchars($row["due_date"]) . '</div>';
            } else {
                echo '<div class="task-due-date">Due Date: Not specified</div>';
            }
            echo '</div>';
            echo '<div class="task-actions">';
            echo '<form action="updateTask.php" method="GET" style="display: inline;">';
            echo '<input type="hidden" name="task_id" value="' . $row["id"] . '">';
            echo '<button class="button update" type="submit">Update</button>';
            echo '</form>';
            echo '<form action="deleteTask.php" method="POST" style="display: inline;">';
            echo '<input type="hidden" name="task_id" value="' . $row["id"] . '">';
            echo '<button class="button delete" type="submit">Delete</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</li>';
        } 
    }
}
?>
