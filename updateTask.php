<?php
require "connection.php";
session_start();

// Redirect if no task ID is provided
if (!isset($_GET['task_id'])) {
    echo "Invalid request.";
    exit();
}

$task_id = intval($_GET['task_id']);

// Fetch task details
$query = "SELECT * FROM tasks WHERE id = $task_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $task = mysqli_fetch_assoc($result);
} else {
    echo "Task not found.";
    exit();
}

// Update task on form submission
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

$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'light-mode';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <link rel="stylesheet" href="./style/updateTask.css">
</head>

<body class="<?php echo $theme; ?>">
    <div class="container <?php echo $theme; ?>">
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
                    echo "<option value='{$category['id']}' $selected>" . htmlspecialchars($category['name']) . "</option>";
                }
                ?>
            </select>
            <button class="button update <?php echo $theme; ?>" type="submit">Update Task</button>
        </form>
    </div>
    <script src="./js/main.js"></script>
</body>

</html>
