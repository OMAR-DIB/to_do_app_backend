<?php

// Create Task
function createTask($userId, $categoryId, $title, $description, $dueDate) {
    global $conn;
    $query = "INSERT INTO tasks (user_id, category_id, title, description, due_date) 
              VALUES ($userId, $categoryId, '$title', '$description', '$dueDate')";
    return mysqli_query($conn, $query);
}

// Read Tasks
function getTasks() {
    global $conn;
    $query = "SELECT tasks.id, tasks.title, tasks.description, tasks.due_date, tasks.reminder_sent, 
                     users.username, categories.name AS category
              FROM tasks
              INNER JOIN users ON tasks.user_id = users.id
              INNER JOIN categories ON tasks.category_id = categories.id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Update Task
function updateTask($id, $categoryId, $title, $description, $dueDate, $reminderSent) {
    global $conn;
    $query = "UPDATE tasks 
              SET category_id = $categoryId, title = '$title', description = '$description', 
                  due_date = '$dueDate', reminder_sent = $reminderSent 
              WHERE id = $id";
    return mysqli_query($conn, $query);
}

// Delete Task
function deleteTask($id) {
    global $conn;
    $query = "DELETE FROM tasks WHERE id = $id";
    return mysqli_query($conn, $query);
}
?>
