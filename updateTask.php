<?php
require "connection.php";

if (isset($_GET['task_id'])) {
    $task_id = intval($_GET['task_id']);

    // Fetch the task details from the database
    $query = "SELECT * FROM tasks WHERE id = $task_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $task = mysqli_fetch_assoc($result);
    } else {
        echo "Task not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Update the task if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $category_id = intval($_POST['category_id']);

    $update_query = "
        UPDATE tasks 
        SET title = '$title', description = '$description', due_date = '$due_date', category_id = $category_id
        WHERE id = $task_id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating task: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <link rel="stylesheet" href="./style/updateTask.css">
</head>
<body>

<div class="container">
    <h1>Update Task</h1>
    <form action="" method="POST">
        <input type="text" name="title" placeholder="Title" value="<?php echo htmlspecialchars($task['title']); ?>" required />
        <textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($task['description']); ?></textarea>
        <input type="date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required />
        <select name="category_id" required>
            <?php
                $categories_query = "SELECT * FROM categories";
                $categories_result = mysqli_query($conn, $categories_query);

                while ($category = mysqli_fetch_assoc($categories_result)) {
                    $selected = $category['id'] == $task['category_id'] ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                }
            ?>
        </select>
        <button type="submit">Update Task</button>
    </form>
</div>

</body>
</html>
