<?php
require "../connection.php";
session_start();
if (isset($_GET['task_title'])) {
    $user_id = $_SESSION['user_id'];
    $task_title= trim($_GET['task_title']);

    $query = "SELECT tasks.*, categories.name AS category_name 
    FROM tasks 
    JOIN categories ON tasks.category_id = categories.id 
    WHERE tasks.user_id = $user_id 
    AND tasks.title LIKE '$task_title%'"; 
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {
        echo"no task found";
    }else {
        
        while ($row = mysqli_fetch_array($result)) {
            // Convert category name to a CSS-friendly class
            
            
            
            $category_class = $row["category_name"]; // e.g., "To Do" -> "to-do"
            
            echo '<li class="task-card" id='. $category_class .'>';
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
            echo '</li>';
        }
        
        
    }
        
    }

?>